<ul>
	<?php while ( bbp_topics() ) : bbp_the_topic(); ?>
		<?php bbp_get_template_part( 'loop', 'mysingle-topic' ); ?>
	<?php endwhile; ?>
</ul>
