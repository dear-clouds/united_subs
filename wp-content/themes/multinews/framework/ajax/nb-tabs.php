<?php

// ajax call init 
add_action( 'init', 'mom_mu_nb_init' );
function mom_mu_nb_init() {
    global $wp_query;
	// add scripts
        wp_register_script( 'mom_ajax_nb_tabs', get_template_directory_uri().'/framework/ajax/nb-tabs.js',  array('jquery'),'1.0',true);
	wp_enqueue_script( 'mom_ajax_nb_tabs');
        
   
        // localize the script 
        wp_localize_script( 'mom_ajax_nb_tabs', 'nbtabs', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' ),
		)
	);
        
        
        // ajax Action
        add_action( 'wp_ajax_nbtabs', 'mom_nb_tabs' );  
        add_action( 'wp_ajax_nopriv_nbtabs', 'mom_nb_tabs');
}

function mom_nb_tabs() {
    // stay away from bad guys 
    $nonce = $_POST['nonce'];
    $nbs = $_POST['nbs'];
    $number_of_posts = $_POST['number_of_posts'];
    $cat = $_POST['cat'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
?>
               <?php if ($nbs == 'nb1') { ?>
                                <?php
				query_posts( array('posts_per_page' => $number_of_posts, 'post_status' => 'publish', 'cat' => $cat));
                                if ( have_posts() ) : while ( have_posts() ) : the_post();
				?>
                                <li <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
                                    <?php if( mom_post_image() != false ) { ?>
                                    <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                        <img itemprop="image" src="<?php echo mom_post_image('nb1-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                        <span class="post-format-icon"></span>
                                    </a></figure>
                                    <?php } ?>
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
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_query();
                                ?>
	       <?php } elseif ($nbs == 'nb2') { ?>
	                    <?php
			    $nb2_first_query = new WP_Query( array('posts_per_page' => 1,'post_status' => 'publish', 'cat' => $cat));
                            if ( $nb2_first_query->have_posts() ) : while ( $nb2_first_query->have_posts() ) : $nb2_first_query->the_post();
                            ?>
                            <div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
                                <?php if( mom_post_image() != false ) { ?>
                                <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                    <img itemprop="image" src="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    <span class="post-format-icon"></span>
                                </a></figure>
                                <?php } ?>
                                <div class="entry-meta">
                                    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                    <div class="comments-link">
                                        <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                        
                                    </div>
                                </div>
                                <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry-content">
                                    <p>
                                        <?php global $post;
                                        $excerpt = $post->post_excerpt;
                                        if($excerpt==''){
                                        $excerpt = get_the_content('');
                                        }
                                        echo wp_html_excerpt(strip_shortcodes($excerpt), 145);
                                        ?> ...
                                    </p>
                                </div>
                            </div>
                            <?php
                            endwhile;
                            else:
                            endif;
                            wp_reset_postdata();
                            ?>
                            <ul>
                                <?php
				$nb_next_query = new WP_Query( array('posts_per_page' => $number_of_posts, 'post_status' => 'publish','offset' => 1, 'cat' => $cat));
                                if ( $nb_next_query->have_posts() ) : while ( $nb_next_query->have_posts() ) : $nb_next_query->the_post();
                                ?>
                                <li role="article" itemscope="" itemtype="http://schema.org/Article">
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                        </div>
                                        
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_postdata();
                                ?>
                            </ul>
	       <?php } elseif ($nbs == 'nb3') { ?>
		                            <?php
                                query_posts(array('showposts' => 2, 'post_status' => 'publish', 'cat' => $cat ));
                            if ( have_posts() ) : while ( have_posts() ) : the_post();
                            ?>
                            <div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
                                <?php if( mom_post_image() != false ) { ?>
                                <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                    <img itemprop="image" src="<?php echo mom_post_image('nb1-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    <span class="post-format-icon"></span>
                                </a></figure>
                                <?php } ?>
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
                                <div class="entry-meta">
                                    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                    <div class="comments-link">
                                        <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            endwhile;
                            else:
                            endif;
                            wp_reset_query();
                            ?>
                            
                            <ul>
                                <?php
                                    query_posts(array('showposts' => $number_of_posts, 'post_status' => 'publish', 'offset' => 2, 'cat' => $cat ));
                                if ( have_posts() ) : while ( have_posts() ) : the_post();
                                ?>
                                <li role="article" itemscope="" itemtype="http://schema.org/Article">
                                    <?php if( mom_post_image() != false ) { ?>
                                    <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                        <img itemprop="image" src="<?php echo mom_post_image('nb3-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    </a></figure>
                                    <?php } ?>
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number('(0)','(1)','(%)'); ?></a>
                                        </div>
                                        
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_query();
                                ?>
                            </ul>

	       <?php } elseif ($nbs == 'nb4') { ?>
		                                <?php
                                query_posts(array('showposts' => 1, 'post_status' => 'publish', 'cat' => $cat ));
                            if ( have_posts() ) : while ( have_posts() ) : the_post();
                            ?>
                            <div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
                                <?php if( mom_post_image() != false ) { ?>
                                <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                    <img itemprop="image" src="<?php echo mom_post_image('nb1-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    <span class="post-format-icon"></span>
                                </a></figure>
                                <?php } ?>
                                <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry-content">
                                    <p>
                                    <?php global $post;
                                    $excerpt = $post->post_excerpt;
                                    if($excerpt==''){
                                    $excerpt = get_the_content('');
                                    }
                                    echo wp_html_excerpt(strip_shortcodes($excerpt), 110);
                                    ?> ...
                                    </p>
                                </div>
                                <div class="entry-meta">
                                    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                    <div class="comments-link">
                                        <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            endwhile;
                            else:
                            endif;
                            wp_reset_query();
                            ?>
                            
                            <ul>
                                <?php
                                    query_posts(array('showposts' => $number_of_posts, 'post_status' => 'publish', 'offset' => 1, 'cat' => $cat ));
                                if ( have_posts() ) : while ( have_posts() ) : the_post();
                                ?>
                                <li role="article" itemscope="" itemtype="http://schema.org/Article">
                                    <?php if( mom_post_image() != false ) { ?>
                                    <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                        <img itemprop="image" src="<?php echo mom_post_image('nb3-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    </a></figure>
                                    <?php } ?>
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number('(0)','(1)','(%)'); ?></a>
                                        </div>
                                        
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_query();
                                ?>
                            </ul>

	       <?php } elseif ($nbs == 'nb5') { ?>
			                            <?php
                                query_posts(array('showposts' => 1, 'post_status' => 'publish', 'cat' => $cat ));
                            if ( have_posts() ) : while ( have_posts() ) : the_post();
                            ?>
                            <div <?php post_class('first-item'); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
                                <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <?php if( mom_post_image() != false ) { ?>
                                <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                    <img itemprop="image" src="<?php echo mom_post_image('nb5-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                    <span class="post-format-icon"></span>
                                </a></figure>
                                <?php } ?>
                                <div class="entry-content">
                                    <p>
                                    <?php global $post;
                                    $excerpt = $post->post_excerpt;
                                    if($excerpt==''){
                                    $excerpt = get_the_content('');
                                    }
                                    echo wp_html_excerpt(strip_shortcodes($excerpt), 180);
                                    ?> ...
                                    </p>
                                </div>
                                <div class="entry-meta">
                                    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                    <div class="comments-link">
                                        <i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            endwhile;
                            else:
                            endif;
                            wp_reset_query();
                            ?>
                            
                            <ul>
                                <?php
                                    query_posts(array('showposts' => $number_of_posts, 'post_status' => 'publish', 'offset' => 1, 'cat' => $cat ));
                                if ( have_posts() ) : while ( have_posts() ) : the_post();
                                ?>
                                <li role="article" itemscope="" itemtype="http://schema.org/Article">
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <a href="#"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
                                        </div>
                                        
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_query();
                                ?>
                            </ul>
	       <?php } elseif ($nbs == 'nb6') { ?>
	                                   <ul>
                                <?php
                                    query_posts(array('showposts' => $number_of_posts, 'post_status' => 'publish', 'cat' => $cat ));
                                if ( have_posts() ) : while ( have_posts() ) : the_post();
                                ?>
                                <li <?php post_class(); ?> role="article" itemscope="" itemtype="http://schema.org/Article">
                                    <?php if( mom_post_image() != false ) { ?>
                                    <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                        <img itemprop="image" src="<?php echo mom_post_image('nb6-thumb'); ?>" data-hidpi="<?php echo mom_post_image('big-thumb-hd'); ?>" alt="<?php the_title(); ?>">
                                        <span class="post-format-icon"></span>
                                    </a></figure>
                                    <?php } ?>
                                    <h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-content">
                                        <p>
                                        <?php global $post;
                                        $excerpt = $post->post_excerpt;
                                        if($excerpt==''){
                                        $excerpt = get_the_content('');
                                        }
                                        echo wp_html_excerpt(strip_shortcodes($excerpt), 120);
                                        ?> ...
                                        </p>
                                    </div>
                                    <div class="entry-meta">
                                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php mom_date_format(); ?></time>
                                        <div class="comments-link">
                                            <i class="momizat-icon-bubbles4"></i><a href="#"><?php comments_number('(0)','(1)','(%)'); ?></a>
                                        </div>
                                        
                                    </div>
                                </li>
                                <?php
                                endwhile;
                                else:
                                endif;
                                wp_reset_query();
                                ?>
                            </ul>
	       <?php } ?>
<?php 
exit();
}