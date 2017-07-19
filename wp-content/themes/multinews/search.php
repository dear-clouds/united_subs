<?php get_header(); ?>
<?php
                $cats = get_categories();
                $category = '';
                $year = '';
                $monthnum = '';
                $filter = '';
                $sortby = '';
                if (isset($_GET['category'])) {
                           $category = htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8');
                }
                if (isset($_GET['year'])) {
                                $year = (int)$_GET['year'];
                }
                if (isset($_GET['month'])) {
                                $monthnum = (int)$_GET['month'];
                }

                if (isset($_GET['format'])) {
                                $filter = htmlspecialchars($_GET['format'], ENT_QUOTES, 'UTF-8');
                }

                if (isset($_GET['sortby'])) {
                                $sortby = htmlspecialchars($_GET['sortby'], ENT_QUOTES, 'UTF-8');
                }
                $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

                //$months = range(1,12);
                $months = array (
                                '1' => __('January', 'framework'),
                                '2' => __('February', 'framework'),
                                '3' => __('March', 'framework'),
                                '4' => __('April', 'framework'),
                                '5' => __('May', 'framework'),
                                '6' => __('June', 'framework'),
                                '7' => __('July', 'framework'),
                                '8' => __('August', 'framework'),
                                '9' => __('September', 'framework'),
                                '10' => __('October', 'framework'),
                                '11' => __('November', 'framework'),
                                '12' => __('December', 'framework')
                );
                $formats = get_theme_support( 'post-formats' );
            $filterq = '';
    if ($filter != '') {
		$filterq = array(
				array(
				    'taxonomy' => 'post_format',
				    'field' => 'slug',
				    'terms' => array('post-format-'.$filter),
				)
			);
	}
                $post_meta_hp = mom_option('post_meta_hp');
	if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}
?>

<form role="search" method="get" id="advanced-search" action="<?php echo home_url('/'); ?>">
    <div class="main-container search-page"><!--container-->
    				<?php if(mom_option('breadcrumb') != 0) { ?>
                    <?php if(mom_option('search_bread') != false) { ?>
                    <div class="entry-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <div class="crumb-icon"><i class="momizat-icon-search"></i></div>
                        <?php mom_breadcrumb(); ?>
                    </div>
                    <?php } ?>
                    <?php } ?>

                    <?php if(mom_option('adv_search') != false) { ?>
                    <section class="section advanced-search clearfix">
                                <div class="adv-search-form">
                                    <label for="adv-s"><?php _e('keywords:', 'framework'); ?></label>
                                    <input type="text" id="adv-s" class="adv-s" placeholder="<?php _e('Enter keywords', 'framework'); ?>" value="<?php echo $s; ?>" name="s" data-nokeyword="<?php _e('Keyword is required.', 'framework'); ?>">
                                    <span class="adv-s-cat">
                                            <label for="adv-cat"><?php _e('Category:', 'framework'); ?></label>
                                            <div class="select-wrap">
                                                    <select id="adv-cat" name="category">
                                                                <?php
                                                                echo '<option value="">'.__('All', 'framework').'</option>';
                                                                foreach ( $cats as $cat ) {
                                                                echo '<option value="'.$cat->term_id.'"'.selected( $category, $cat->term_id ).'>' . $cat->name . '</option>';
                                                                }
                                                                ?>
                                                    </select>
                                                    <div class="sort-arrow"></div>
                                            </div>
                                    </span>
                                    <span class="adv-s-month">
                                            <label for="adv-year"><?php _e('Date:', 'framework'); ?></label>
                                            <div class="select-wrap">
                                                    <select id="adv-year" name="year">
                                                <?php
                                                  echo '<option value="">...</option>';
                                                echo mom_get_years('year');
                                                ?>
                                                    </select>
                                                    <div class="sort-arrow"></div>
                                            </div>
                                            <div class="select-wrap">
                                                            <select id="adv-mon" name="month">
                                                                <?php
                                                                echo '<option value="">...</option>';
                                                                foreach ($months as $val => $name) { ?>
                                                                                <option value="<?php echo $val; ?>" <?php selected( $monthnum, $val ); ?>><?php echo $name; ?></option>
                                                                <?php } ?>
                                                    </select>
                                            <div class="sort-arrow"></div>
                                            </div>
                                    </span>
                                    <span class="adv-s-format">
                                            <label for="adv-format"><?php _e('Filter by:', 'framework'); ?></label>
                                            <div class="select-wrap">
                                                    <select id="adv-format" name="format">
                                                <?php
                                                echo '<option value="">'.__('All', 'framework').'</option>';
                                                foreach ($formats[0] as $format) {
                                                    $format_name = $format;
                                                        switch ($format_name) {
                                                            case 'image':
                                                            $format_name = __('Image', 'framework');
                                                                break;
                                                            case 'video':
                                                            $format_name = __('Video', 'framework');
                                                                break;
                                                            case 'audio':
                                                            $format_name = __('Audio', 'framework');
                                                                break;
                                                            case 'quote':
                                                            $format_name = __('Quote', 'framework');
                                                                break;
                                                            case 'gallery':
                                                            $format_name = __('Gallery', 'framework');
                                                                break;
                                                            case 'chat':
                                                            $format_name = __('Chat', 'framework');
                                                                break;

                                                        }
                                                    ?>
                                                                <option value="<?php echo $format; ?>" <?php selected( $filter, $format ); ?>><?php echo $format_name ?></option>
                                                <?php } ?>
                                                    </select>
                                                    <div class="sort-arrow"></div>
                                            </div>
                                    </span>
                                    <input type="hidden" name="go">
                                    <input type="submit" class="submit" value="<?php _e('Search', 'framework'); ?>">
                                </div>
                    </section>
                    <?php } ?>
            <div class="full-main-content" role="main"><!--Full width Main Content-->

                <div class="site-content page-wrap nb1">

                                <header class="block-title">
                                    <h2><?php printf( __( 'Search Results for: %s', 'framework' ), get_search_query() ); ?></h2>

                                        <?php if(mom_option('search_sort') != false) { ?>
                                        <div class="media-sort-form">
                                            <span class="media-sort-title"><?php _e('Sort by:', 'framework'); ?></span>
                                               <div class="media-sort-wrap">
                                                       <select id="media-sort" name="sortby">
                                                               <option value="DESC" <?php selected( $sortby, 'DESC' ); ?>><?php _e('Descending', 'framework'); ?></option>
                                                               <option value="ASC" <?php selected( $sortby, 'ASC' ); ?>><?php _e('Ascending', 'framework'); ?></option>
                                                       </select>
                                               <div class="sort-arrow"></div>
                                           </div>
                                       </div>
                                        <?php } ?>
                                </header>
                                <?php
                                $posts_pre_page = mom_option('search_count');
				       global $wp_query;
        if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
                                                $args = array (
                                                                's' => $s,
                                                                'category__in' => $category,
                                                                'year' => $year,
                                                                'monthnum' => $monthnum,
                                                                'paged' => $paged,
                                                                'order' => $sortby,
                                                                'tax_query' => $filterq,
                                                                'post_status' => 'publish',
                                                                'posts_pre_page' => $posts_pre_page
                                                );
                              if(mom_option('search_page_ex') == true) {
                                $args['post_type'] = 'post';
                              }

                                $query = new WP_Query($args) ;
                                if ( $query->have_posts() ) :
                                echo '<ul>';
                                while ( $query->have_posts() ) : $query->the_post();
                                ?>
                        <li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
                            <?php if (mom_post_image() != false) { ?>
                            <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                <?php mom_post_image_full('search-grid'); ?>
                                <span class="post-format-icon"></span>
                            </a></figure>
                            <?php } ?>
                            <?php if( mom_post_image() != false ) {
                            	$mom_class = ' class="fix-right-content"';
                            } else {
                                $mom_class = '';
                            }
                            ?>
                            <div<?php echo $mom_class; ?>>
                            <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="entry-content">
                                <p>
                                    <?php global $post;
                                    $excerpt = $post->post_excerpt;
                                    if($excerpt==''){
                                    $excerpt = get_the_content('');
                                    }
                                    echo wp_html_excerpt(strip_shortcodes($excerpt), 115);
                                    ?> ...
                                </p>
                            </div>
                            <?php if($post_head != 0) { ?>
                            <div class="entry-meta">
                            <?php if($post_head_date != 0) { ?>
                                <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php echo mom_date_format(); ?></time>
                                <?php } ?>
                                <?php if($post_head_commetns != 0) { ?>
                                <div class="comments-link">
                                    <i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            </div>
                        </li>
                <?php endwhile;
                echo '</ul>';
                   mom_pagination($query->max_num_pages);
                else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.', 'framework'); ?></p>
                <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </div>

            </div><!--Full width Main Content-->
    </div><!--container-->
    </form>

</div><!--wrap-->
<?php get_footer();
