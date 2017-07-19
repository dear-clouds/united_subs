<?php
function mom_posts_share($id, $url, $style=null) {
    $url = esc_url($url);
    $desc = esc_attr(wp_html_excerpt(strip_shortcodes(get_the_content()), 160));
    $img = esc_url(mom_post_image('large'));
    $title = esc_attr(get_the_title());
    $window_title = __('Share This', 'framework');
    $window_width = 600;
    $window_height = 455;
?>
<script>
    jQuery(document).ready(function($) {
        var url = '<?php echo $url; ?>';
        <?php
/*
        if(mom_option('sharee_tw') != 0) {
        // twitter
         jQuery.getJSON(
            'ht'+'tp://urls.api.twitter.com/1/urls/count.json?url='+url+'&callback=?',
            function (data) {
		    //console.log(data.count);
		    $('.share-twitter .count').text(data.count);
                }
        );
        //delete_transient('mom_share_twitter_'.$id);

        $twitter = get_transient('mom_share_twitter_'.$id);
        if ($twitter == null) {
            $twitter_url = wp_remote_get('http://urls.api.twitter.com/1/urls/count.json?url='.$url);
            if (!is_wp_error($twitter_url)) {
            $twitter = json_decode($twitter_url['body'], true);
            $twitter = $twitter['count'];
            set_transient('mom_share_twitter_'.$id, $twitter, 1800);
            } else {
            $twitter = 0;
            }
        }
        }
*/
        ?>
		<?php if(mom_option('sharee_fb') != 0) {
        //facebook
        delete_transient('mom_share_facebook_'.$id);
        $facebook = get_transient('mom_share_facebook_'.$id);
        if ($facebook == null) {
        $facebook_url = wp_remote_get('http://api.facebook.com/method/links.getStats?urls='.$url.'&format=json');
            if (!is_wp_error($facebook_url)) {
            $facebook = json_decode($facebook_url['body'], true);
            $share_count = isset($facebook[0]['total_count']) ? $facebook[0]['total_count'] : 0;
            //$like_count = isset($facebook[0]['like_count']) ? $facebook[0]['like_count'] : 0;
                $facebook = $share_count;
            set_transient('mom_share_facebook_'.$id, $facebook, 2000);
            } else {
            $facebook = 0;
            }
        }
        // facebook
        /* jQuery.getJSON(
            'ht'+'tp://api.facebook.com/method/links.getStats?urls='+url+'&format=json',
            function (data) {
                //console.log(data[0].like_count);
				if( data[0] !== undefined ){
	                $('.share-facebook .count').text(data[0].like_count);
                // console.log(data);
                }
            }
        ); */
        } ?>
		<?php if(mom_option('sharee_lin') != 0) { ?>
        // linkedin
        jQuery.getJSON(
	    'http://www.linkedin.com/countserv/count/share?format=jsonp&url='+url+'&callback=?',
            function (data) {

                //console.log(data.count);
                $('.share-linkedin .count').text(data.count);
            }
        );
        <?php } ?>
		<?php if(mom_option('sharee_pin') != 0) { ?>
        // Pintrest
        jQuery.getJSON(
	    'http://api.pinterest.com/v1/urls/count.json?url='+url+'&callback=?',
            function (data) {
                //console.log(data.count);
                $('.share-pin .count').text(data.count);
            }
        );
        <?php } ?>
    });


</script>
<?php
	$plusone = 0;
	$plusone = mom_getGoogleCount($url);
?>
		<div class="mom-share-post">
		        <h4><?php _e( 'share', 'framework' ) ?></h4>
		        <div class="mom-share-buttons">
		            	<?php if(mom_option('sharee_fb') != 0) { ?>
		                <a href="#" onclick="window.open('http://www.facebook.com/sharer/sharer.php?m2w&s=100&p&#91;url&#93;=<?php echo $url; ?>', '<?php echo $window_title; ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no, width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-facebook"><i class="enotype-icon-facebook"></i><span class="count"><?php echo $facebook; ?></span></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_tw') != 0) { ?>
		                <a href="#" onclick="window.open('http://twitter.com/share?text=<?php echo $title; ?>&url=<?php echo $url; ?>', '<?php _e('Post this On twitter', 'theme'); ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-twitter"><i class="momizat-icon-twitter"></i><span class="count"><?php //echo $twitter; ?></span></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_go') != 0) { ?>
		                <a href="#" onclick="window.open('https://plus.google.com/share?url=<?php echo $url; ?>', 'Share', 'width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-google"><i class="momizat-icon-google-plus"></i><span class="count"><?php echo $plusone; ?></span></a>
		                <?php } ?>
                        <?php echo do_shortcode('[mom_whatsapp]<i class="fa-icon-whatsapp"></i>[/mom_whatsapp]'); ?>
		                <?php if(mom_option('sharee_lin') != 0) { ?>
		                <a href="#" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php print(urlencode(the_title())); ?>&source=<?php echo home_url(); ?>', 'Share This', 'width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-linkedin"><i class="fa-icon-linkedin"></i><span class="count">0</span></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_pin') != 0) { ?>
		                <a href="#" onclick="window.open('http://pinterest.com/pin/create/bookmarklet/?media=<?php echo mom_post_image('medium'); ?>&amp;url=<?php echo $url;?>&amp;is_video=false&amp;description=<?php echo $title;?>', 'Share this', 'width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-pin"><i class="enotype-icon-pinterest"></i><span class="count">0</span></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_vk') != 0) { ?>
		                <a href="#" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo $url; ?>&title=<?php print(urlencode(the_title())); ?>&image=<?php echo $img; ?>&description=<?php echo $desc; ?>', 'Share this', 'width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-vk"><i class="fa-icon-vk"></i></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_xing') != 0) { ?>
		                <a href="#" onclick="window.open('https://www.xing.com/social_plugins/share?url=<?php echo $url; ?>&wtmc=XING;&sc_p=xing-share', 'Share this', 'width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');" class="share-vk"><i class="fa-icon-xing"></i></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_mail') != 0) { ?>
		                <a href="mailto:?subject=<?php print(urlencode(the_title())); ?>&body=<?php print(urlencode(wp_html_excerpt(get_the_content(), 160))); ?><?php __('Read More', 'framework'); ?> : <?php echo $url; ?>" class="share-email"><i class="dashicons dashicons-email-alt"></i></a>
		                <?php } ?>
		                <?php if(mom_option('sharee_print') != 0) { ?>
		                <a href="javascript:window.print()" rel="nofollow" class="share-email"><i class="brankic-icon-printer"></i></a>
		                <?php } ?>
		        </div>
		        <!--
<a href="#" class="sh_arrow"><span><?php _e( 'More', 'framework' ) ?></span><br>
		            <i class="icon-double-angle-down"></i>
		        </a>
-->
		</div>
<?php
}
function mom_getGoogleCount($url) {
    $googleURL = wp_remote_get('https://plusone.google.com/_/+1/fastbutton?url=' .  $url );
    if (!is_wp_error($googleURL)) {
    preg_match('/window\.__SSR = {c: ([\d]+)/', $googleURL['body'], $results);
    if( isset($results[0]))
        return (int) str_replace('window.__SSR = {c: ', '', $results[0]);
    return "0";
    } else {
	return '0';
    }
}
?>
