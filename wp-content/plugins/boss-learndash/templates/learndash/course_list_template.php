<?php 
    global $post;
    $post_id = $post->ID;
    $post_title = $post->post_title;
    $user_info = get_userdata( absint( $post->post_author ) );
    $author_link = get_author_posts_url( absint( $post->post_author ) );
    $author_avatar = get_avatar( $post->post_author, 75 );
    $author_display_name = $user_info->display_name;
    $author_id = $post->post_author;
    $total_lessons = learndash_get_course_lessons_list($post_id);
?>
<div class="<?php echo esc_attr( join( ' ', get_post_class( array( 'course', 'post' ), $post_id ) ) ); ?>">
    <div class="course-inner">
        <div class="course-image">
            <div class="course-mask"></div>
            <div class="course-overlay">
                <a href="<?php echo $author_link; ?>" title="<?php echo esc_attr( $author_display_name ); ?>">
                <?php echo $author_avatar; ?>
                </a>
                <a href="<?php echo get_permalink( $post_id ); ?>" title="<?php echo esc_attr( $post_title ); ?>" class="play">
                    <i class="fa fa-play"></i>
                </a>
            </div>
            <?php
            if ( has_post_thumbnail( $post_id ) ) {
                // Get Featured Image
                $img = get_the_post_thumbnail( $post_id, 'course-archive-thumb', array( 'class' => 'woo-image thumbnail alignleft') );

            } else {
                $img = '<img src="http://placehold.it/360x250&text=Course">';
            }
            echo '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( $post_title ) . '">' . $img . '</a>';
            ?>
        </div>

        <section class="entry">
            <div class="course-flexible-area">
                <header>
                    <h2><a href="<?php echo get_permalink( $post_id ); ?>" title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_attr( $post_title ); ?></a></h2>
                </header>               
                <p class="sensei-course-meta">
                   <span class="course-author"><?php _e( 'by ', 'boss-learndash' ); ?><a href="<?php echo $author_link; ?>" title="<?php echo esc_attr( $author_display_name ); ?>"><?php echo esc_html( $author_display_name   ); ?></a></span>
                </p>
            </div>
            <p class="sensei-course-meta">
               <span class="course-lesson-count"><?php echo count($total_lessons) . '&nbsp;' . apply_filters( 'learndash_lessons_text', __( 'Lessons', 'boss-learndash' ) ); ?></span>
               <?php //sensei_simple_course_price( $post_id ); ?>
            </p>
        </section>
    </div>
</div>