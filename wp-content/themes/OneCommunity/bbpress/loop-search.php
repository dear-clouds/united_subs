<?php do_action( 'bbp_template_before_search_results_loop' ); ?>

<table id="topic-post-list" class="item-list" role="main">

<thead>
		<tr class="forum-head">
	
			<td class="forum-head-author"><?php  _e( 'Author',  'bbpress' ); ?></td>
			<td class="forum-head-reply">
				<?php _e( 'Search Results', 'bbpress' ); ?>
			</td>

		</tr>
</thead>

		<?php while ( bbp_search_results() ) : bbp_the_search_result(); ?>

			<?php bbp_get_template_part( 'loop', 'search-' . get_post_type() ); ?>

		<?php endwhile; ?>

</table><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_search_results_loop' ); ?>