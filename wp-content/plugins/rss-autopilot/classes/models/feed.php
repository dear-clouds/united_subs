<?php

namespace RSSAutopilot;

use PicoFeed\Reader\Reader;
use PicoFeed\Config\Config;
use PicoFeed\Scraper\Scraper;

require_once(RSSAP_PLUGIN_DIR.'/classes/libs/autoload.php');

/**
 * Class FeedModel
 * @package RSSAutopilot
 */
class FeedModel {

    // Custom post type
    const post_type = 'rssap-feed';

    // post ID
    public $id = null;

    // post title
    public $title;

    // other post properties stored as post_meta
    private $properties = array();

    /**
     * Init new feed
     * @param array|int $data
     */
    public function __construct($data=array())
    {
        if (is_numeric($data)) {
            $this->id = $data;
            $this->load();
        } else {
            if (is_array($data) && count($data)) {
                $this->setValues($data);
            }
        }
    }

    /**
     * Magic get method for feed properties
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * Magic set method for feed properties
     * @param $name
     * @param $value
     * @return mixed|null
     */
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * Init feed with information from DB
     */
    private function load()
    {
        if ($this->id) {
            $post = get_post( $this->id );
            if (!$post) {
                $this->id = null;
                return;
            }
            $this->title = $post->post_title;
            $this->id = $post->ID;
            $meta = get_post_meta($post->ID);
            foreach ($meta as $key=>$item) {
                $newKey = substr($key, 1);
                $this->properties[$newKey] = $item[0];
                if ($newKey == 'post_category') {
                    $this->properties[$newKey] = unserialize($item[0]);
                }
            }
        }
    }

    /**
     * Save feed information
     * @return int|\WP_Error
     */
    public function save()
    {
        if ( !$this->id ) {
            $postId = wp_insert_post(
                array(
                    'post_type' => self::post_type,
                    'post_status' => 'publish',
                    'post_title' => $this->title
                )
            );
        } else {
            // Delete post meta
            $meta = get_post_meta($this->id);
            foreach ($meta as $key=>$item) {
                delete_post_meta($this->id, $key);
            }

            $postId = wp_update_post(
                array(
                    'ID' => (int) $this->id,
                    'post_status' => 'publish',
                    'post_title' => $this->title,
                    'post_type' => self::post_type,
                )
            );

        }

        if ( $postId ) {

            foreach ( $this->properties as $key => $value ) {
                update_post_meta( $postId, '_' . $key, $value );
            }
        }

        return $postId;
    }

    /**
     * Delete feed
     * @return bool
     */
    public function delete()
    {
        if ($this->id) {
            if ( wp_delete_post( $this->id, true ) ) {
                $this->id = 0;

                return true;
            }
        }
        return false;
    }

    /**
     * Set model properties
     * @param array $data
     */
    public function setValues($data)
    {
        if (isset($data['id']) && $data['id']) {
            $this->id = $data['id'];
        }

        if (isset($data['title']) && $data['title']) {
            $this->title = $data['title'];
        }

        if (isset($data['url']) && $data['url']) {
            $data['url'] = trim(str_replace('feed://', 'http://', $data['url']));
        }

        $fields = array(
            'url','author','status','display_readmore','readmore_template','update_frequency','enable_scrapper',
            'thumbnail','post_category', 'use_date', 'type', 'download_images', 'add_canonical',
            'last_update', 'last_modified', 'etag',
            'campaign_status',
            'content_extractor_rule', 'content_extractor_ignore_rule',
            'enable_filters', 'filter_keywords_must', 'filter_keywords_block'
        );

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $this->properties[$field] = $data[$field];
            }
        }
    }

    /**
     * Get first page from news feed
     */
    public function getFirstPage($downloader)
    {
        try {
            $reader = new Reader;
            $resource = $reader->download($this->url);

            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            $feed = $parser->execute();

            $article = null;

            foreach ($feed->items as $item) {
                $article = $this->grabContent($item->getUrl(), $downloader);
                return $article;
            }

            return $article;
        } catch (PicoFeedException $e) {
            return false;
        }
    }

    private function grabContent($url, $downloader)
    {
        if (!function_exists('file_get_html')) {
            require_once(RSSAP_PLUGIN_DIR.'/classes/libs/simplehtml/simple_html_dom.php');
        }

        $parts = parse_url($url);
        $domain = $parts['scheme'].'://'.$parts['host'];

        if (isset($parts['port']) && $parts['port'] && ($parts['port'] != '80')) {
            $domain .= ':'.$parts['port'];
        }

        // Relative path URL
        $relativeUrl = $domain;
        if (isset($parts['path']) && $parts['path']) {
            $pathParts = explode('/', $parts['path']);
            if (count($pathParts)) {
                unset($pathParts[count($pathParts)-1]);
                $relativeUrl = $domain.'/'.implode('/',$pathParts);
            }
        }

        $html = file_get_html($url);

        // Remove all script tags
        foreach($html->find('script') as $element) {
            $element->outertext = '';
        }

        // Remove meta
        foreach($html->find('meta[http-equiv*=refresh]') as $meta) {
            $meta->outertext = '';
        }

        // Remove meta x-frame
        foreach($html->find('meta[http-equiv*=x-frame-options]') as $meta) {
            $meta->outertext = '';
        }

        // Modify image and CSS URL's adding domain name if needed
        foreach($html->find('img') as $element) {
            $src = trim($element->src);
            if (strlen($src)>2 && (substr($src, 0, 1) == '/') && ((substr($src, 0, 2) != '//'))) {
                $src = $domain.$src;
            } elseif (substr($src, 0, 4) != 'http') {
                $src = $relativeUrl .'/'.$src;
            }
            if (strpos($downloader, '?')) {
                $element->src = $downloader.'&url='.base64_encode($src);
            } else {
                $element->src = $downloader.'?url='.base64_encode($src);
            }
        }

        // Replace all styles URL’s
        foreach($html->find('link') as $element) {
            $src = trim($element->href);
            if (strlen($src)>2 && (substr($src, 0, 1) == '/') && ((substr($src, 0, 2) != '//'))) {
                $src = $domain.$src;
            } elseif ((substr($src, 0, 4) != 'http') && (substr($src, 0, 2) != '//')) {
                $src = $relativeUrl .'/'.$src;
            }
            $element->href = $src;
        }

        // Append our JavaScript and CSS
        //$head = $html->find("head", 0);
        $scripts = '<script type="text/javascript" src="'.rssap_plugin_url( 'admin/js/jquery.js' ).'"></script>';
        $scripts .= '<script type="text/javascript" src="'.rssap_plugin_url( 'admin/js/extractor.js' ).'?'.time().'"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.rssap_plugin_url( 'admin/css/extractor.css' ).'">';

        //$head->innertext .= $scripts;

        $html = str_replace('</body>', $scripts.'</body>', $html);

        return $html;
    }

    /**
     * Get news list
     * @param int $limit
     * @return bool
     */
    public function getNews($limit=0, $fullHtml=false)
    {
        try {
            $reader = new Reader;
            $resource = $reader->download($this->url);

            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            $feed = $parser->execute();

            $list = array();
            $i=0;

            $config = new Config();

            if ($this->enable_scrapper && ($this->content_extractor_rule || $this->content_extractor_ignore_rule)) {
                $rules = array(
                    'grabber' => array(
                        '%.*%' => array(
                            'body' => array(),
                            'strip' => array(),
                        )
                    )
                );

                if ($this->content_extractor_rule) {
                    $rules['grabber']['%.*%']['body'][] = stripslashes($this->content_extractor_rule);
                }

                if ($this->content_extractor_ignore_rule) {
                    $ignoreRules = explode(',', $this->content_extractor_ignore_rule);
                    foreach ($ignoreRules as $ignoreRule) {
                        if (trim($ignoreRule)) {
                            $rules['grabber']['%.*%']['strip'][] = stripslashes(trim($ignoreRule));
                        }
                    }

                }

                $config->setGrabberRules($rules);
            }

            $grabber = new Scraper($config);

            if ($this->enable_scrapper && $this->content_extractor_rule) {
                $grabber->setInternalRules($rules);
            }

            foreach ($feed->items as $item) {
                if ($limit && ($i>=$limit)) {
                    break;
                }

                $row = array(
                    'title' => $item->getTitle(),
                    'content' => $item->getContent(),
                    'url' => $item->getUrl()
                );

                if ($this->enable_scrapper || $fullHtml) {
                    $grabber->setUrl($row['url']);
                    $grabber->execute();

                    if ($fullHtml) {
                        $row['content'] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $grabber->getRawContent());
                    } elseif ($grabber->hasRelevantContent()) {
                        $row['content'] = $grabber->getFilteredContent();
                    }
                }

                if ($row['content']) {
                    if ($this->thumbnail == 'feed') {
                        $row['thumbnail'] = @$item->getTag('media:content', 'url');

                        if ($row['thumbnail'] && is_string($row['thumbnail'])) {

                        } else {
                            $row['thumbnail'] = @$item->getTag('media:thumbnail', 'url');
                        }

                        if ($row['thumbnail'] && is_string($row['thumbnail']) && substr(trim($row['thumbnail']), 0, 4) != 'http') {
                            $xpath = new \DOMXPath(@\DOMDocument::loadHTML($row['thumbnail']));
                            $row['thumbnail'] = $xpath->evaluate("string(//img/@src)");
                        }
                    } elseif ($this->thumbnail == 'content') {
                        // Parse images, get first one
                        $xpath = new \DOMXPath(@\DOMDocument::loadHTML($row['content']));
                        $row['thumbnail'] = $xpath->evaluate("string(//img/@src)");
                    }
                } else {
                    continue;
                }


                $list[] = $row;
                $i++;
            }

            return $list;
        } catch (PicoFeedException $e) {
            return false;
        }
    }

    /**
     * Update news
     * @return bool
     */
    public function updateNews()
    {
        try {
            $etag = $this->etag;
            $last_modified = $this->last_modified;

            $reader = new Reader;

            $resource = $reader->download($this->url);

            // ToDo: Investigate strange issue with some feeds and uncomment next lines
            //$resource = $reader->download($this->url, $last_modified, $etag);

            logRSSAutoPilot('URL downloaded: '.$this->url);

            if ($resource->isModified() || true) {
                $parser = $reader->getParser(
                    $resource->getUrl(),
                    $resource->getContent(),
                    $resource->getEncoding()
                );

                $feed = $parser->execute();

                logRSSAutoPilot('Items to add: '.count($feed->items));


                $config = new Config();
                $grabber = new Scraper($config);

                if ($this->enable_scrapper && ($this->content_extractor_rule || $this->content_extractor_ignore_rule)) {
                    $rules = array(
                        'grabber' => array(
                            '%.*%' => array(
                                'body' => array(),
                                'strip' => array(),
                            )
                        )
                    );

                    if ($this->content_extractor_rule) {
                        $rules['grabber']['%.*%']['body'][] = stripslashes($this->content_extractor_rule);
                    }

                    if ($this->content_extractor_ignore_rule) {
                        $ignoreRules = explode(',', $this->content_extractor_ignore_rule);
                        foreach ($ignoreRules as $ignoreRule) {
                            if (trim($ignoreRule)) {
                                $rules['grabber']['%.*%']['strip'][] = stripslashes(trim($ignoreRule));
                            }
                        }

                    }

                    $grabber->setInternalRules($rules);
                }

                foreach ($feed->items as $item) {
                    // Set main info
                    $title = $item->getTitle();
                    $url = $item->getUrl();
                    $content = $item->getContent();
                    $excerpt = strip_tags($content);
                    $thumbnail = '';

                    // Additional fields
                    $pubDate = $item->getDate();
                    $language = $item->getLanguage();              // Item language
                    $author = $item->getAuthor();                  // Item author
                    $isRTL = $item->isRTL();

                    logRSSAutoPilot('Loading '.$title);

                    // Check if record with such title already exists
                    $existingPost = get_page_by_title($title, OBJECT, $this->type?$this->type:'post');

                    if ($existingPost && $existingPost->ID) {
                        continue;
                    }

                    // Collect all info in a row
                    if ($this->enable_scrapper) {

                        $grabber->setUrl($url);
                        $grabber->execute();

                        if ($grabber->hasRelevantContent()) {
                            logRSSAutoPilot('Page downloaded');
                            $content = $grabber->getFilteredContent();
                        }
                    }

                    // Check content and title against filters
                    if ($this->enable_filters) {
                        if ($this->filter_keywords_must) {
                            if (
                                ($this->containsWords($title, $this->filter_keywords_must))
                                || ($this->containsWords($excerpt, $this->filter_keywords_must))
                                || ($this->containsWords($content, $this->filter_keywords_must))
                            ) {
                                logRSSAutoPilot('Required keywords found');
                            } else {
                                logRSSAutoPilot('Required keywords not found');
                                continue;
                            }
                        }

                        if ($this->filter_keywords_block) {
                            if (
                                ($this->containsWords($title, $this->filter_keywords_block))
                                || ($this->containsWords($excerpt, $this->filter_keywords_block))
                                || ($this->containsWords($content, $this->filter_keywords_block))
                            ) {
                                logRSSAutoPilot('Blocked keywords found');
                                continue;
                            } else {
                                logRSSAutoPilot('Block keywords not found');
                            }
                        }
                    }

                    if ($content) {
                        // Set thumbnail
                        if ($this->thumbnail == 'feed') {
                            $thumbnail = @$item->getTag('media:content', 'url');

                            if ($thumbnail && is_string($thumbnail)) {
                            } else {
                                $thumbnail = @$item->getTag('media:thumbnail', 'url');
                            }

                            if ($thumbnail && is_string($thumbnail) && substr(trim($thumbnail), 0, 4) != 'http') {
                                $xpath = new \DOMXPath(@\DOMDocument::loadHTML($thumbnail));
                                $thumbnail = $xpath->evaluate("string(//img/@src)");
                            }
                        } elseif ($this->thumbnail == 'content') {
                            // Parse images, get first one
                            $xpath = new \DOMXPath(@\DOMDocument::loadHTML($content));
                            $thumbnail = $xpath->evaluate("string(//img/@src)");
                        }

                        // Append read more link
                        if ($this->display_readmore && $this->readmore_template) {
                            $content .= str_replace('%LINK%', $url, $this->readmore_template);
                        }

                    } else {
                        continue;
                    }


                    // Create post
                    $post = array(
                        'post_content'   => $content,
                        'post_title'     => $title,
                        'post_status'    => $this->status,
                        'post_type'      => 'post',
                        'post_author'    => $this->author,
                        'post_excerpt'   => $excerpt,
                        'post_category'  => $this->post_category
                    );

                    if ($this->type) {
                        $post['post_type'] = $this->type;
                    }

                    if ($this->use_date && $pubDate) {
                        $post['post_date'] = $pubDate->format('Y-m-d H:i:s');
                    }

                    logRSSAutoPilot('Saving '.$title);
                    $postId = wp_insert_post($post);
                    logRSSAutoPilot('Saved '.$title);

                    // Create post meta
                    if ($postId) {
                        if ($pubDate) {
                            update_post_meta($postId, '_rss_pub_date', $pubDate);
                        }

                        if ($author) {
                            update_post_meta($postId, '_rss_author', $author);
                        }

                        if ($language) {
                            update_post_meta($postId, '_rss_language', $language);
                        }

                        if ($isRTL) {
                            update_post_meta($postId, '_rss_is_rtl', $isRTL);
                        }

                        update_post_meta($postId, '_rss_original_url', $url);

                        update_post_meta($postId, '_rss_feed_id', $this->id);
                    }

                    // Create image if any
                    if ($thumbnail && $postId) {
                        logRSSAutoPilot('Thumbnail found: '.$thumbnail);
                        $tmp = \download_url( $thumbnail );
                        $file_array = array();

                        preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $thumbnail, $matches);
                        if ($matches[0]) {
                            $file_array['name'] = basename($matches[0]);
                            $file_array['tmp_name'] = $tmp;

                            if ( is_wp_error( $tmp ) ) {
                                @unlink($file_array['tmp_name']);
                                $file_array['tmp_name'] = '';
                            } else {
                                // do the validation and storage stuff
                                $thumbnailId = \media_handle_sideload( $file_array, $postId, '');

                                // If error storing permanently, unlink
                                if ( is_wp_error($thumbnailId) ) {
                                    @unlink($file_array['tmp_name']);
                                } else {
                                    \set_post_thumbnail( $postId, $thumbnailId );
                                    logRSSAutoPilot('Thumbnail saved');
                                }
                            }
                        }
                    }

                    // Download images
                    if ($postId && $this->download_images) {
                        logRSSAutoPilot('Downloading images');
                        $parts = parse_url($url);
                        $domain = $parts['scheme'].'://'.$parts['host'];

                        if (isset($parts['port']) && $parts['port'] && ($parts['port'] != '80')) {
                            $domain .= ':'.$parts['port'];
                        }

                        // Relative path URL
                        $relativeUrl = $domain;
                        if (isset($parts['path']) && $parts['path']) {
                            $pathParts = explode('/', $parts['path']);
                            if (count($pathParts)) {
                                unset($pathParts[count($pathParts)-1]);
                                $relativeUrl = $domain.'/'.implode('/',$pathParts);
                            }
                        }

                        $document = @\DOMDocument::loadHTML($content);
                        if ($document) {
                            $xpath = new \DOMXPath($document);

                            $imageList = $xpath->query("//img[@src]");
                            for($i=0;$i<$imageList->length; $i++){
                                $origSrc = $src = trim($imageList->item($i)->getAttribute("src"));
                                $newSrc = '';

                                if (strlen($src)>2 && (substr($src, 0, 1) == '/') && ((substr($src, 0, 2) != '//'))) {
                                    $src = $domain.$src;
                                } elseif (substr($src, 0, 4) != 'http') {
                                    $src = $relativeUrl .'/'.$src;
                                }
                                logRSSAutoPilot('Image: '.$src);

                                $tmp = \download_url( $src );
                                $file_array = array();

                                preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $src, $matches);
                                if ($matches[0]) {
                                    $file_array['name'] = basename($matches[0]);
                                    $file_array['tmp_name'] = $tmp;

                                    if ( is_wp_error( $tmp ) ) {
                                        @unlink($file_array['tmp_name']);
                                        $file_array['tmp_name'] = '';
                                    } else {
                                        // do the validation and storage stuff
                                        $imageId = \media_handle_sideload( $file_array, $postId, '');

                                        // If error storing permanently, unlink
                                        if ( is_wp_error($imageId) ) {
                                            @unlink($file_array['tmp_name']);
                                        } else {
                                            $newSrc = wp_get_attachment_url($imageId);
                                            logRSSAutoPilot('New Image URL: '.$newSrc);
                                        }
                                    }
                                } else {
                                    @unlink($tmp);
                                }

                                if ($newSrc) {
                                    $content = str_replace($origSrc, $newSrc, $content);
                                }
                            }

                            $updatedPost = array(
                                'ID'           => $postId,
                                'post_content' => $content,
                            );

                            // Update the post into the database
                            wp_update_post( $updatedPost );
                        }

                        logRSSAutoPilot('Download complete');
                    }
                }

                $this->etag = $resource->getEtag();
                $this->last_modified = $resource->getLastModified();
            }
        } catch (PicoFeedException $e) {
            return false;
        }
    }

    /**
     * Check if text contains any of specified words
     * @param $text
     * @param $words
     * @return bool
     */
    private function containsWords($text, $words)
    {
        $wordsList = explode(',', $words);

        if ($wordsList && count($wordsList)) {
            foreach ($wordsList as $word) {
                if ($word && (strpos(strtolower($text), strtolower($word)) !== false)) {
                    return true;
                }
            }
        }

        return false;
    }
}

?>