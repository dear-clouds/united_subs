<?php
/**
 */

get_header(); ?>
<?php do_action('rhc_before_content'); ?>
	<div class="single-event event-page">
		<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
		
			<div class="entry-content">
				<?php echo do_shortcode('[rhc_post_info]') ?>
				<div class="single-event-gmap-holder">
				<?php echo do_shortcode('[single_venue_gmap width=960 height=250]') ?>
				</div>
				<?php the_content(); ?>
				<div class="single-event-venue-holder">
				<?php echo do_shortcode("[taxonomymeta taxonomy='".RHC_VENUE."'] <h3 class='single-event-venue-title'>{name}</h3> <div class='single-event-venue-description'>{content}</div>[/taxonomymeta]")?>
				</div>
				<?php /*echo do_shortcode('[venue]')*/ ?>
				<?php /*echo do_shortcode('[organizer]')*/ ?>
			</div>
			<div class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'rhc' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		</div>
		<?php endwhile;  ?>
	</div>
<?php do_action('rhc_after_content'); ?>
<?php get_footer(); ?>