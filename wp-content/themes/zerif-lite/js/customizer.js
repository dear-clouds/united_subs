/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	/* Site title and description. */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	/* Header text color. */
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );

	/*****************************************************/
    /***************** 	GENERAL   ************************/
	/*****************************************************/
	
	wp.customize( 'zerif_logo', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '.navbar-brand img' ).removeClass( 'zerif_hidden_if_not_customizer' );
				$( '.zerif_header_title' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '.navbar-brand img' ).addClass( 'zerif_hidden_if_not_customizer' );
				$( '.zerif_header_title' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '.navbar-brand img' ).attr( 'src', to );
		} );
	} );
	
	/* zerif_copyright */
	wp.customize( 'zerif_copyright', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'footer #zerif-copyright' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'footer #zerif-copyright' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'footer #zerif-copyright' ).html( to );
		} );
	} );
	
	
	/*****************************************************/
    /**************	BIG TITLE SECTION *******************/
	/****************************************************/
	
	/* zerif_bigtitle_show */
	wp.customize( 'zerif_bigtitle_show', function( value ) {
		value.bind( function( to ) {
			if ( '1' != to ) {
				$( '.header-content-wrap' ).css( {
					'display': 'block'
				} );
			} else {
				$( '.header-content-wrap' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );
	
	/* zerif_bigtitle_title */
	wp.customize( 'zerif_bigtitle_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '.header-content-wrap h1.intro-text' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '.header-content-wrap h1.intro-text' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '.header-content-wrap h1.intro-text' ).html( to );
		} );
	} );
	
	/* zerif_bigtitle_redbutton_label */
	wp.customize( 'zerif_bigtitle_redbutton_label', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '.header-content-wrap .buttons .red-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '.header-content-wrap .buttons .red-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '.header-content-wrap .buttons .red-btn' ).html( to );
		} );
	} );
	
	/* zerif_bigtitle_redbutton_url */
	wp.customize( 'zerif_bigtitle_redbutton_url', function( value ) {
		value.bind( function( to ) {
			$( '.header-content-wrap .buttons .red-btn' ).attr( "href", to );
		} );
	} );
	
	/* zerif_bigtitle_greenbutton_label */
	wp.customize( 'zerif_bigtitle_greenbutton_label', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '.header-content-wrap .buttons .green-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '.header-content-wrap .buttons .green-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '.header-content-wrap .buttons .green-btn' ).html( to );
		} );
	} );
	
	/* zerif_bigtitle_greenbutton_url */
	wp.customize( 'zerif_bigtitle_greenbutton_url', function( value ) {
		value.bind( function( to ) {
			$( '.header-content-wrap .buttons .green-btn' ).attr( "href", to );
		} );
	} );
	
	/********************************************************************/
	/*************  OUR FOCUS SECTION **********************************/
	/********************************************************************/
	
	/* zerif_ourfocus_show */
	wp.customize( 'zerif_ourfocus_show', function( value ) {
		value.bind( function( to ) {
			if ( '1' != to ) {
				$( 'section.focus' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section.focus' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );
	
	/* title */
	wp.customize( 'zerif_ourfocus_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#focus .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#focus .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#focus .section-header h2' ).html( to );
		} );
	} );
	
	/* subtitle */
	wp.customize( 'zerif_ourfocus_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#focus .section-header div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#focus .section-header div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#focus .section-header div.section-legend' ).html( to );
		} );
	} );
	
	/************************************/
	/******* ABOUT US SECTION ***********/
	/************************************/
	
	/* show/hide */
	wp.customize( 'zerif_aboutus_show', function( value ) {
		value.bind( function( to ) {
			
			if ( '1' != to ) {
				$( 'section.about-us' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section.about-us' ).css( {
					'display': 'none'
				} );
			}

		} );
	} );
	
	/* title */
	wp.customize( 'zerif_aboutus_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .section-header h2' ).html( to );
		} );
	} );
	
	/* subtitle */
	wp.customize( 'zerif_aboutus_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .section-header div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .section-header div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .section-header div.section-legend' ).html( to );
		} );
	} );
	
	/* feature 1 */
	wp.customize( 'zerif_aboutus_feature1_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_1 div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_1 div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_1 div.section-legend' ).html( to );
		} );
	} );
	
	wp.customize( 'zerif_aboutus_feature1_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_1 p' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_1 p' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_1 p' ).html( to );
		} );
	} );
	
	/* feature 2 */
	wp.customize( 'zerif_aboutus_feature2_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_2 div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_2 div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_2 div.section-legend' ).html( to );
		} );
	} );
	
	wp.customize( 'zerif_aboutus_feature2_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_2 p' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_2 p' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_2 p' ).html( to );
		} );
	} );
	
	/* feature 3 */
	wp.customize( 'zerif_aboutus_feature3_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_3 div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_3 div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_3 div.section-legend' ).html( to );
		} );
	} );
	
	wp.customize( 'zerif_aboutus_feature3_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_3 p' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_3 p' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_3 p' ).html( to );
		} );
	} );
	
	/* feature 4 */
	wp.customize( 'zerif_aboutus_feature4_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_4 div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_4 div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_4 div.section-legend' ).html( to );
		} );
	} );
	
	wp.customize( 'zerif_aboutus_feature4_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#aboutus .skill_4 p' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#aboutus .skill_4 p' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#aboutus .skill_4 p' ).html( to );
		} );
	} );
	
	wp.customize( 'zerif_aboutus_clients_title_text', function( value ) {
		value.bind( function( to ) {
			$( '.our-clients .section-footer-title' ).html(to);
		} );
	} );
	
	/******************************************/
    /**********	OUR TEAM SECTION **************/
	/******************************************/
	
	/* show/hide */
	wp.customize( 'zerif_ourteam_show', function( value ) {
		value.bind( function( to ) {
			if ( '1' != to ) {
				$( 'section.our-team' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section.our-team' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );
	
	/* title */
	wp.customize( 'zerif_ourteam_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#team .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#team .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#team .section-header h2' ).html( to );
		} );
	} );
	
	/* subtitle */
	wp.customize( 'zerif_ourteam_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#team .section-header div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#team .section-header div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#team .section-header div.section-legend' ).html( to );
		} );
	} );
	
	/**********************************************/
    /**********	TESTIMONIALS SECTION **************/
	/**********************************************/
	
	/* show/hide */
	wp.customize( 'zerif_testimonials_show', function( value ) {
		value.bind( function( to ) {
			if ( '1' != to ) {
				$( 'section.testimonial' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section.testimonial' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );
	
	/* title */
	wp.customize( 'zerif_testimonials_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#testimonials .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#testimonials .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#testimonials .section-header h2' ).html( to );
		} );
	} );
	
	/* subtitle */
	wp.customize( 'zerif_testimonials_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#testimonials .section-header h6' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#testimonials .section-header h6' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#testimonials .section-header h6' ).html( to );
		} );
	} );
	
	/***********************************************************/
	/********* RIBBONS ****************************************/
	/**********************************************************/
	
	/* zerif_bottomribbon_text */
	wp.customize( 'zerif_bottomribbon_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_bottom' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#ribbon_bottom' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#ribbon_bottom h3' ).html( to );
		} );
	} );
	
	/* zerif_bottomribbon_buttonlabel */
	wp.customize( 'zerif_bottomribbon_buttonlabel', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_bottom a.green-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#ribbon_bottom a.green-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#ribbon_bottom a.green-btn' ).html( to );
		} );
	} );
	
	/* zerif_bottomribbon_buttonlink */
	wp.customize( 'zerif_bottomribbon_buttonlink', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_bottom a.green-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#ribbon_bottom a.green-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#ribbon_bottom a.green-btn' ).attr( "href", to );
		} );
	} );
	
	/* zerif_ribbonright_text */
	wp.customize( 'zerif_ribbonright_text', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_right' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( '#ribbon_right' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( '#ribbon_right h3' ).html( to );
		} );
	} );

	/* zerif_ribbonright_buttonlabel */
	wp.customize( 'zerif_ribbonright_buttonlabel', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_right a.red-btn' ).removeClass( 'zerif_ribbon_btn_label_blank' );
				if ( ! $( '#ribbon_right a.red-btn' ).hasClass( 'zerif_ribbon_btn_label_blank' ) && ! $( '#ribbon_right a.red-btn' ).hasClass( 'zerif_ribbon_btn_link_blank' )  ) {
					$( '#ribbon_right a.red-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
					$( '#ribbon_right' ).removeClass( 'ribbon-without-button' );
				}
			}
			else {
				$( '#ribbon_right a.red-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
				$( '#ribbon_right a.red-btn' ).addClass( 'zerif_ribbon_btn_label_blank' );
				$( '#ribbon_right' ).addClass( 'ribbon-without-button' );
			}
			$( '#ribbon_right a.red-btn' ).html( to );
		} );
	} );
	
	/* zerif_ribbonright_buttonlink */
	wp.customize( 'zerif_ribbonright_buttonlink', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( '#ribbon_right a.red-btn' ).removeClass( 'zerif_ribbon_btn_link_blank' );
				if ( ! $( '#ribbon_right a.red-btn' ).hasClass( 'zerif_ribbon_btn_label_blank' ) && ! $( '#ribbon_right a.red-btn' ).hasClass( 'zerif_ribbon_btn_link_blank' ) ) {
					$( '#ribbon_right a.red-btn' ).removeClass( 'zerif_hidden_if_not_customizer' );
					$( '#ribbon_right' ).removeClass( 'ribbon-without-button' );
				}
			}
			else {
				$( '#ribbon_right a.red-btn' ).addClass( 'zerif_hidden_if_not_customizer' );
				$( '#ribbon_right a.red-btn' ).addClass( 'zerif_ribbon_btn_link_blank' );
				$( '#ribbon_right' ).addClass( 'ribbon-without-button' );
			}
			$( '#ribbon_right a.red-btn' ).attr( "href", to );
		} );
	} );
	
	/********************************************************/
    /************	LATEST NEWS SECTION *********************/
	/********************************************************/

	/* zerif_latestnews_show */
	wp.customize( 'zerif_latestnews_show', function( value ) {
		value.bind( function( to ) {
			if ( '1' != to ) {
				$( 'section.latest-news' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section.latest-news' ).css( {
					'display': 'none'
				} );
			}
		} );
	} );
	
	/* zerif_latestnews_title */
	wp.customize( 'zerif_latestnews_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'section.latest-news .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'section.latest-news .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'section.latest-news .section-header h2' ).html( to );
		} );
	} );
	
	/* zerif_latestnews_subtitle */
	wp.customize( 'zerif_latestnews_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'section.latest-news .section-header div.section-legend' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'section.latest-news .section-header div.section-legend' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'section.latest-news .section-header div.section-legend' ).html( to );
		} );
	} );

	/*******************************************************/
    /************	CONTACT US SECTION *********************/
	/*******************************************************/
	
	/* show/hide */
	wp.customize( 'zerif_contactus_show', function( value ) {
		value.bind( function( to ) {

			if ( '1' != to ) {
				$( 'section#contact' ).css( {
					'display': 'block'
				} );
			} else {
				$( 'section#contact' ).css( {
					'display': 'none'
				} );
			}

		} );
	} );
	
	/* title */
	wp.customize( 'zerif_contactus_title', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'section#contact .section-header h2' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'section#contact .section-header h2' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'section#contact .section-header h2' ).html( to );
		} );
	} );
	
	/* subtitle */
	wp.customize( 'zerif_contactus_subtitle', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'section#contact .section-header h6' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'section#contact .section-header h6' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'section#contact .section-header h6' ).html( to );
		} );
	} );
	
	/* zerif_contactus_button_label */
	wp.customize( 'zerif_contactus_button_label', function( value ) {
		value.bind( function( to ) {
			if( to != '' ) {
				$( 'section#contact form button' ).removeClass( 'zerif_hidden_if_not_customizer' );
			}
			else {
				$( 'section#contact form button' ).addClass( 'zerif_hidden_if_not_customizer' );
			}
			$( 'section#contact form button' ).html( to );
		} );
	} );

} )( jQuery );