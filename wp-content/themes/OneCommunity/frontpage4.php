<?php
/*
Template Name: Frontpage 4
*/
?>

<?php get_header() ?>

<div id="metro">

<div class="tile tile1">
<?php
$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=1&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<?php the_post_thumbnail('tile-1'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>
</div>


<div class="tile tile2">

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-2'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>

</div>

<div class="tile tile3">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=2&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-1'); ?>
	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>

</div>

<div class="tile tile4">

	<div class="tile tile4a">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=3&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-4'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>
	</div>

	<div class="tile tile4b">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=4&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-4'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>
	</div>

</div>

<div class="tile tile5">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=5&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-5'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>

</div>


<div class="tile tile6">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=6&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-5'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>

</div>


<div class="tile tile7">

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=7&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-7'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>

</div>
<div class="tile tile8">
<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=1&offset=8&ignore_sticky_posts=1');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<?php the_post_thumbnail('tile-8'); ?>

	<div class="tile-title"><span><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php $thetitle = $post->post_title; $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span></div>
	<div class="comment-count">
		<div class="comment-count-child"><a href="<?php the_permalink() ?>#comments-number"><?php comments_number('0', '1', '%'); ?></a></div>
	</div>

<?php endwhile; // end of loop
 $wp_query = null; $wp_query = $temp; ?>
</div>

</div><!-- #metro -->

<div id="content">

<div class="clear"> </div>

<div class="frontpage">

<?php if ( function_exists( 'bp_is_active' ) ) { ?>

<div id="tabs-container">
<div id="object-nav">
        	<ul class="tabs-nav">
                <li class="nav-one"><a href="#popular" class="current"><?php _e('Popular', 'OneCommunity'); ?></a></li>
                <li class="nav-two"><a href="#active"><?php _e('Active', 'OneCommunity'); ?></a></li>
                <li class="nav-three"><a href="#alphabetical"><?php _e('Alphabetical', 'OneCommunity'); ?></a></li>
                <li class="nav-four"><a href="#newest"><?php _e('Newest', 'OneCommunity'); ?></a></li>
            </ul>
</div>

<div class="list-wrap">

<!-- NEWEST GROUPS LOOP POPULAR -->
<?php if ( bp_has_groups( 'type=popular&max=8' ) ) : ?>

<ul id="popular">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>

<ul id="popular">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div>
<br />
</ul>

<?php endif; ?>
<!-- POPULAR GROUPS LOOP END -->

<!-- NEWEST GROUPS LOOP START -->
<?php if ( bp_has_groups( 'type=newest&max=8' ) ) : ?>

<ul id="newest" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>

<ul id="newest" class="hidden-tab">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>

<!-- NEWEST GROUPS LOOP END -->


<!-- LAST ACTIVE GROUPS LOOP START -->

<?php if ( bp_has_groups( 'type=active&max=8' ) ) : ?>

<ul id="active" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>

<ul id="active" class="hidden-tab">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<!-- LAST ACTIVE GROUPS LOOP END -->



<!-- ALPHABETICAL GROUPS LOOP -->
<?php if ( bp_has_groups( 'type=alphabetical&max=8' ) ) : ?>

<ul id="alphabetical" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<?php bp_group_member_count(); ?></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>

<ul id="alphabetical" class="hidden-tab">
    <div id="message" class="info">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<!-- ALPHABETICAL GROUPS LOOP END -->


</div> <!-- List Wrap -->
</div> <!-- tabs-container -->

<div class="clear"> </div>


<div class="frontpage-bottom-left">

<div class="front-box widget">
<div class="front-box-title"><?php _e('Active Members', 'OneCommunity'); ?></div>
<div class="front-box-child">

<?php if ( bp_has_members( 'type=active&max=8' ) ) : ?>
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" class="front-member-item" title="<?php bp_member_name(); ?>"><?php bp_member_avatar('type=full&width=60&height=60') ?></a>
			<?php endwhile; ?>
<?php endif; ?>

</div><!--front-box-child ends-->
</div><!--front-box ends-->

<div class="clear"></div>

<div class="front-box widget">
<div class="front-box-title"><?php _e('Popular Members', 'OneCommunity'); ?></div>
<div class="front-box-child">

<?php if ( bp_has_members( 'type=popular&max=8' ) ) : ?>
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" class="front-member-item" title="<?php bp_member_name(); ?>"><?php bp_member_avatar('type=full&width=60&height=60') ?></a>
			<?php endwhile; ?>
<?php endif; ?>

</div><!--front-box-child ends-->
</div><!--front-box ends-->

</div> <!-- frontpage-bottom-left -->

<?php if ( function_exists( 'bbp_has_topics' ) ) { ?>
<div class="frontpage-bottom-right">

<div class="front-box">
<div class="front-box-title"><?php _e('On the Forums', 'OneCommunity'); ?></div>

<div class="front-box-child">

	<?php if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'posts_per_page' => 5 ) ) ) : ?>
		<?php bbp_get_template_part( 'loop', 'mytopics' ); ?>
	<?php else : ?>
		<?php bbp_get_template_part( 'feedback', 'no-topics' ); ?>
	<?php endif; ?>

</div>
<div class="clear"></div>
</div>

</div> <!-- frontpage-bottom-right -->
<?php } ?>

<?php } ?>

</div><!-- .frontpage -->
<div class="clear"> </div>
</div><!-- #content -->


<div id="sidebar">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-frontpage')) : ?><?php endif; ?>
</div><!-- #sidebar -->

<?php get_footer() ?>