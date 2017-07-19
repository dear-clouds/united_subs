<?php global $theLayout, $portfolio_query, $shortcode_values;
// assign $wp_query to a temporary variable (this is part of making pagination work)
$sc = $shortcode_values;
$item_count = 1;
// some defaults and other settings
$showExcerpt = (isset($sc['excerpt']) && strtolower(trim($sc['excerpt'])) == 'yes') ? true : false;
$excerptLength = (isset($sc['excerpt_length']) && $sc['excerpt_length']) ? (int)$sc['excerpt_length'] : 50;
$showTitle = (isset($sc['title']) && strtolower(trim($sc['title'])) == 'yes') ? true : false;		
$scLink = (isset($sc['link'])) ? strtolower(trim($sc['link'])) : 'lightbox';
// figure out image size and # of columns
$columns = $sc['columns'];
$columns = (!$columns) ? 3 : $columns;
$margin = 25;
$image_container = 0; // accounts for padding and borders
$content_width = (isset($sc['content_width']) && $sc['content_width']) ? (int) $sc['content_width'] : 926;

// image ratios
if ($sc['image_ratio']) {
	$ratio = explode(':', $sc['image_ratio']);
	$x = (int)$ratio[1];
	$y = (int)$ratio[0];
	$img_ratio = ($x > 0 && $y > 0) ? $x/$y : 2/3;	
} else {
	$img_ratio = 2/3;			
}

// image and column sizes
$working_area = $content_width - ($margin * ($columns - 1));
$colW = floor($working_area / $columns);

$dataValues    = '{"cols":'.$columns.',"col_w":'.$colW.',"margin":'.$margin.',"width":'.$content_width.',"area":'.$working_area.',"ratio":'.$img_ratio.'}';
?>

<section class="content-post-list clearfix">
	<ol class="posts-list portfolio-list" data-values='<?php echo $dataValues ?>'>

	<?php
	while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
	
		
		$li_style = '';
		$li_style .= 'width: '.$colW.'px;';
		if ($item_count % $columns) { 
			// not the last
			$li_style .= ' margin-right: '.$margin.'px;';
		} else {
			// last in column
			$li_style .= ' margin-right: 0;';
		}
		$li_style = 'style="'.$li_style.'"';

		$imgW = $colW - $image_container;	// determine image size by subtracting image container (padding + border) from the column width	
		$imgH = floor($imgW * $img_ratio);	// use the selected ratio to get the image height

		// image sizes
		$imageW = $imgW;
		$imageH = $imgH;
		// get thumbnail image
		$thumb = get_post_thumbnail_id(); 
		// get resized image
		// this will return the resized $thumb or placeholder if enabled and no $thumb
		$image = vt_resize( $thumb, '', $imageW, $imageH, true );

		// linking
		$title = get_the_title(); // if media Title entered
		$class = '';
		switch ($scLink) {
			case 'none':
				$URL = '';
				break;
			case 'post':
				$URL = get_permalink();
				break;
			case 'lightbox':
			default:
				$URL = wp_get_attachment_url($thumb); // original image
				if (get_meta('media_url')) $URL = get_meta('media_url'); // if media URL entered
				if (get_meta('media_title')) $title = get_meta('media_title'); // if media Title entered
				$class .= 'popup';
		}

		$img = '<figure><img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" class="portfolio-image" style="height:'.$imageH.'px !important;" /></figure>';
		if ($URL) $img = '<a href="'.$URL.'" class="'.$class.'" title="'.$title.'" rel="portfolio_'.$sc['id'].'">'. $img .'</a>';

		?>

		<li class="portfolio-item clearfix" <?php echo $li_style; ?>>
			<article id="post-<?php the_ID(); ?>" <?php post_class('type-portfolio'); ?>>
				<div class="item-container">
					
					<div class="the-post-image">
						<?php 
						if ($image['url']) echo $img;
						?>
					</div>
					
					<?php if ($showExcerpt || $showTitle) : ?>
						<div class="the-post-content">
							<?php if ($showTitle) : ?>
							<header class="entry-header">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
							</header>
							<?php endif; ?>
							
							<?php if ($showExcerpt) : ?>
							<div class="entry-content">
								<?php echo customExcerpt(get_the_excerpt(), $excerptLength); ?>
							</div><!-- END .entry-content -->
							<?php endif; ?>
						</div>
					<?php endif; ?>
		
				</div>

			</article>
		</li>
		
		<?php 
		$item_count++;
	endwhile; 
	?>
	
	</ol>
</section>


<?php

// show paging  (< 1 3 4 >)
if ($sc['paging']) get_pagination($portfolio_query);

?>
