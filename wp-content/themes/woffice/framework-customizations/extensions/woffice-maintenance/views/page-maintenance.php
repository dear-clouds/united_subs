<?php
/**
* Template Name: Maintenance
*/
?>
<html <?php language_attributes(); ?> style="margin-top: 0 !important;">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<!-- MAKE IT RESPONSIVE -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php // GET FAVICONS
		woffice_favicons();
		?>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/flexie.min.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
		
		<!-- Custom CSS for this page -->
		<style type="text/css">
			
			<?php
			/* Data from settings : */
			$maintenance_color = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_color' ); 
			$maintenance_bg_color = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_bg_color' ); 
			$maintenance_bg_image = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_bg_image' ); 
			$maintenance_layer_opacity = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_layer_opacity' ); 
			?>
			
			#woffice-maintenance{
				<?php
				if (!empty($maintenance_bg_image)): 
					echo"background-image: url(".esc_url($maintenance_bg_image["url"]).");";
				else :
					echo"background-image: url(".get_template_directory_uri() ."/images/1.jpg);";
				endif;
				?>
				background-repeat: no-repeat;background-position: center top;
				-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;
				color: <?php echo $maintenance_color; ?>;
				height: 100%; width: 100%;
				position: fixed; overflow-y: scroll;
				left: 0; top: 0;
			}
			
			#woffice-maintenance-layer{
				z-index: 1; position: fixed;
				width: 100%; height: 100%;
				left: 0; top: 0;
				background-color: <?php echo esc_html($maintenance_bg_color); ?>;
				opacity: <?php echo $maintenance_layer_opacity; ?>;
			}	
			#woffice-maintenance-layer:before{
			    font-size: 15em;
			    opacity: .4; position: absolute;
			    left: 5%; top: 15%;
			}
			
			#woffice-maintenance-content{
				z-index: 2;position: relative;text-align: center;
				width: 80%; padding: 20% 0 0 0;
				margin: 0 auto 0 auto;
			}
			
			#woffice-maintenance-content h1{font-size: 4em; margin-bottom: 20px;}
			#woffice-maintenance-content p{color:<?php echo $maintenance_color; ?>;font-size: 1.4em;}
			
			@media only screen and (max-width: 768px) {
				#woffice-maintenance-content h1{font-size: 2em; }
				#woffice-maintenance-content p{font-size: 1.1em;}
			}
		</style>
	</head>
	
	<body <?php body_class(); ?>>
	
		<div id="page-wrapper">
			<div id="content-container">
	
				<!-- START CONTENT -->
				<section id="woffice-maintenance">
				
					<div id="woffice-maintenance-content">
						
						<?php 
						/* The Title */	
						$maintenance_headline = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_headline' ); 
						if (!empty($maintenance_headline)) {
							echo '<h1>'.$maintenance_headline.'</h1>';
						}
						
						/* The Content */	
						$maintenance_text = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_text' ); 
						if (!empty($maintenance_text)) {
							echo '<p>'.$maintenance_text.'</p>';
						}
						?>
						
					</div>
					
					<?php 
					/* The ICON */	
					$maintenance_icon = fw_get_db_ext_settings_option( 'woffice-maintenance', 'maintenance_icon' ); 
					$extraclass = (!empty($maintenance_icon)) ? $maintenance_icon : ''; 
					?>
					<div id="woffice-maintenance-layer" class="<?php echo $extraclass; ?>"></div>
					
				</section>
				<!-- END CONTENT -->
				
			</div>
		</div>
		
		<?php wp_footer(); ?>
	</body>
</html>