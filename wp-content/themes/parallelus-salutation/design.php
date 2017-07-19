<!doctype html><?php global $theLayout; ?>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<?php get_header('default'); ?>
</head>

<body <?php body_class(); ?>>

<div id="Wrapper">
	<div id="Top">
		<div class="clearfix">
		
			<?php get_template_part( 'design', 'header' ); ?>
			
		</div>
	</div> <!--! end of #Top -->
	
	<div id="Middle">
		<div class="pageWrapper theContent clearfix">
			<div class="inner-1">
				<div class="inner-2 contentMargin">
			
					<?php generate_content_layout($theLayout); ?>
			
				</div>
			</div>
		</div> <!--! end of .pageWrapper -->
	</div> <!--! end of #Middle -->
	
	<div id="Bottom">		

		<?php get_template_part( 'design', 'footer' ); ?>
		
	</div> <!--! end of #Bottom -->
</div> <!--! end of #Wrapper -->

<?php get_footer('default'); ?>

</body>
</html>