<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** ---------------------------------------------------------------------------
 * Import Demo Data
 * @author Muffin Group
 * @version 1.1
 * ---------------------------------------------------------------------------- */
class mfnImport {

	public $error	= '';
	
	
	/** ---------------------------------------------------------------------------
	 * Constructor
	 * ---------------------------------------------------------------------------- */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'init' ) );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Add theme Page
	 * ---------------------------------------------------------------------------- */
	function init() {
		
		if( WHITE_LABEL ){
			
			// White Label | Hide 'Import Demo Data' Page
			add_theme_page(
				'Theme Import Demo Data',
				'Theme Demo Data',
				'edit_theme_options',
				'mfn_import',
				array( &$this, 'import_white' )
			);
			
		} else {
			
			add_theme_page(
				'BeTheme Import Demo Data',
				'BeTheme Demo Data',
				'edit_theme_options',
				'mfn_import',
				array( &$this, 'import' )
			);
			
		}
	
		wp_enqueue_style( 'mfn-import', LIBS_URI. '/importer/import.css', false, time(), 'all');
		wp_enqueue_script( 'mfn-import', LIBS_URI. '/importer/import.js', false, time(), true );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * White Label | Hide 'Import Demo Data' Page
	 * ---------------------------------------------------------------------------- */
	function import_white() {
		?>
			<div id="mfn-wrapper" class="mfn-import wrap">
				<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
				<p><?php _e( 'This feature is disabled in White Label mode', 'mfn-opts' );?></p>	
			</div>
		<?php 
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Demo URL | Get demo url to replace
	 * ---------------------------------------------------------------------------- */
	function get_demo_url( $demo ){
		if( $demo == 'be' ){
			$url = 'http://themes.muffingroup.com/betheme/';
		} else {
			$url = 'http://themes.muffingroup.com/be/'. $demo .'/';
		}
		return $url;
	}
	
	
	/** ---------------------------------------------------------------------------
	 * wp_remote_get with HTTP Basic Authorization
	 * ---------------------------------------------------------------------------- */
	function wp_remote_get_auth( $file_path ){

		if( isset( $_POST['args_login'] ) && isset( $_POST['args_pass'] ) ){
			
			$username = esc_attr( $_POST['args_login'] );
			$password = esc_attr( $_POST['args_pass'] );
			
			$args = array(
				'headers' => array(
					'Authorization' => 'Basic '. call_user_func( 'base'.'64_encode', $username.':'.$password )
				)
			);
			
			$file_data 	= wp_remote_get( $file_path, $args );
				
		} else {
			
			$file_data 	= wp_remote_get( $file_path );
			
		}
		
		return $file_data;
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Content
	 * ---------------------------------------------------------------------------- */
	function import_content( $file = 'all.xml.gz' ){
		$import = new WP_Import();
		$xml = LIBS_DIR . '/importer/demo/'. $file;
// 		print_r($xml);
		
		$import->fetch_attachments = ( $_POST && key_exists('attachments', $_POST) && $_POST['attachments'] ) ? true : false;
		
		ob_start();
		$import->import( $xml );	
		ob_end_clean();
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Menu - Locations 
	 * ---------------------------------------------------------------------------- */
	function import_menu_location( $file = 'menu.txt' ){
		
		$file_path 	= LIBS_URI . '/importer/demo/'. $file;
		$file_data 	= $this->wp_remote_get_auth( $file_path );
		
		$data 		= unserialize( call_user_func( 'base'.'64_decode', $file_data['body'] ) );
		
		$menus 		= wp_get_nav_menus();
			
		foreach( $data as $key => $val ){
			foreach( $menus as $menu ){
				if( $val && $menu->slug == $val ){
					$data[$key] = absint( $menu->term_id );
				}
			}
		}
// 		print_r($data);
		
		set_theme_mod( 'nav_menu_locations', $data );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Theme Options
	 * ---------------------------------------------------------------------------- */
	function import_options( $file = 'options.txt', $url = false ){
		
		$file_path 	= LIBS_URI . '/importer/demo/'. $file;
		$file_data 	= $this->wp_remote_get_auth( $file_path );
		
		$data 		= unserialize( call_user_func( 'base'.'64_decode', $file_data['body'] ) );

		// images URL | replace exported URL with destination URL
		if( $url &&  is_array( $data ) ){
			$replace = home_url('/');
			foreach( $data as $key => $option ){
				if( is_string( $option ) ){						// variable type string only
					$option 	= $this->migrate_cb_ms( $option );
					$data[$key] = str_replace( $url, $replace, $option );
				}
			}
		}

		update_option( THEME_NAME, $data );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Widgets
	 * ---------------------------------------------------------------------------- */
	function import_widget( $file = 'widget_data.json' ){
		
		$file_path 	= LIBS_URI . '/importer/demo/'. $file;
		$file_data 	= $this->wp_remote_get_auth( $file_path );
		
		$data 		= $file_data['body'];
// 		print_r($data);
	
		$this->import_widget_data( $data );
	}
	

	/** ---------------------------------------------------------------------------
	 * Import | Migrate CB Muffin Builder
	 * ---------------------------------------------------------------------------- */

	// FIX | Multisite 'uploads' directory url
	function migrate_cb_ms( $field ){
		if ( is_multisite() ){
			global $current_blog;
			if( $current_blog->blog_id > 1 ){
				$old_url 	= '/wp-content/uploads/';
				$new_url 	= '/wp-content/uploads/sites/'. $current_blog->blog_id .'/';
				$field 		= str_replace( $old_url, $new_url, $field );
			}
		}
		return $field;
	}

	function migrate_cb( $old_url ){
		global $wpdb;
		
		$new_url = home_url('/');
		
		$results = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta
			WHERE `meta_key` = 'mfn-page-items'
		" );
		
		// posts loop -----------------
		if( is_array( $results ) ){
			foreach( $results as $result_key => $result ){
				
				$meta_id 	= $result->meta_id;
				$meta_value = @unserialize( $result->meta_value );
				
				
				// Builder 2.0 Compatibility
				if( $meta_value === false ){
					$meta_value = unserialize( call_user_func( 'base'.'64_decode', $result->meta_value ) );
				}


				// Loop | Sections ----------------
				if( is_array( $meta_value ) ){
					foreach( $meta_value as $sec_key => $sec ){
							
						// Loop | Section Attributes ----------------
						if( isset( $sec['attr'] ) && is_array( $sec['attr'] ) ){
							foreach( $sec['attr'] as $attr_key => $attr ){
								$attr = str_replace( $old_url, $new_url, $attr );
								$meta_value[$sec_key]['attr'][$attr_key] = $attr;
							}
						}
						
						// Builder 3.0 | Loop | Wraps ----------------
						if( isset( $sec['wraps'] ) && is_array( $sec['wraps'] ) ){
							foreach( $sec['wraps'] as $wrap_key => $wrap ){
						
								// Loop | Items ----------------
								if( isset( $wrap['items'] ) && is_array( $wrap['items'] ) ){
									foreach( $wrap['items'] as $item_key => $item ){
								
										// Loop | Fields ----------------
										if( isset( $item['fields'] ) && is_array( $item['fields'] ) ){
											foreach( $item['fields'] as $field_key => $field ) {
													
												if( $field_key == 'tabs' ) {
													// Tabs, Accordion, FAQ, Timeline
														
													// Loop | Tabs --------------------
													if( isset( $field ) && is_array( $field ) ){
														foreach( $field as $tab_key => $tab ){
															$field = str_replace( $old_url, $new_url, $tab['content'] );
															$field = $this->migrate_cb_ms( $field );
															$meta_value[$sec_key]['wraps'][$wrap_key]['items'][$item_key]['fields'][$field_key][$tab_key]['content'] = $field;
														}
													}
												} else {
													// Default
													$field = str_replace( $old_url, $new_url, $field );
													$field = $this->migrate_cb_ms( $field );
													$meta_value[$sec_key]['wraps'][$wrap_key]['items'][$item_key]['fields'][$field_key] = $field;
												}
											}
										}
								
									}
								}
								
							}
						}
		
						// Builder 2.0 | Loop | Items ----------------
						if( isset( $sec['items'] ) && is_array( $sec['items'] ) ){
							foreach( $sec['items'] as $item_key => $item ){
				
								// Loop | Fields ----------------
								if( isset( $item['fields'] ) && is_array( $item['fields'] ) ){
									foreach( $item['fields'] as $field_key => $field ) {
											
										if( $field_key == 'tabs' ) {
											// Tabs, Accordion, FAQ, Timeline
					
											// Loop | Tabs --------------------
											if( is_array( $field ) ){
												foreach( $field as $tab_key => $tab ){
													$field = str_replace( $old_url, $new_url, $tab['content'] );
													$field = $this->migrate_cb_ms( $field );
													$meta_value[$sec_key]['items'][$item_key]['fields'][$field_key][$tab_key]['content'] = $field;
												}
											}
										} else {
											// Default
											$field = str_replace( $old_url, $new_url, $field );
											$field = $this->migrate_cb_ms( $field );
											$meta_value[$sec_key]['items'][$item_key]['fields'][$field_key] = $field;
										}
									}
								}
								
							}
						}
						
					}
				}
		
				// print_r($meta_value);
		
				$meta_value = call_user_func( 'base'.'64_encode', serialize( $meta_value ) );
				
				$wpdb->query( "UPDATE $wpdb->postmeta
					SET `meta_value` = '" . addslashes( $meta_value ) . "'
					WHERE `meta_key` = 'mfn-page-items'
					AND `meta_id`= " . $meta_id . "
				" );
				
			}
		}
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import
	 * ---------------------------------------------------------------------------- */
	function import(){
		global $wpdb;

		if( key_exists( 'mfn_import_nonce',$_POST ) ){
			if ( wp_verify_nonce( $_POST['mfn_import_nonce'], basename(__FILE__) ) ){
				
// 				print_r($_POST);
	
				// Importer classes
				if( ! defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );
				
				if( ! class_exists( 'WP_Importer' ) ){
					require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				}
				
				if( ! class_exists( 'WP_Import' ) ){
					require_once LIBS_DIR . '/importer/wordpress-importer.php';
				}
				
				if( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ){

					
					switch( $_POST['import'] ) {
						
						case 'all':
							// Full Demo Data ---------------------------------
							$this->import_content();
							$this->import_menu_location();
							$this->import_options( 'options.txt', $this->get_demo_url( 'be' ) );
							$this->import_widget();
							
							// set home & blog page
							$home = get_page_by_title( 'Home' );
							$blog = get_page_by_title( 'Blog' );
							if( $home->ID && $blog->ID ) {
								update_option('show_on_front', 'page');
								update_option('page_on_front', $home->ID); // Front Page
								update_option('page_for_posts', $blog->ID); // Blog Page
							}
							break;
							
						case 'demo':					
							// Single Demo Data ---------------------------------
							
							$_POST['demo'] 		= htmlspecialchars( stripslashes( $_POST['demo'] ) );

							
							$file = 'be/'. $_POST['demo'] .'/content.xml.gz';
							$this->import_content( $file );

							
							// Muffin Builder | replace exported URL with destination URL
							$this->migrate_cb( $this->get_demo_url( $_POST['demo'] ) );
							
							
							$file = 'be/'. $_POST['demo'] .'/menu.txt';
							$this->import_menu_location( $file );

							
							$file = 'be/'. $_POST['demo'] .'/options.txt';
							$this->import_options( $file, $this->get_demo_url( $_POST['demo'] ) );
							
							
							$file = 'be/'. $_POST['demo'] .'/widget_data.json';
							$this->import_widget( $file );
							
							
							// set home & blog page
							$home = get_page_by_title( 'Home' );
							if( $home->ID ) {
								update_option('show_on_front', 'page');
								update_option('page_on_front', $home->ID); // Front Page
							}
							break;
						
						case 'content':
							if( $_POST['content'] ){
								$_POST['content'] = htmlspecialchars( stripslashes( $_POST['content'] ) );
								$file = 'content/'. $_POST['content'] .'.xml.gz';
								$this->import_content( $file );
							} else {
								$this->import_content();
							}
							break;
							
						case 'menu':
							$this->import_content( 'menu.xml.gz' );
							$this->import_menu_location();
							break;
							
						case 'options':
							// Theme Options ----------------------------------
							$this->import_options();
							break;
							
						case 'widgets':
							// Widgets ----------------------------------------
							$this->import_widget();
							break;
							
						default:
							// Empty select.import
							$this->error = __('Please select data to import.','mfn-opts');	
							break;
					}				
					

					// message box
					if( $this->error ){
						echo '<div class="error settings-error">';
							echo '<p><strong>'. $this->error .'</strong></p>';
						echo '</div>';
					} else {
						echo '<div class="updated settings-error">';
							echo '<p><strong>'. __('All done. Have fun!','mfn-opts') .'</strong></p>';
						echo '</div>';
					}
					

				}
	
			}
		}

		?>
		<div id="mfn-wrapper" class="mfn-demo-data wrap">
		
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			
			<div class="mfn-message info">
				<b>Before starting the import</b> you need to install all plugins that you want to use.<br />
				If you are planning to use the shop, please also remember about WooCommerce plugin.
			</div>
			
			<?php 
				$phpversion = 0;
				if ( function_exists( 'phpversion' ) ){
					$phpversion = floatval( phpversion() );
				}
			
				if( ( $phpversion >= 7 ) && is_plugin_active( 'wordpress-importer/wordpress-importer.php' )){
					echo '<div class="mfn-message error php-7">';
						echo 'Default WordPress Importer plugin is not compatible with PHP '. $phpversion .', please deactivate this plugin before demo data import.';
					echo '</div>';	
				}
			?>
			
			<?php 
				$test_error = false;
				$test_file 	= LIBS_URI . '/importer/demo/menu.txt';
				
				$response = $this->wp_remote_get_auth( $test_file );

				if( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ){
					// success
				} else {
					$test_error  = __( 'WordPress function <a target="_blank" href="https://codex.wordpress.org/Function_Reference/wp_remote_get">wp_remote_get()</a> test failed. Looks like your server is not fully compatible with WordPress. Contact your hosting provider.', 'mfn-opts' );
					if ( is_wp_error( $response ) ){
						$test_error .= '<br />'. sprintf( __( 'Error: %s', 'mfn-opts' ), sanitize_text_field( $response->get_error_message() ) );
					} else {
						$test_error .= '<br />'. sprintf( __( 'Status code: %s', 'mfn-opts' ), sanitize_text_field( $response['response']['code'] ) );
					}
				}
				
				if( $test_error ){
					echo '<div class="mfn-message error">'. $test_error .'</div>';
				}
			?>
			
			<form action="" method="post">
				
				<input type="hidden" name="mfn_import_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
				
				<table class="form-table">
				
					<?php 
						if( $test_error ){	
							if( $response['response']['code'] == 401 ){
								// 401 Unauthorized | HTTP Basic Authentication
								
								echo '<tr class="row-401">';
								
									echo '<th scope="row">';
										echo '<label for="import">Login details</label>';
									echo '</th>';
									
									echo '<td>';
										echo '<p class="description">Looks like your server uses HTTP Basic Authentication, please enter your login details:</p>';
										echo '<label for="args_login">Login</label>';
										echo '<input type="text" name="args_login" />';
										echo '<label for="args_pass">Password</label>';
										echo '<input type="password" name="args_pass" />';
									echo '</td>';
									
								echo '</tr>';
							}
						}
					?>
				
					<tr class="row-import">
						<th scope="row">
							<label for="import">Import</label>
						</th>
						<td>
							<select name="import" class="import">
								<option value="">-- Select --</option>
								<option value="all">Default Layout</option>
								<option value="demo">Demo</option>
								<option value="content">Content</option>
								<option value="menu">Menu | with menu pages</option>
								<option value="options">Options</option>
								<option value="widgets">Widgets</option>
							</select>
						</td>
					</tr>

					<tr class="row-demo hide">
						<th scope="row">
							<label for="demo">Demo | Pre-made Layout</label>
						</th>
						<td>
							<select name="demo">
								<option value="accountant">Accountant</option>
								<option value="adagency">Ad Agency</option>
								<option value="agency">Agency</option>
								<option value="agency2">Agency 2</option>
								<option value="agro">Agro</option>
								<option value="animals">Animals</option>
								<option value="app">App</option>
								<option value="app2">App 2</option>
								<option value="aquapark">Aquapark</option>
								<option value="architect">Architect</option>
								<option value="architect2">Architect 2</option>
								<option value="art">Art</option>
								<option value="asg">ASG</option>
								<option value="baker">Baker</option>
								<option value="band">Band</option>
								<option value="bar">Bar</option>
								<option value="barber">Barber</option>
								<option value="beauty">Beauty</option>
								<option value="beauty2">Beauty 2</option>
								<option value="bikerental">Bike Rental</option>
								<option value="billiard">Billiard</option>
								<option value="bistro">Bistro</option>
								<option value="bw">Black & White</option>
								<option value="blogger">Blogger</option>
								<option value="blogger2">Blogger 2</option>
								<option value="book">Book</option>
								<option value="buddy">Buddy | requires BuddyPress & Bowe Codes plugins</option>
								<option value="builder">Builder</option>
								<option value="burger">Burger</option>
								<option value="business">Bussiness</option>
								<option value="business2">Bussiness 2</option>
								<option value="cafe">Cafe</option>
								<option value="callcenter">Call Center</option>
								<option value="car">Car</option>
								<option value="carpenter">Carpenter</option>
								<option value="carrental">Car Rental</option>
								<option value="carver">Carver</option>
								<option value="casino">Casino</option>
								<option value="charity">Charity</option>
								<option value="charity2">Charity 2</option>
								<option value="church">Church</option>
								<option value="cleaner">Cleaner</option>
								<option value="clinic">Clinic</option>
								<option value="club">Club</option>
								<option value="coaching">Coaching</option>
								<option value="coffee">Coffee</option>
								<option value="congress">Congress</option>
								<option value="constructor">Constructor</option>
								<option value="copywriter">Copywriter</option>
								<option value="cosmetics">Cosmetics</option>
								<option value="creative">Creative</option>
								<option value="decor">Decor</option>
								<option value="dentist">Dentist</option>
								<option value="design">Design</option>
								<option value="design2">Design 2</option>
								<option value="developer">Developer</option>
								<option value="dietitian">Dietitian</option>								
								<option value="digital">Digital</option>
								<option value="disco">Disco</option>
								<option value="dj">DJ</option>
								<option value="driving">Driving</option>
								<option value="eco">Eco</option>
								<option value="electric">Electric</option>
								<option value="energy">Energy</option>
								<option value="estate">Estate</option>
								<option value="event">Event</option>
								<option value="exposure">Exposure</option>
								<option value="extreme">Extreme</option>
								<option value="farmer">Farmer</option>
								<option value="fashion">Fashion</option>
								<option value="factory">Factory</option>
								<option value="finance">Finance</option>
								<option value="firm">Firm</option>
								<option value="fit">Fit</option>
								<option value="fitness">Fitness</option>
								<option value="fix">Fix</option>
								<option value="flower">Flower</option>
								<option value="freelancer">Freelancer</option>
								<option value="furniture">Furniture</option>
								<option value="garden">Garden</option>
								<option value="glasses">Glasses</option>
								<option value="golf">Golf</option>
								<option value="gym">Gym</option>
								<option value="handmade">Handmade</option>
								<option value="handyman">Handyman</option>
								<option value="holding">Holding</option>
								<option value="horse">Horse Riding</option>
								<option value="hosting">Hosting</option>
								<option value="hotel">Hotel</option>
								<option value="hotel2">Hotel 2 | uses Contact Form 7 Datepicker plugin</option>
								<option value="hr">HR</option>
								<option value="icecream">Ice Cream</option>
								<option value="industry">Industry</option>
								<option value="insurance">Insurance</option>
								<option value="interactive">Interactive</option>
								<option value="interior">Interior</option>
								<option value="interior2">Interior 2</option>
								<option value="investment">Investment</option>
								<option value="itservice">IT Service</option>
								<option value="jet">Jet</option>
								<option value="jeweler">Jeweler</option>
								<option value="journey">Journey</option>
								<option value="journalist">Journalist</option>
								<option value="karting">Karting</option>
								<option value="kebab">Kebab</option>
								<option value="kindergarten">Kindergarten</option>
								<option value="kravmaga">KravMaga</option>
								<option value="lab">Lab</option>
								<option value="landing">Landing Page</option>
								<option value="language">Language School</option>
								<option value="launch">Launch</option>
								<option value="lawyer">Lawyer</option>
								<option value="library">Library</option>
								<option value="lifestyle">Lifestyle</option>
								<option value="loans">Loans</option>
								<option value="makeup">Makeup</option>
								<option value="marketing">Marketing</option>
								<option value="massage">Massage</option>
								<option value="mechanic">Mechanic</option>
								<option value="media">Media</option>
								<option value="medic">Medic</option>
								<option value="medic2">Medic 2</option>
								<option value="minimal">Minimal</option>
								<option value="mining">Mining</option>
								<option value="model">Model</option>
								<option value="movie">Movie</option>
								<option value="moving">Moving</option>
								<option value="moving2">Moving 2</option>
								<option value="museum">Museum</option>
								<option value="music">Music</option>
								<option value="ngo">NGO</option>
								<option value="notebook">Notebook</option>
								<option value="onepage">One Page</option>
								<option value="painter">Painter</option>
								<option value="parallax">Parrallax</option>
								<option value="party">Party</option>
								<option value="perfume">Perfume</option>
								<option value="pets">Pets</option>
								<option value="pharmacy">Pharmacy</option>
								<option value="photo">Photo</option>
								<option value="pizza">Pizza</option>
								<option value="play">Play</option>
								<option value="plumber">Plumber</option>
								<option value="pole">Pole Dance</option>
								<option value="politics">Politics</option>
								<option value="portfolio">Portfolio</option>
								<option value="pr">PR Agency</option>
								<option value="press">Press</option>
								<option value="print">Print</option>
								<option value="profile">Profile</option>
								<option value="recipes">Recipes</option>
								<option value="records">Records</option>
								<option value="renovate">Renovate</option>
								<option value="renovate2">Renovate 2</option>
								<option value="restaurant">Restaurant</option>
								<option value="resume">Resume</option>
								<option value="retouch">Retouch</option>
								<option value="safari">Safari</option>
								<option value="school">School</option>
								<option value="science">Science</option>
								<option value="security">Security</option>
								<option value="seo">SEO</option>
								<option value="seo2">SEO 2</option>
								<option value="service">Service</option>
								<option value="shop">Shop</option>
								<option value="showcase">Showcase</option>
								<option value="simple">Simple</option>
								<option value="sitter">Sitter</option>
								<option value="sketch">Sketch</option>
								<option value="ski">Ski</option>
								<option value="smart">Smart</option>
								<option value="smarthome">Smart Home</option>
								<option value="software">Software</option>
								<option value="spa">Spa</option>
								<option value="space">Space</option>
								<option value="splash">Splash | for demo purposes only</option>
								<option value="sport">Sport</option>
								<option value="steak">Steak</option>
								<option value="store">Store</option>
								<option value="story">Story</option>
								<option value="surfing">Surfing</option>
								<option value="sushi">Sushi</option>
								<option value="tattoo">Tattoo</option>
								<option value="taxi">Taxi</option>
								<option value="tea">Tea</option>
								<option value="technics">Technics</option>
								<option value="theater">Theater</option>
								<option value="tiles">Tiles</option>
								<option value="tourist">Tourist</option>
								<option value="toy">Toy</option>
								<option value="transfer">Transfer</option>
								<option value="translator">Translator</option>
								<option value="transport">Transport</option>
								<option value="travel">Travel</option>
								<option value="tuning">Tuning</option>
								<option value="typo">Typo</option>
								<option value="underwater">Underwater</option>
								<option value="university">University</option>
								<option value="vet">Vet</option>
								<option value="video">Video</option>
								<option value="vision">Vision</option>
								<option value="voyager">Voyager</option>
								<option value="vpn">VPN</option>
								<option value="webdesign">Web Design</option>
								<option value="webmaster">Webmaster</option>
								<option value="wedding">Wedding</option>
								<option value="wedding2">Wedding 2</option>
								<option value="wine">Wine</option>
								<option value="xmas">Xmas</option>
								<option value="yoga">Yoga</option>
								<option value="zoo">Zoo</option>
							</select>
						</td>
					</tr>

					<tr class="row-homepage hide">
						<th scope="row">
							<label for="homepage">Homepage</label>
						</th>
						<td>
							<select name="homepage">
								<option value="home">Home (default)</option>
							</select>
						</td>
					</tr>
					
					<tr class="row-content hide">
						<th scope="row">
							<label for="content">Content</label>
						</th>
						<td>
							<select name="content">
								<option value="">-- All --</option>
								<option value="pages">Pages</option>
								<option value="posts">Posts</option>
								<option value="contact">Contact</option>
								<option value="clients">Clients</option>
								<option value="offer">Offer</option>
								<option value="portfolio">Portfolio</option>
								<option value="slides">Slides</option>
								<option value="testimonials">Testimonials</option>
							</select>
						</td>
					</tr>

					<tr class="row-attachments hide">
						<th scope="row">Attachments</th>
						<td>
							<fieldset>
								<label for="attachments"><input type="checkbox" value="1" id="attachments" name="attachments">Import attachments</label>
								<p class="description">Download all attachments from the demo may take a while. Please be patient.</p>
							</fieldset>
						</td>
					</tr>
				
				</table>
	
				<input type="submit" name="submit" class="button button-primary" value="Import demo data" />
					
			</form>
	
		</div>	
		<?php	
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Parse JSON import file
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function import_widget_data( $json_data ) {
	
		$json_data 		= json_decode( $json_data, true );
		$sidebar_data 	= $json_data[0];
		$widget_data 	= $json_data[1];	
// 		print_r($json_data);
	
		// prepare widgets table
		$widgets = array();
		foreach( $widget_data as $k_w => $widget_type ){
			if( $k_w ){
				$widgets[ $k_w ] = array();
				foreach( $widget_type as $k_wt => $widget ){
					if( is_int( $k_wt ) ) $widgets[$k_w][$k_wt] = 1;
				}
			}
		}
// 		print_r($widgets);

		// sidebars
		foreach ( $sidebar_data as $title => $sidebar ) {
			$count = count( $sidebar );
			for ( $i = 0; $i < $count; $i++ ) {
				$widget = array( );
				$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
				$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
				if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
					unset( $sidebar_data[$title][$i] );
				}
			}
			$sidebar_data[$title] = array_values( $sidebar_data[$title] );
		}
	
		// widgets
		foreach ( $widgets as $widget_title => $widget_value ) {
			foreach ( $widget_value as $widget_key => $widget_value ) {
				$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
			}
		}
// 		print_r($sidebar_data);
		
		$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
		$this->parse_import_data( $sidebar_data );
	}
	
	/** ---------------------------------------------------------------------------
	 * Import widgets
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function parse_import_data( $import_array ) {
		$sidebars_data 		= $import_array[0];
		$widget_data 		= $import_array[1];
		
		mfn_register_sidebars(); // fix for sidebars added in Theme Options
		$current_sidebars 	= get_option( 'sidebars_widgets' );
		$new_widgets 		= array( );

// 		print_r($sidebars_data);
// 		print_r($current_sidebars);
	
		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
	
			foreach ( $import_widgets as $import_widget ) :
			
				// if NOT the sidebar exists
				if ( ! isset( $current_sidebars[$import_sidebar] ) ){
					$current_sidebars[$import_sidebar] = array();
				}

				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name = $this->get_new_widget_name( $title, $index );
				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
			
				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
						$new_index++;
					}
				}
				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
					
					// notice fix
					if( ! key_exists('_multiwidget',$new_widgets[$title]) ) $new_widgets[$title]['_multiwidget'] = '';
					
					$multiwidget = $new_widgets[$title]['_multiwidget'];
					unset( $new_widgets[$title]['_multiwidget'] );
					$new_widgets[$title]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[$new_index] = $widget_data[$title][$index];
					
					// notice fix
					if( ! key_exists('_multiwidget',$current_widget_data) ) $current_widget_data['_multiwidget'] = '';
					
					$current_multiwidget = $current_widget_data['_multiwidget'];
					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[$title] = $current_widget_data;
				}
				
			endforeach;
		endforeach;
	
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
	
			foreach ( $new_widgets as $title => $content )
				update_option( 'widget_' . $title, $content );
	
			return true;
		}
	
		return false;
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Get new widget name
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	
}

$mfn_import = new mfnImport;
