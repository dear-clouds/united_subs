<?php
/**
 * Kleo Social Share shortcode
 * [kleo_social_share]
 *
 * @package WordPress
 * @subpackage K Elements
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since K Elements 4.0
 */


extract( shortcode_atts( array(
    'el_class' => '',
), $atts ) );

ob_start();


?>

<div class="share-links">

    <div class="hr-title hr-long"><abbr><?php esc_html_e("Share this", "kleo_framework"); ?></abbr></div>

    <span class="kleo-love">
    <?php do_action('kleo_show_love'); ?>
    </span>

    <?php if  ( sq_option( 'blog_social_share_facebook', 1 ) ) :  ?>
    <span class="kleo-facebook">
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="post_share_facebook"
           onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;">
            <i class="icon-facebook"></i>
        </a>
    </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_twitter', 1 ) ) :  ?>
    <span class="kleo-twitter">
        <a href="https://twitter.com/share?url=<?php the_permalink(); ?>" class="post_share_twitter"
           onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;">
            <i class="icon-twitter"></i>
        </a>
    </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_googleplus', 1 ) ) :  ?>
    <span class="kleo-googleplus">
        <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
           onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
            <i class="icon-gplus"></i>
        </a>
    </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_pinterest', 1 ) ) :  ?>
    <span class="kleo-pinterest">
        <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if (function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo strip_tags(get_the_title()); ?>"
           onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
            <i class="icon-pinterest-circled"></i>
        </a>
    </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_linkedin', 0 ) ) :  ?>
        <span class="kleo-linkedin">
            <a href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>" class="post_share_linkedin"
               onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <i class="icon-linkedin"></i>
            </a>
        </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_whatsapp', 0 ) ) :  ?>
    <span class="kleo-whatsapp visible-xs-inline visible-sm-inline">
        <a href="whatsapp://send?text=<?php the_permalink(); ?>" data-action="share/whatsapp/share">
            <i class="icon-whatsapp"></i>
        </a>
    </span>
    <?php endif; ?>

    <?php if  ( sq_option( 'blog_social_share_mail', 1 ) ) :  ?>
    <span class="kleo-mail">
        <a href="mailto:?subject=<?php echo strip_tags(get_the_title()); ?>&body=<?php the_permalink(); ?>" class="post_share_email">
            <i class="icon-mail"></i>
        </a>
    </span>
    <?php endif; ?>

</div>

<?php
$output = '<div class="' . $el_class. '">'. ob_get_clean() . '</div>';