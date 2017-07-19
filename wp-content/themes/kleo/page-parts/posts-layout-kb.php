<?php get_header(); ?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php if ( category_description() ) : ?>
    <div class="archive-description"><?php echo category_description(); ?></div>
<?php endif; ?>

<?php

    // Get current category info
    $category = get_category( get_query_var('cat') );

    // Get knowledge base sections
    $kb_sections = get_categories( array( 'hide_empty' => 0 ) );

    $return = '';

    if ( $kb_sections ) { // If current category has sub-categories, show the kb wall

        // For each knowledge base root section
        foreach ( $kb_sections as $section ) :

            if ( $section->parent == $category->term_id ) {

                $return .= '<div class="col-xs-12 col-sm-6 col-md-4"><div class="kb_section">';

                // Display root section name
                $return .= '<h4 class="kb-section-name"><i class="icon  icon-folder-open-empty"></i><a href="' . esc_url( get_term_link( $section ) ) . '" title="' . esc_attr( $section->name ) . '" >' . esc_html( $section->name ) . '</a></h4>';
                $return .= '<ul class="kb-wall-list">';

                // Display sub sections
                foreach ( $kb_sections as $sub_section ) {
                    if ( $section->term_id == $sub_section->parent ) {
                        $return .= '<li class="kb-section-name"><i class="icon icon-folder-empty"></i>';
                        $return .= '<a href="' . esc_url( get_term_link( $sub_section ) ) . '" rel="bookmark" title="' . esc_attr( $sub_section->name ) . '">' . esc_html( $sub_section->name ) . '</a>';
                        $return .= '</li>';
                    }
                }

                // Fetch posts in the root section
                $kb_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => apply_filters( 'kleo_kb_category_posts_per_page', 5 ),
                    'category__in' => $section->term_id,
                );
                $the_query = new WP_Query( $kb_args );

                // Display posts in the root section
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $return .= '<li class="kb-article-name"><i class="icon icon-doc-text"></i>';
                        $return .= '<a href="' . esc_url( get_permalink( $the_query->ID ) ) . '" rel="bookmark" title="' . esc_attr( get_the_title( $the_query->ID ) ) . '">' . esc_html( get_the_title( $the_query->ID ) ) . '</a>';
                        $return .= '</li>';
                    endwhile;
                    $return .= '<li class="kb-view-more">';
                    $return .= '<a href="' . esc_url( get_term_link( $section ) ) . '" title="' . esc_attr( $section->name ) . '" class="btn-default">' . __( '+ More from', 'kleo_framework' ) . ' ' . esc_html( $section->name ) . '</a>';
                    $return .= '</li>';
                endif;

                wp_reset_postdata();

                $return .= '</ul>';
                $return .= '</div></div>';

            }

        endforeach;

        if( $return ){
            $return = '<div class="row kb-archive">' . $return . '</div>';
        }

    }

    if ( !$return ) { // If current category don't have sub-categories, show the kb wall
        if ( have_posts() ) :
            $return .= '<ul class="kb-archive-listing">';
            while ( have_posts() ) : the_post();
                $return .= '<li class="kb-article-name">';
                $return .= '<h2 class="post-title"><i class="icon icon-doc-text"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
                $return .= kleo_excerpt( 100 );
                $return .= '<a href="' . esc_url( get_permalink() ) . '" class="btn btn-default">' . __( 'Read more', 'kleo_framework' ) . '</a><br><br>';
                $return .= '</li>';
            endwhile;
            $return .= '</ul>';
            $return .= kleo_pagination( '', false );
        else:
            $return .= '<p>' . __( 'Sorry, there are no articles here yet.' , 'kleo_framework' ) . '</p>';
        endif;
    }

    echo $return;

?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>