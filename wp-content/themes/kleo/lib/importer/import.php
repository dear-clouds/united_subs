<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** ---------------------------------------------------------------------------
 * Import Demo Data
 * @author SeventhQueen
 * @version 1.0
 * ---------------------------------------------------------------------------- */
class kleoImport {

	private static $instance;
	private static $pages_data = array();
	public $error	= '';
	
	/** ---------------------------------------------------------------------------
	 * Constructor
	 * ---------------------------------------------------------------------------- */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'init' ) );

		$this->add_initial_demo_sets();
	}

	public static function getInstance()
	{
		if ( is_null( self::$instance ) )
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add a demo set
	 */
	static function add_demo_set($slug, $data) {
		self::$pages_data[$slug] = $data;
	}

	/**
	 * Add multiple demo sets
	 */
	static function add_demo_sets( $data ) {
		self::$pages_data = self::$pages_data + $data;
	}

	/**
	 * Retrive the demo sets
	 */
	static function get_demo_sets() {
		return self::$pages_data;
	}

	function add_initial_demo_sets() {
		$pages_data = array();

		$pages_data['home-company'] = array(
			'name' => "Home Company (v4.0)",
			'img' => KLEO_LIB_URI . '/importer/img/home-company.jpg',
			'page' => 'pages/home-company',
			'attach' => 'yes',
			//'revslider' => '',
			'link' => 'http://seventhqueen.com/themes/kleo/company/'
		);

		$pages_data['home-food'] = array(
			'name' => "Home Food (v4.0)",
			'img' => KLEO_LIB_URI . '/importer/img/home-food.jpg',
			'page' => 'pages/home-food',
			'attach' => 'yes',
			//'revslider' => '',
			'link' => 'http://seventhqueen.com/themes/kleo/food/'
		);

		/*$pages_data['home-medical'] = array(
			'name' => "Home Medical (v4.0)",
			'img' => KLEO_LIB_URI . '/importer/img/home-medical.jpg',
			'page' => 'pages/home-medical',
			'attach' => 'yes',
			'revslider' => 'kleo_medical',
			'link' => 'http://seventhqueen.com/themes/kleo/medical/'
		);*/

		$pages_data['home-register'] = array(
			'name' => "Home Register Landing Page (v4.0)",
			'img' => KLEO_LIB_URI . '/importer/img/home-register.jpg',
			'page' => 'pages/home-register',
			'attach' => 'yes',
			//'revslider' => '',
			'link' => 'http://seventhqueen.com/themes/kleo/home-register/'
		);

		$pages_data['home-community'] = array(
			'name' => "Home Default(Community)",
			'img' => KLEO_LIB_URI . '/importer/img/home-community.jpg',
			'page' => 'pages/home-community',
			//'attach' => 'yes',
			'revslider' => 'HomeFullwidth',
			'link' => 'http://seventhqueen.com/themes/kleo/home-default/'
		);
		$pages_data['home-pinterest'] = array(
			'name' => "Home Pinterest",
			'img' => KLEO_LIB_URI . '/importer/img/home-pinterest.jpg',
			'page' => 'pages/home-pinterest',
			//'attach' => 'yes',
			//'revslider' => '',
			'link' => 'http://seventhqueen.com/themes/kleo/pinterest/'
		);
		$pages_data['home-news-magazine'] = array(
			'name' => "Home News Magazine",
			'img' => KLEO_LIB_URI . '/importer/img/home-news-magazine.jpg',
			'page' => 'pages/home-news-magazine',
			'attach' => 'yes',
			'revslider' => 'news-magazine',
			'link' => 'http://seventhqueen.com/themes/kleo/news-magazine/'
		);
		$pages_data['home-material'] = array(
			'name' => "Home Material Design",
			'img' => KLEO_LIB_URI . '/importer/img/home-material-design.jpg',
			'page' => 'pages/home-material',
			'attach' => 'yes',
			'revslider' => 'material-design',
			'details' => 'Also set: Theme options - Styling options - Header - Color Preset - Deep Purple/Amber',
			'link' => 'http://seventhqueen.com/themes/kleo/material-design-colors/'
		);
		$pages_data['home-get-connected'] = array(
			'name' => "Home Get Connected",
			'img' => KLEO_LIB_URI . '/importer/img/home-get-connected.jpg',
			'page' => 'pages/home-get-connected',
			'attach' => 'yes',
			//'revslider' => 'material-design',
			'details' => 'BP Profile Search plugin required.',
			'link' => 'http://seventhqueen.com/themes/kleo/get-connected'
		);
		$pages_data['home-get-connected-vertical'] = array(
			'name' => "Home Get Connected Vertical",
			'img' => KLEO_LIB_URI . '/importer/img/home-get-connected-vertical.jpg',
			'page' => 'pages/home-get-connected-vertical',
			'attach' => 'yes',
			//'revslider' => 'material-design',
			'details' => 'BP Profile Search plugin required.',
			'link' => 'http://seventhqueen.com/themes/kleo/get-connected-vertical-form/'
		);
		$pages_data['home-product-landing'] = array(
			'name' => "Home Product Landing Page",
			'img' => KLEO_LIB_URI . '/importer/img/home-product-landing-page.jpg',
			'page' => 'pages/home-product-landing',
			'attach' => 'yes',
			'revslider' => 'product-landing-page',
			'link' => 'http://seventhqueen.com/themes/kleo/product-landing-page/'
		);
		$pages_data['home-mobile-app'] = array(
			'name' => "Home Mobile APP",
			'img' => KLEO_LIB_URI . '/importer/img/home-mobile-app.jpg',
			'page' => 'pages/home-mobile-app',
			'attach' => 'yes',
			'revslider' => 'mobile-app',
			'link' => 'http://seventhqueen.com/themes/kleo/mobile-app/'
		);
		$pages_data['home-resume'] = array(
			'name' => "Home Resume",
			'img' => KLEO_LIB_URI . '/importer/img/home-resume.jpg',
			'page' => 'pages/home-resume',
			'attach' => 'yes',
			//'revslider' => 'mobile-app',
			'link' => 'http://seventhqueen.com/themes/kleo/resume/'
		);
		$pages_data['home-sensei'] = array(
			'name' => "Home Sensei",
			'img' => KLEO_LIB_URI . '/importer/img/home-sensei.jpg',
			'page' => 'pages/home-sensei',
			'attach' => 'yes',
			'revslider' => 'elearning_homepage',
			'details' => 'Sensei plugin required.',
			'link' => 'http://seventhqueen.com/themes/kleo/sensei-e-learning/'
		);
		$pages_data['home-elearning'] = array(
			'name' => "Home e-Learning",
			'img' => KLEO_LIB_URI . '/importer/img/home-elearning.jpg',
			'page' => 'pages/home-elearning',
			'attach' => 'yes',
			'revslider' => 'elearning_homepage',
			'link' => 'http://seventhqueen.com/themes/kleo/e-learning-home/'
		);
		$pages_data['home-geodirectory'] = array(
			'name' => "Home Geodirectory",
			'img' => KLEO_LIB_URI . '/importer/img/home-geodirectory.jpg',
			'page' => 'pages/home-geodirectory',
			'widgets' => 'widget_data_geodirectory',
			//'attach' => 'yes',
			//'revslider' => '',
			'details' => 'Geodirectory plugin required. Please read the <a target="_blank" href="http://seventhqueen.com/support/documentation/kleo#geo-directory">documentation</a>',
			'link' => 'http://seventhqueen.com/themes/kleo/business-directory/'
		);
		$pages_data['home-portfolio-full'] = array(
			'name' => "Home Portfolio Full-Width",
			'img' => KLEO_LIB_URI . '/importer/img/home-portfolio-full.jpg',
			'page' => 'pages/home-portfolio-full',
			//'widgets' => 'yes',
			//'attach' => 'yes',
			'revslider' => 'HomeFullwidth',
			'link' => 'http://seventhqueen.com/themes/kleo/portfolio-full-width/'
		);
		$pages_data['home-shop'] = array(
			'name' => "Home Shop",
			'img' => KLEO_LIB_URI . '/importer/img/home-shop.jpg',
			'page' => 'pages/home-shop',
			'extra' => 'content/products-dummy',
			'extra_name' => 'Import Dummy Products',
			//'widgets' => 'yes',
			'attach' => 'yes',
			'revslider' => 'HomeFullwidth',
			'details' => 'Woocommerce plugin required.',
			'link' => 'http://seventhqueen.com/themes/kleo/default-shop/'
		);
		$pages_data['home-stylish-woo'] = array(
			'name' => "Home Stylish Woocommerce",
			'img' => KLEO_LIB_URI . '/importer/img/home-stylish-woo.jpg',
			'page' => 'pages/home-stylish-woo',
			'extra' => 'content/products-dummy',
			'extra_name' => 'Import Dummy Products',
			//'widgets' => 'yes',
			'attach' => 'yes',
			//'revslider' => 'HomeFullwidth',
			'details' => 'Woocommerce plugin required.',
			'link' => 'http://seventhqueen.com/themes/kleo/stylish-woocommerce/'
		);
		$pages_data['home-agency'] = array(
			'name' => "Home Agency",
			'img' => KLEO_LIB_URI . '/importer/img/home-agency.jpg',
			'page' => 'all-agency',
			//'widgets' => 'yes',
			'attach' => 'yes',
			'revslider' => 'vertical_fullscreen',
			'link' => 'http://seventhqueen.com/themes/kleo/demo-agency/'
		);
		$pages_data['home-simple'] = array(
			'name' => "Home Simple",
			'img' => KLEO_LIB_URI . '/importer/img/home-simple.jpg',
			'page' => 'pages/home-simple',
			//'widgets' => 'yes',
			'attach' => 'yes',
			'revslider' => 'home-simple',
			'link' => 'http://seventhqueen.com/themes/kleo/home/'
		);
		$pages_data['home-onepage'] = array(
			'name' => "Home OnePage - KLEO demo (v2)",
			'img' => KLEO_LIB_URI . '/importer/img/home-onepage.jpg',
			'page' => 'pages/home-onepage',
			//'widgets' => 'yes',
			'attach' => 'yes',
			'revslider' => 'lp-home-full-screen',
			'link' => 'http://seventhqueen.com/themes/kleo/one-page-presentation/'
		);
		$pages_data['home-onepage-v3'] = array(
			'name' => "Home OnePage - KLEO demo (v3)",
			'img' => KLEO_LIB_URI . '/importer/img/rev-onepage-v3.jpg',
			//'page' => 'pages/home-onepage',
			//'widgets' => 'yes',
			//'attach' => 'yes',
			'revslider' => 'landingpage_v3_0_beta',
			'link' => 'http://seventhqueen.com/themes/kleo/',
			'details' => 'Just Revslider to import.',
		);



		self::add_demo_sets( $pages_data );
	}


	/** ---------------------------------------------------------------------------
	 * Add theme Page
	 * ---------------------------------------------------------------------------- */
	function init() {
		add_theme_page(
			'KLEO Demo Data',
			'KLEO Demo Data',
			'edit_theme_options',
			'kleo_import',
			array( &$this, 'import' )
		);
		wp_enqueue_script( 'kleo.import', KLEO_LIB_URI . '/importer/import.js', false, time(), true );

	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import | Content
	 * @param string $file
	 * @param bool $force_attachments
	 *
	 * ---------------------------------------------------------------------------- */
	function import_content( $file = 'all.xml.gz', $force_attachments = false ){
		$import = new WP_Import();
		$xml = KLEO_LIB_DIR . '/importer/demo/'. $file;
		//print_r($xml);

		if ($force_attachments == true ) {
			$import->fetch_attachments = true;
		} else {
			$import->fetch_attachments = ( $_POST && array_key_exists( 'attachments', $_POST ) && $_POST['attachments'] ) ? true : false;
		}
		
		ob_start();
		$import->import( $xml );	
		ob_end_clean();
	}

	
	/** ---------------------------------------------------------------------------
	 * Import | Menu - Locations 
	 * ---------------------------------------------------------------------------- */
	function import_menu_location(){

		$data = array(
            'primary' => 'kleonavmenu',
            'top' => 'kleotopmenu'
        );
		$menus = wp_get_nav_menus();

		foreach( $data as $key => $val ){
			foreach( $menus as $menu ){
				if( $menu->slug == $val ){
					$data[$key] = absint( $menu->term_id );
				}
			}
		}
		set_theme_mod( 'nav_menu_locations', $data );
	}
	

	
	/** ---------------------------------------------------------------------------
	 * Import | Widgets
	 * ---------------------------------------------------------------------------- */
	function import_widget(){

        //add any extra sidebars
        $sidebars_file_path 	= KLEO_LIB_URI . '/importer/demo/sidebar_data.txt';
        $sidebars_file_data 	= wp_remote_get( $sidebars_file_path );
        $sidebars_data 		= unserialize( $sidebars_file_data['body'] );
        $old_sidebars = get_option( 'sbg_sidebars' );
        if ( !empty( $old_sidebars ) ) {
            $sidebars_data = array_merge( $sidebars_data, $old_sidebars );
        }
        update_option( 'sbg_sidebars', $sidebars_data );

        //widgets
        $file_path 	= KLEO_LIB_URI . '/importer/demo/widget_data.json';
        $file_data 	= wp_remote_get( $file_path );
        $data 		= $file_data['body'];
		$this->import_widget_data( $data );
	}


	/** ---------------------------------------------------------------------------
	 * Import | RevSlider
	 *
	 * @param string $path
	 * @param string $name
	 * ---------------------------------------------------------------------------- */
	function import_revslider( $path, $name = '' ) {

		if ( class_exists( 'RevSlider' ) ) {

			//filename provided without extension
			$full_path = trailingslashit( $path ) . $name . '.zip';

			if ( $this->check_existing_slider( $name ) && file_exists( $full_path ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $full_path );
			}
		}

	}

	function check_existing_slider( $name ) {

		$theslider = new RevSlider();
		$arrSliders = $theslider->getArrSliders();

		foreach($arrSliders as $slider){
			if ($name == $slider->getAlias()) {
				return false;
			}

		}
		return true;
	}

	function check_revslider_file( $file_path, $file_name ) {

		$file_final_path =  trailingslashit( $file_path ) . $file_name;

		if ( ! file_exists( $file_final_path ) || 0 < filesize( $file_final_path ) ) {

			if ( ! is_dir( $file_path ) ) {
				wp_mkdir_p( $file_path );
			}

			// Get remote file
			$response = wp_remote_get( 'http://seventhqueen.com' . '/support/files/kleo/revslider/' . $file_name );

			// Check for error
			if ( is_wp_error( $response ) ) {
				$this->error = 'Revolution slider could not be imported. Import manually from WP admin - Revolution Slider';
				return false;
			}

			// Parse remote HTML file
			$file_contents = wp_remote_retrieve_body( $response );

			// Check for error
			if ( is_wp_error( $file_contents ) ) {
				$this->error = 'Revolution slider could not be imported. Import manually from WP admin - Revolution Slider';
				return false;
			}

			if ( ! sq_fs_put_contents( $file_final_path, $file_contents )) {
				$this->error = 'Revolution slider could not be imported. Import manually from WP admin - Revolution Slider';
				return false;
			}
		}

		return true;
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Import
	 * ---------------------------------------------------------------------------- */
	function import(){
		global $wpdb;
		
		if( array_key_exists( 'kleo_import_nonce',$_POST ) ){
			if ( wp_verify_nonce( $_POST['kleo_import_nonce'], basename(__FILE__) ) ) {
	
				// Importer classes
				if( ! defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );
				
				if( ! class_exists( 'WP_Importer' ) ){
					require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				}
				
				if( ! class_exists( 'WP_Import' ) ){
					require_once KLEO_LIB_DIR . '/importer/wordpress-importer.php';
				}
				
				if( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ){

					/* DEMO Sets */
					if (isset($_POST['import_demo'])) {

						$demo_sets = self::get_demo_sets();
						$current_set = $_POST['import_demo'];

						//var_dump($demo_sets);
						if (array_key_exists( $current_set, $demo_sets )) {

							//check page
							if (isset($_POST['import_page']) && in_array( $current_set, $_POST['import_page'] ) ) {

								$force_attach = false;
								//check attachments
								if (isset($_POST['import_attach']) && in_array( $current_set, $_POST['import_attach'] ) ) {
									$force_attach = true;
								}

								$file_path = $demo_sets[$current_set]['page'] . '.xml.gz';
								$this->import_content( $file_path, $force_attach );
							}


							//check widgets
							if (isset($_POST['import_widgets']) && in_array( $current_set, $_POST['import_widgets'] ) ) {
								$widget_path = $demo_sets[ $current_set ]['widgets'];

								//widgets
								$file_path = KLEO_LIB_URI . '/importer/demo/' . $widget_path;
								if ( file_exists( $file_path ) ) {
									$file_data = wp_remote_get( $file_path );
									$data      = $file_data['body'];
									$this->import_widget_data( $data );
								}

							}

							//check revslider
							if (isset($_POST['import_revslider']) && in_array( $current_set, $_POST['import_revslider'] ) ) {

								global $kleo_config;
								$file_path = $kleo_config['upload_basedir'] . '/slider_imports';
								$file_name = $demo_sets[$current_set]['revslider'];

								if ( $this->check_revslider_file( $file_path, $file_name  . '.zip' ) ) {
									//file name provided without extension
									$this->import_revslider( $file_path, $file_name );
								}
							}

							//check page
							if (isset($_POST['import_extra']) && in_array( $current_set, $_POST['import_extra'] ) ) {

								$force_attach = false;
								//check attachments
								if (isset($_POST['import_attach']) && in_array( $current_set, $_POST['import_attach'] ) ) {
									$force_attach = true;
								}

								$file_path = $demo_sets[$current_set]['extra'] . '.xml.gz';
								$this->import_content( $file_path, $force_attach );
							}

						}


					} else {

						switch ( $_POST['import'] ) {

							case 'all':
								// Full Demo Data ---------------------------------
								$this->import_content();
								$this->import_menu_location();
								$this->import_widget();

								// set home & blog page
								$home = get_page_by_title( 'Home Default' );
								$blog = get_page_by_title( 'Blog' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
									update_option( 'page_for_posts', $blog->ID ); // Blog Page
								}
								break;

							case 'all-geodirectory':
								// Geo Directory Demo Data ---------------------------------
								$this->import_content( 'pages/home-geodirectory.xml.gz' );

								//widgets
								$file_path = KLEO_LIB_URI . '/importer/demo/widget_data_geodirectory.json';
								$file_data = wp_remote_get( $file_path );
								$data      = $file_data['body'];
								$this->import_widget_data( $data );

								// set home & blog page
								$home = get_page_by_title( 'Home Business Directory' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
								}
								break;

							case 'all-agency':
								// Full Agency Demo Data ---------------------------------
								$this->import_content( 'all-agency.xml.gz' );
								//$this->import_menu_location();
								$this->import_widget();

								// set home & blog page
								$home = get_page_by_title( 'Home' );
								$blog = get_page_by_title( 'Blog' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
									update_option( 'page_for_posts', $blog->ID ); // Blog Page
								}
								break;

							case 'all-news':
								// Full News Demo Data ---------------------------------
								$this->import_content( 'all-news.xml.gz' );

								// set home & blog page
								$home = get_page_by_title( 'Home News Magazine' );

								if ( $home->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
								}
								break;

							case 'content':
								if ( $_POST['content'] ) {
									$_POST['content'] = htmlspecialchars( stripslashes( $_POST['content'] ) );
									$file             = 'content/' . $_POST['content'] . '.xml.gz';
									$this->import_content( $file );

									if ( $_POST['content'] == 'pages' ) {
										// set home & blog page
										$home = get_page_by_title( 'Home Default' );
										$blog = get_page_by_title( 'Blog' );
										if ( $home->ID && $blog->ID ) {
											update_option( 'show_on_front', 'page' );
											update_option( 'page_on_front', $home->ID ); // Front Page
											update_option( 'page_for_posts', $blog->ID ); // Blog Page
										}
									}

								} else {
									$this->import_content();
								}
								break;

							case 'page':
								// page ---------------------------------------
								$_POST['page'] = htmlspecialchars( stripslashes( $_POST['page'] ) );
								$file          = 'pages/' . $_POST['page'] . '.xml.gz';
								$this->import_content( $file );
								break;

							case 'menu':
								// Menu -------------------------------------------
								$this->import_content( 'menu.xml.gz' );
								$this->import_menu_location();
								break;

							case 'widgets':
								// Widgets ----------------------------------------
								$this->import_widget();
								break;

							case 'widgets-geodirectory':
								// Widgets ----------------------------------------
								$file_path = KLEO_LIB_URI . '/importer/demo/widget_data_geodirectory.json';
								$file_data = wp_remote_get( $file_path );
								$data      = $file_data['body'];
								$this->import_widget_data( $data );
								break;

							default:
								// Empty select.import
								$this->error = __( 'Please select data to import.', 'kleo_framework' );
								break;
						}

					}
					// message box
					if( $this->error ){
						echo '<div class="error settings-error">';
							echo '<p><strong>'. $this->error .'</strong></p>';
						echo '</div>';
					} else {
						echo '<div class="updated settings-error">';
							echo '<p><strong>'. __('Import successful. Have fun!','kleo_framework') .'</strong></p>';
						echo '</div>';
					}

				}
	
			}
		}

		?>
		<div id="kleo-wrapper" class="kleo-import wrap">
		
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			

            <h3 style="margin-bottom: 0;">Please read:</h3>
            <p>
	            <strong>Not all images are imported</strong> so you need to add your own. See also <a target="_blank" href="http://seventhqueen.com/support/documentation/kleo#section-background">Changing Section backgrounds</a> documentation.<br>
            </p>


			<style>
				.demos-wrapper {
					display: -webkit-flex;
					display: -ms-flexbox;
					display: flex;

					-webkit-flex-wrap: wrap;
					-ms-flex-wrap: wrap;
					flex-wrap: wrap;
				}
				.import-demo {
					width: 33.3%;
					float:left;
					display: -webkit-flex;
					display: -ms-flexbox;
					display: flex;
				}
				.demo-wrapper {
					box-sizing: border-box;
					background: #f4f4f4;
					border: 1px solid #ccc;
					margin: 10px;
					width: 100%;
				}
				.import-demo img {
					width:100%;
					max-width: 100%;
				}
				.import-demo .demo-options {
					padding: 10px;
					min-height:88px;
				}
				.import-demo button {
					margin-top: 20px !important;
					float: right;
				}
			    .kleo-import-form h3 {
					background-color: #333;
					color: #fff;
					padding: 10px 5px;
				}
				.to-left {
					width: 80%;
					float:left
				}
				span.demo-title {
					font-weight:bold;
					padding-bottom: 10px;
					display: block;
				}
				span.demo-detail {
					display: block;
					padding-top: 10px;
					font-weight: bold;
					font-style: italic;
				}
				.img-wrapper {
					position: relative;
				}
				span.preview-btn {
					color: #fff;
					font-size: 16px;
					font-weight: bold;
					display: none;
					position: absolute;
					top: 50%;
					left: 40%;
				}
				.demo-wrapper:hover span.solid-bg {
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					position: absolute;
					background-color: rgba(0,0,0,0.3);
				}
				.demo-wrapper:hover span.preview-btn {
					display: block;
				}
				@media (max-width: 768px) {
					.import-demo {
						width: 50%;
					}
					.to-left {
						width: 100%;
					}
				}
				@media (max-width: 480px) {
					.import-demo {
						width: 100%;
					}
				}

			</style>
			<form class="kleo-import-form" action="" method="post" onSubmit="if(!confirm('Really import the data?')){return false;}">
				
				<input type="hidden" name="kleo_import_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

				<h3>Import Specific Demo page</h3>

				<div class="demos-wrapper">

					<?php
					$demo_sets = self::get_demo_sets();

					?>

					<?php foreach( $demo_sets as $k => $v ) : ?>

					<div class="import-demo">
						<div class="demo-wrapper">
							<div class="img-wrapper">
								<a href="<?php echo $v['link'];?>" target="_blank">
									<img src="<?php echo $v['img'];?>">
									<span class="solid-bg"></span>
									<span class="preview-btn"><span class="dashicons dashicons-visibility"></span> PREVIEW</span>
								</a>
							</div>
							<div class="demo-options">
								<div class="to-left">
									<span class="demo-title"><?php echo $v['name'];?></span>

									<?php if (isset($v['page'])) : ?>
										<label><input type="checkbox" name="import_page[]" checked value="<?php echo $k;?>" class="check-page"> Import Page</label>
										<br>
									<?php endif; ?>

									<?php if (isset($v['extra'])) : ?>
										<label><input type="checkbox" name="import_extra[]" value="<?php echo $k;?>" class="check-page"> <?php echo $v['extra_name']; ?></label>
										<br>
									<?php endif; ?>

									<?php if (isset($v['attach'])) : ?>
										<label><input type="checkbox" name="import_attach[]" checked value="<?php echo $k;?>" class="check-attachment"> Import Images</label>
										<br>
									<?php endif; ?>

									<?php if (isset($v['widgets'])) : ?>
										<label><input type="checkbox" name="import_widgets[]" checked value="<?php echo $k;?>"> Import Widgets</label>
										<br>
									<?php endif; ?>

									<?php if (isset($v['revslider'])) : ?>
										<label><input type="checkbox" name="import_revslider[]" checked value="<?php echo $k;?>"> Import Revolution Slider</label>
										<br>
									<?php endif; ?>

									<?php if (isset($v['details'])) : ?>
										<span class="demo-detail"><?php echo $v['details']; ?></span>
									<?php endif; ?>
								</div>
								<button type="submit" name="import_demo" value="<?php echo $k;?>" class="button button-primary import-demo-btn">Import</button>
								<div class="clear clearfix"></div>
							</div>
						</div>
					</div>

					<?php endforeach; ?>

				</div>
				<div class="clear clearfix"></div>


				<h3>Advanced data import</h3>

				<p>
					<strong>Please note:</strong><br>
					- Don't do the import twice since <strong>it will duplicate all your content</strong>.<br>
					- Importing Widgets will remove any existing widgets assigned to your sidebars.<br>
					- Importing All the demo content will take some time so be patient. A better option is to import by content type or just what pages you need.<br>
					- <strong>Revolution Sliders are not imported in this advanced section</strong>. Activate the plugin and click Import Slider from <a target="_blank" href="<?php echo admin_url();?>/admin.php?page=revslider">Revolution Slider</a>.<br>
					Exported sliders can be found in the package downloaded inside the Demo content folder<br><br>

					<strong>Note on some page demos:</strong><br>
					- News Magazine <br>
					&nbsp;&nbsp;&nbsp;&nbsp; - Import Revolution Slider: news-magazine.zip. <br>
					&nbsp;&nbsp;&nbsp;&nbsp; - Please edit the imported slider template and <strong>choose your post categories</strong> for it to work.<br>
					- Get Connected demos &nbsp;>>&nbsp; It requires BP Profile Search plugin<br>
					- Material Design Colors &nbsp;>>&nbsp; We used: Theme options - Styling options - Header - Color Preset - Deep Purple/Amber<br>
					- Home Sensei eLearning &nbsp;>>&nbsp; Uses Sensei plugin and MailChimp for WordPress plugin for the bottom form.<br>
					- GeoDirectory: Please read the <a target="_blank" href="http://seventhqueen.com/support/documentation/kleo#geo-directory">documentation</a>.
				</p>

				<table class="form-table">
				
					<tr class="row-import">
						<th scope="row">
							<label for="import">Import</label>
						</th>
						<td>
							<select name="import" class="import">
								<option value="">-- Select --</option>
								<option data-attach="yes" value="all">All from Main Demo</option>
								<option data-attach="yes" value="all-agency">All from Agency MultiSite</option>
								<option data-attach="yes" value="all-news">All from News Magazine(Home page + posts)</option>
                                <option value="all-geodirectory">All from GeoDirectory(Home + widgets)</option>
                                <option value="content">By content type</option>
								<option value="page">Specific Page</option>
								<option value="widgets">Widgets</option>
								<option value="widgets-geodirectory">Widgets - Geodirectory</option>
                                <option value="menu">Menu</option>
							</select>
						</td>
					</tr>
					
					<tr class="row-content hide hidden">
						<th scope="row">
							<label for="content">Content</label>
						</th>
						<td>
							<select name="content">
								<option value="">-- All --</option>
								<option data-attach="yes" value="pages">Pages</option>
								<option value="posts">Posts</option>
								<option value="clients">Clients</option>
								<option value="portfolio">Portfolio</option>
								<option value="testimonials">Testimonials</option>
								<option value="products-dummy">Woocommerce Products</option>
							</select>
						</td>
					</tr>
					
					<tr class="row-homepage hide hidden">
						<th scope="row">
							<label for="page">Homepage</label>
						</th>
						<td>
							<select name="page">
								<option value="home-community">Home Default(Community)</option>
								<option value="home-pinterest">Home Pinterest</option>
                                <option data-attach="yes" value="home-news-magazine">Home News Magazine</option>
                                <option data-attach="yes" value="home-material">Home Material Design</option>
                                <option data-attach="yes" value="home-get-connected">Home Get Connected</option>
                                <option data-attach="yes" value="home-get-connected-vertical">Home Get Connected Vertical</option>
                                <option data-attach="yes" value="home-product-landing">Home Product Landing Page</option>
                                <option data-attach="yes" value="home-mobile-app">Home Mobile App</option>
                                <option data-attach="yes" value="home-resume">Home Resume</option>
                                <option data-attach="yes" value="home-sensei">Home Sensei e-Learning</option>
								<option value="home-company" data-attach="yes">Home Company(v4.0)</option>
                                <option value="home-geodirectory">Home Business Directory</option>
								<option value="home-elearning">Home e-Learning</option>
								<option value="home-portfolio-full">Home Portfolio Full-Width</option>
								<option value="home-shop">Home Shop</option>
								<option value="home-stylish-woo">Home Stylish Woocommerce</option>
								<option value="home-black-friday">Home Black Friday</option>
								<option value="home-onepage">Home One Page Website</option>
								<option value="home-simple">Home Simple</option>
								<option value="home-xmas">Merry Christmas</option>
								<option value="home-new-year">Happy New Year</option>
								<option value="happy-halloween">Happy Halloween</option>
								<option value="spooky-halloween">Spooky Halloween</option>
								<option value="contact-us">Contact us</option>
								<option value="no-breadcrumb">No Breadcrumb Page</option>
								<option value="poi-pins">POIs and Pins</option>
							</select>
						</td>
					</tr>
					
					<tr class="row-attachments hide hidden">
						<th scope="row">Attachments</th>
						<td>
							<fieldset>
								<label for="attachments"><input type="checkbox" value="1" id="attachments" name="attachments">Import attachments</label>
								<p class="description">Download all attachments from the demo may take a while. Please be patient.</p>
							</fieldset>
						</td>
					</tr>
				
				</table>
	
				<input type="submit" name="submit" class="button button-primary advanced" value="Import demo data" />
					
			</form>
	
		</div>
		<?php	
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Parse JSON import file
     * @param $json_data
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function import_widget_data( $json_data ) {

		$json_data 		= json_decode( $json_data, true );
		$sidebar_data 	= $json_data[0];
		$widget_data 	= $json_data[1];
 		//print_r($sidebar_data);exit;
	
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

        $current_sidebars 	= get_option( 'sidebars_widgets' );
		$new_widgets 		= array( );

// 		print_r($sidebars_data);
// 		print_r($current_sidebars);

        foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

            $current_sidebars[$import_sidebar] = array();

            foreach ( $import_widgets as $import_widget ) :
                //if the sidebar exists
                if ( isset( $current_sidebars[$import_sidebar] ) ) :

                    $title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                    $index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                    $current_widget_data = get_option( 'widget_' . $title );
                    $new_widget_name = self::get_new_widget_name( $title, $index );
                    $new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
                    if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
                        while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                            $new_index++;
                        }
                    }
                    $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                    if ( array_key_exists( $title, $new_widgets ) ) {
                        $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                        $multiwidget = $new_widgets[$title]['_multiwidget'];
                        unset( $new_widgets[$title]['_multiwidget'] );
                        $new_widgets[$title]['_multiwidget'] = $multiwidget;
                    } else {
                        $current_widget_data[$new_index] = $widget_data[$title][$index];
                        $current_multiwidget = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : '' ;
                        $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                        $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                        unset( $current_widget_data['_multiwidget'] );
                        $current_widget_data['_multiwidget'] = $multiwidget;
                        $new_widgets[$title] = $current_widget_data;
                    }
                endif;
            endforeach;
        endforeach;
        if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
            update_option( 'sidebars_widgets', $current_sidebars );
            foreach ( $new_widgets as $title => $content ) {
                $content = apply_filters( 'widget_data_import', $content, $title );
                update_option( 'widget_' . $title, $content );
            }
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

$kleo_import = new kleoImport;