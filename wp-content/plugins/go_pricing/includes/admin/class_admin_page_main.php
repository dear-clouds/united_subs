<?php
/**
 * Main menu page controller class
 */
 
 
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_AdminPage_Main extends GW_GoPricing_AdminPage {
	
	/**
	 * Register ajax actions
	 *
	 * @return void
	 */		
	
	public function register_ajax_actions( $ajax_action_callback ) { 
	
		GW_GoPricing_Admin::register_ajax_action( 'table_manager', $ajax_action_callback );
		GW_GoPricing_Admin::register_ajax_action( 'table_editor', $ajax_action_callback );	
		GW_GoPricing_Admin::register_ajax_action( 'table_column', $ajax_action_callback );	
		GW_GoPricing_Admin::register_ajax_action( 'table_row', $ajax_action_callback );
		GW_GoPricing_Admin::register_ajax_action( 'table_button', $ajax_action_callback );	
		GW_GoPricing_Admin::register_ajax_action( 'popup', $ajax_action_callback );
		GW_GoPricing_Admin::register_ajax_action( 'editor_popup', $ajax_action_callback );
		GW_GoPricing_Admin::register_ajax_action( 'editor_columns', $ajax_action_callback );
		GW_GoPricing_Admin::register_ajax_action( 'export', $ajax_action_callback );		
		
	}
	

	/**
	 * Action
	 *
	 * @return void
	 */	
	 	
	public function action() {
		
		// Create custom nonce
		$this->create_nonce( 'main' );
		
		// Load views if action is empty
		if ( empty( $this->action ) ) {
			
			$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
			
			switch ( $action ) {
				
				case 'create':
					// Load table editor view
					$this->content( $this->view( 'table_editor' ) );
					break;					
				
				case 'edit':
				
					$result = GW_GoPricing_Data::get_table( (int)$_GET['id'] );
					
					if ( empty( $result ) ) {
						// Load table manager view
						$this->content( $this->view() );
					} else {
						// Load table editor view
						$this->content( $this->view( 'table_editor' ) );
					}
					
					break;

				default:

					// Load table manager view	
					$this->content( $this->view() );	

			}
			
		}
		
		// Load views if action is not empty (handle postdata)
		if ( !empty( $this->action ) && check_admin_referer( $this->nonce, '_nonce' ) ) {
		
			switch( $this->action ) {
				
				// Table manager page (action)
				case 'table_manager': 
					
					if ( !empty( $this->action_type ) ) {
						
						switch( $this->action_type ) {

							// Create (action type)
							case 'create':								
								
								// Redirect / Load view
								if ( $this->is_ajax === false ) {
									wp_redirect( ( add_query_arg( 'action', 'create', 'admin.php?page=go-pricing' ) ) );	
									exit;
								} else {
									echo $this->view( 'table_editor' );
								}
												
								break;

							// Edit (action type)
							case 'edit':
							
								$result = $this->validate_edit( (int)$_POST['postid'] );
								
								// Check whether table id is valid/invalid
								if ( $result === false ) {
									
									// Redirect / Load view
									if ( $this->is_ajax === false ) {
										wp_redirect( admin_url( 'admin.php?page=go-pricing' ) );	
										exit;
									} else {
										GW_GoPricing_AdminNotices::show();
									}									
								
								} else {
									
									// Redirect / Load view
									if ( $this->is_ajax === false ) {
										wp_redirect( ( add_query_arg( array( 'action' => 'edit', 'id' => $_POST['postid'] ), admin_url( 'admin.php?page=go-pricing' ) ) ) );	
										exit;
									} else {																			
										echo $this->view( 'table_editor' );
									}
									
								}
												
								break;
							
							// Copy	(action type)
							case 'copy':
								
								$result = $this->copy_table( $_POST['postid'] );
								
								// Redirect / Load view
								if ( $this->is_ajax === false ) {
									wp_redirect( admin_url( 'admin.php?page=go-pricing' ) );	
									exit;
								} else {
									echo $this->view();
									GW_GoPricing_AdminNotices::show();
								}
																								
								break;	
								
							// Delete (action type)
							case 'delete':
								
								$result = $this->delete_table( $_POST['postid'] );
																
								// Redirect / Load view
								if ( $this->is_ajax === false ) {
									wp_redirect( admin_url( 'admin.php?page=go-pricing' ) );	
									exit;
								} else {
									echo $this->view();
									GW_GoPricing_AdminNotices::show();
								}
															
								break;
								
							// Order (action type)
							case 'order':
								
								$user_id = get_current_user_id();
								
								if ( !empty( $_POST['_order'] ) && !empty( $_POST['_orderby'] ) ) {
									
									switch ( $_POST['_order'] ) { 
										case 'ASC' : 
										case 'DESC' : 
											setcookie( "go_pricing[settings][tm][order][$user_id]", $_POST['_order'] );
											break;
										
									}
									
									switch ( $_POST['_orderby'] ) { 
										case 'ID' : 
										case 'title' :
										case 'date' :
										case 'modified' :
											setcookie( "go_pricing[settings][tm][orderby][$user_id]", $_POST['_orderby'] );
											break;
										
									}
									
								}
								
								// Redirect / Load view
								if ( $this->is_ajax === false ) {
									wp_redirect( admin_url( 'admin.php?page=go-pricing' ) );	
									exit;
								} else {
									echo $this->view();
									GW_GoPricing_AdminNotices::show();
								}								
								
								break;
								
							// Export (action type)
							case 'export':

								if ( empty( $_POST['postid'] ) ) return;
								
								$table_ids = explode( ',', $_POST['postid'] );
								
								$result = $this->validate_export_data( $table_ids );
								
								if ( $result === false ) {

									if ( $this->is_ajax === false ) {
										wp_redirect( $this->referrer );	
										exit;
									} else {
										GW_GoPricing_AdminNotices::show();
									}
									
								} else {
									
									$this->set_temp_postdata( $table_ids );
									
									if ( $this->is_ajax === false ) {
										wp_redirect(  add_query_arg( array( 'action' => 'export' ), admin_url( 'admin.php?page=go-pricing-import-export' ) ) );	
										exit;
									} else {
										echo '<div id="download_url">' . add_query_arg( array( 'action' => 'export' ), admin_url( 'admin.php?page=go-pricing-import-export' ) ) . '</div>';
									}

								}
															
								break;																																
							
						}
						
					}

					break;

				// Import page (action)
				case 'table_editor':

					$result = $this->save_table( $_POST );
					
					if ( $result === false ) { 
						
						if ( $this->is_ajax === false ) {
							wp_redirect( add_query_arg( 'action', 'create', $this->referrer ) );
							exit;
						} else {
							GW_GoPricing_AdminNotices::show();
						}
					
					} else {
						
						if ( $this->is_ajax === false ) {
							wp_redirect( add_query_arg( array( 'action' => 'edit', 'id' => $result ), admin_url( 'admin.php?page=go-pricing' ) ) );	
							exit;
						} else {
							echo '<div id="postid">' . $result . '</div>';
							GW_GoPricing_AdminNotices::show();
						}
						
					}
												
					break;
										
				// Add new column (ajax action type)
				case 'table_column':
					$body_row_count = isset( $_POST['body_row_count'] ) ? (int)$_POST['body_row_count'] : 0;
					$footer_row_count = isset( $_POST['footer_row_count'] ) ? (int)$_POST['footer_row_count'] : 0;					
					echo $this->get_column( null, $body_row_count, $footer_row_count );
					break;
					
				// Add new body row (ajax action type)
				case 'table_row':
					echo $this->get_column_body( null, null, 1);		
					break;
					
				// Add new footer row (ajax action type)
				case 'table_button':
					echo $this->get_column_footer( null, null, 1);		
					break;	
					
				// Load popup (ajax action type)
				case 'popup':
					echo $this->load_popup();		
					break;	
					
				// Load editor popup (ajax action type)
				case 'editor_popup':
					echo $this->editor_popup();		
					break;						
					
				// (Re)load editor (ajax action type)
				case 'editor_columns':
					echo $this->get_global_style_opts( (int)$_POST['postid'] );
					echo $this->get_editor_columns();		
					break;																															
									
			}
			
		}
		
	}
	
	
	/**
	 * Load views
	 *
	 * @return string
	 */	
	
	public function view( $view = '' ) {

		ob_start();
		
		switch( $view ) {
			case 'table_editor' :
				include_once( 'views/page/table_editor.php' );	
				break;						
				
			default:
				include_once( 'views/page/table_manager.php' );				
		};
		
		return ob_get_clean();
		
	}

	/**
	 * Editor popup ajax callback
	 *
	 * @return string
	 */	
	
	public function editor_popup() {

		if ( empty( $this->action_type ) ) return;

		global $go_pricing;
		
		if ( !empty( $_POST['data'] ) ) parse_str( $_POST['data'], $postdata ); 
		
		if (isset( $postdata ) ) $postdata = GW_GoPricing_Helper::clean_input( $postdata, 'html' );

		ob_start();	
		$file = "views/editor_popup/{$this->action_type}.php";
		$file = apply_filters( "go_pricing_admin_editor_popup_{$this->action_type}", $file );
		include_once( $file );	
		$content = ob_get_clean();
		include_once( 'views/view_editor_popup.php' );

	}



	/**
	 * Validate edit
	 *
	 * @return string | bool
	 */		

	public function validate_edit( $data ) { 
	
		if ( empty( $data ) ) {
			
			GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Please select a table!', 'go_pricing_textdomain' ) );
			return false;
			
		} else {
		
			$result = GW_GoPricing_Data::get_table( (int)$data );

			if ( $result === false ) {
				GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Table doesn\'t exist!', 'go_pricing_textdomain' ) );
				return false;
			}
			
		} 

		return true;
		
	}
	
	
	/**
	 * Clone table
	 *
	 * @return string | bool
	 */		

	public function copy_table( $data ) { 

		if ( empty( $data ) ) {
			
			GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Please select a table!', 'go_pricing_textdomain' ) );
			return;
			
		}
		
		$cnt = 0; 
		global $wpdb;
	
		$data = GW_GoPricing_Helper::clean_input( $data );
		
		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );		
		
		$wpdb->query( 'SET autocommit = 0;' );	
		
		$table_ids = explode( ',', $data );
		
		foreach ( (array)$table_ids as $table_id ) {
		
			$table_data = GW_GoPricing_Data::get_table( (int)$table_id );

			if ( !empty( $table_data ) ) {
				
				if ( !empty( $table_data['postid'] ) ) unset( $table_data['postid'] );
				$table_data['name'] .= ' (' . __( 'copy', 'go_pricing_textdomain' ) . ')';	
				$table_data['id'] = substr( $table_data['id'], 0 ,10 ) . '_' . uniqid();

				$result = GW_GoPricing_Data::update_table( $table_data );
				$cnt++; 
				
				if ( $result === false ) {
					GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );
					break;
				}
						
			} else {
				GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );
				break;
			}

		}
		
		$notices = GW_GoPricing_AdminNotices::get( 'main', 'error' );
		
		if ( empty( $notices ) ) GW_GoPricing_AdminNotices::add( 'main', 'success', sprintf( __( '%1$s pricing table(s) has been successfully cloned.', 'go_pricing_textdomain' ), $cnt ) );
		
		$wpdb->query( 'COMMIT;' );
		$wpdb->query( 'SET autocommit = 1;' );

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );
		
	}
	
	
	/**
	 * Delete table
	 *
	 * @return bool
	 */		

	public function delete_table( $data ) { 

		if ( empty( $data ) ) {
			
			GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Please select a table!', 'go_pricing_textdomain' ) );
			return;
			
		}

		$cnt = 0; 
		global $wpdb;
	
		$data = GW_GoPricing_Helper::clean_input( $data );
		
		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );		
		
		$wpdb->query( 'SET autocommit = 0;' );	
		
		$table_ids = explode( ',', $data );

		foreach ( (array)$table_ids as $table_id ) {
			
			$result = GW_GoPricing_Data::delete_table( (int)$table_id );
			$cnt++;
			
			if ( $result === false ) {
				GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );
				break;
			}
		}

		$notices = GW_GoPricing_AdminNotices::get( 'main', 'error' );
		
		if ( empty( $notices ) ) GW_GoPricing_AdminNotices::add( 'main', 'success', sprintf( __( '%1$s pricing table(s) has been successfully deleted.', 'go_pricing_textdomain' ), $cnt ) );
		
		$wpdb->query( 'COMMIT;' );
		$wpdb->query( 'SET autocommit = 1;' );

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

	}	
	
	
	/**
	 * Validate & export data
	 *
	 * @return string | bool
	 */		

	public function validate_export_data( $export_data ) { 
		
		if ( empty( $export_data ) ) {

			GW_GoPricing_AdminNotices::add( 'impex', 'error', __( 'There is nothing to export!', 'go_pricing_textdomain' ) );
			return false;
			
		} else {
			
			$export_data = $export_data[0] == 'all' ? array() : $export_data;
			$result = GW_GoPricing_Data::export( $export_data );
			
			if ( $result === false ) { 
			
				GW_GoPricing_AdminNotices::add( 'impex', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );	
				return false;

			}
			
		}
		
		if ( empty( $export_data ) ) $export_data  = 'all';
		
		return $export_data;

	}
		
	
	/**
	 * Save table
	 *
	 * @return bool
	 */		

	public function save_table( $data ) { 
	
		if ( empty( $data['name'] ) ) GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Pricing "Table Name" is empty!', 'go_pricing_textdomain' ), false );		
		
		if ( empty( $data['id'] ) ) {
			GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Pricing "Table ID" is empty!', 'go_pricing_textdomain' ), false );

		} elseif ( strlen( $data['id'] ) >= 1 && preg_match( '/([^a-z0-9\-_])+/' , $data['id'] ) == 1 ) {
			GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Pricing "Table ID" can contain only lowercase letters, numbers, hyphens and underscores!', 'go_pricing_textdomain' ), false );
		} else {
			$tables = GW_GoPricing_Data::get_tables();
			foreach ( (array)$tables as $table_key => $table ) {
				$table_ids[$table_key] = $table['id'];
			}
			if ( !empty( $data['postid'] ) && !empty( $table_ids[$data['postid']] ) ) unset( $table_ids[$data['postid']] );
			if ( in_array( $data['id'], $table_ids ) ) GW_GoPricing_AdminNotices::add( 'main', 'error', sprintf( __( 'Pricing table with an ID of "%s" already exists! It must be uniqe.', 'go_pricing_textdomain' ), $data['id'] ), false );
		}
				
		$notices = GW_GoPricing_AdminNotices::get( 'main', 'error' );
		
		// Exclude col data
		if ( isset( $data['col-data'] ) ) $col_data = GW_GoPricing_Helper::clean_input( $data['col-data'], 'html' ); 

		// Clean custom CSS
		if ( isset( $data['custom-css'] ) ) {
			$custom_css = GW_GoPricing_Helper::clean_input( array( $data['custom-css'] ), 'no_html' );
			$data['custom-css'] = $custom_css[0];
		}		
		
		// Clean postdata (the rest)
		$data = GW_GoPricing_Helper::clean_input( $data, 'filtered', '', array( 'custom-css' ) );

		if ( isset( $col_data ) ) $data['col-data'] = $col_data;	
		
		if ( empty( $notices ) ) {

			$data = GW_GoPricing_Helper::remove_input( $data, array( $_POST['action'] ) );
			$postid = GW_GoPricing_Data::update_table( $data );
			
			if ( $postid !== false ) {
				
				// Create table message
				if ( empty( $data['postid'] ) ) {
					GW_GoPricing_AdminNotices::add( 'main', 'success', sprintf( __( 'Pricing table has been successfully created!<br>Shortcode: </strong>[go_pricing id="%s"]<strong>', 'go_pricing_textdomain' ), $data['id'] ) );
				} else {
					GW_GoPricing_AdminNotices::add( 'main', 'success', sprintf( __( 'Pricing table has been successfully updated!<br>Shortcode: </strong>[go_pricing id="%s"]<strong>', 'go_pricing_textdomain' ), $data['id'] ) );
				}
				return $postid;
			} else {
				GW_GoPricing_AdminNotices::add( 'main', 'error', __( 'Oops, something went wrong!', 'go_pricing_textdomain' ) );	
			}				

		} else {
			$this->set_temp_postdata( $data );
		}
		
		return false;

	}		
	

	/**
	 * Relod editor
	 *
	 * @return void
	 */	


	public function get_editor_columns() {

		$table_data = !empty( $_POST['postid'] ) ? GW_GoPricing_Data::get_table( (int)$_POST['postid'] ) : null;		
		$table_data['style'] = $_POST['param']['style'];

		if (!empty( $_POST['postid'] ) ) {
			$this->get_column( $table_data );
		}
	
	
		
	}
	

	/**
	 * Get style global options
	 *
	 * @return void
	 */	
	
	public function get_global_style_opts() {

		$table_data = !empty( $_POST['postid'] ) ? GW_GoPricing_Data::get_table( (int)$_POST['postid'] ) : null;
		$style = !empty( $_POST['param']['style'] )  ? $_POST['param']['style'] : 'clean';
		echo '<div id="go-pricing-global-style">';
		do_action( "go_pricing_admin_global_style_opts_{$style}", !empty( $table_data ) ? $table_data : '' );
		echo '</div>';		 
	}	


	/**
	 * Load column
	 *
	 * @return void
	 */	
	 
	public function get_column(  $table_data = null, $row_count = 0, $button_count = 0  ) { 
	
		if ( !empty( $table_data['col-data'] ) ) {
			$col_count = count( $table_data['col-data'] );
		} else {
			$col_count = 1;
		}	
		
		for ($x = 0; $x < $col_count; $x++) {
			include( 'views/column/column.php' );
		}
	
	}
	
	/**
	 * Load general part of the column
	 *
	 * @return void
	 */	
	 
	public function get_column_general( $table_data = null, $col_index = null ) { 
		
		if ( !empty( $table_data['col-data'] ) && isset( $col_index ) ) {
			$col_data = $table_data['col-data'][$col_index];
		}
	
		include( 'views/column/general.php' );	
	
	}


	/**
	 * Load header part of column (for future?)
	 *
	 * @return void
	 */	
	 
	public function get_column_price( $table_data = null, $col_index = null ) { 
			
		if ( !empty( $table_data['col-data'] ) && isset( $col_index ) ) {
			$col_data = $table_data['col-data'][$col_index];
		}		
		
		include( 'views/column/price.php' );	
	
	}	
	
	
	/**
	 * Load header part of column
	 *
	 * @return void
	 */	
	 
	public function get_column_header( $table_data = null, $col_index = null ) { 
		
		if ( !empty( $table_data['col-data'] ) && isset( $col_index ) ) {
			$col_data = $table_data['col-data'][$col_index];
		}		
		
		include( 'views/column/header.php' );	
	
	}	
	
	
	/**
	 * Load body part of column
	 *
	 * @return void
	 */	
	 
	public function get_column_body( $table_data = null, $col_index = null,  $row_count = 0 ) { 
		
		$row_count = (int)$row_count;

		if ( !empty( $table_data['col-data'] ) && isset( $col_index ) ) {
			$col_data = $table_data['col-data'][$col_index];
		}			
		
		if ( !empty ( $col_data['body-row'] ) && is_array( $col_data['body-row'] ) ) {
			$row_count = count( $col_data['body-row'] ); 
			$row_data = $col_data['body-row'];
		}		
		
		include( 'views/column/body.php' );	
	
	}
		
	
	/**
	 * Load footer part of column
	 *
	 * @return void
	 */	
	 
	 
	public function get_column_footer( $table_data = null, $col_index = null,  $footer_row_count = 0 ) { 
		
		$footer_row_count = (int)$footer_row_count;

		if ( !empty( $table_data['col-data'] ) && isset( $col_index ) ) {
			$col_data = $table_data['col-data'][$col_index];
		}			
		
		if ( !empty ( $col_data['footer-row'] ) && is_array( $col_data['footer-row'] ) ) {
			$footer_row_count = count( $col_data['footer-row'] ); 
			$footer_row_data = $col_data['footer-row'];
		} 
				
		include( 'views/column/footer.php' );	
	
	}
	
	
	/**
	 * Load column part
	 *
	 * @return void
	 */	
	 
	public function get_column_include( $name = '', $parent, $inc_data, $col_index = null, $row_index = null ) { 

		if ( empty( $name ) ) return;
		include( "views/column/part/{$name}.php" );	
	
	}	
	
	
	/**
	 * Load popup
	 *
	 * @return void
	 */	
	 
	public function load_popup() { 
	
		if ( !empty( $this->action_type ) ) {
						
			do_action( "go_pricing_popup_before_{$this->action_type}" );
			
			switch ($this->action_type) {
				
				case 'live-preview' :
					include_once( 'views/popup/live_preview.php' );	
					break;

				case 'live-preview-edit' :
					$noedit = true;
					include_once( 'views/popup/live_preview.php' );	
					break;

				case 'image-preview' :
					include_once( 'views/popup/image_preview.php' );	
					break;
				
				/* sc popups */
				
				case 'sc-media' :
					include_once( 'views/popup/sc_media.php' );	
					break;
					
				case 'sc-font-icon' :
					include_once( 'views/popup/sc_font_icon.php' );	
					break;						
					
				case 'sc-row-icon' :
					include_once( 'views/popup/sc_row_icon.php' );	
					break;											
					
				case 'sc-button-icon' :
					include_once( 'views/popup/sc_button_icon.php' );	
					break;											
								
			}
			
			do_action( "go_pricing_popup_after_{$this->action_type}" );
			
		}
		
		
	}
 
}
?>