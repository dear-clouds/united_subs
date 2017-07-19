/**
 * BuddyBoss JavaScript functionality
 *
 * @since Boss 1.0.0
 * @package  Boss
 *
 * ====================================================================
 *
 * 1. jQuery Global
 * 2. Main BuddyBoss Class
 * 3. Inline Plugins
 */



/**
 * 1. jQuery Global
 * ====================================================================
 */
var jq = $ = jQuery;



/**
 * 2. Main BuddyBoss Class
 *
 * This class takes care of BuddyPress additional functionality and
 * provides a global name space for BuddyBoss plugins to communicate
 * through.
 *
 * Event name spacing:
 * $(document).on( "buddyboss:*module*:*event*", myCallBackFunction );
 * $(document).trigger( "buddyboss:*module*:*event*", [a,b,c]/{k:v} );
 * ====================================================================
 * @return {class}
 */
var BuddyBossMain = ( function ( $, window, undefined ) {

    /**
     * Globals/Options
     */
    var _l = {
        $document: $( document ),
        $window: $( window )
    };

    // Controller
    var App = { };

    // Custom Events
    var Vent = $( { } );

    // Responsive
    var Responsive = { };

    // BuddyPress Defaults
    var BuddyPress = { };

    // BuddyPress Legacy
    var BP_Legacy = { };


    /** --------------------------------------------------------------- */

    /**
     * Application
     */

    // Initialize, runs when script is processed/loaded
    App.init = function () {

        _l.$document.ready( App.domReady );

        BP_Legacy.init();
    }

    // When the DOM is ready (page laoded)
    App.domReady = function () {
        _l.body = $( 'body' );
        _l.$buddypress = $( '#buddypress' );

        Responsive.domReady();
    }

    /** --------------------------------------------------------------- */

    /**
     * BuddyPress Responsive Help
     */
    Responsive.domReady = function () {

        // GLOBALS *
        // ---------
        window.BuddyBoss = window.BuddyBoss || { };

        window.BuddyBoss.is_mobile = null;

        var
            $document = $( document ),
            $window = $( window ),
            $body = $( 'body' ),
            $mobile_check = $( '#mobile-check' ).css( { position: 'absolute', top: 0, left: 0, width: '100%', height: 1, zIndex: 1 } ),
            mobile_width = 720,
            is_mobile = false,
            has_item_nav = false,
            mobile_modified = false,
            swiper = false,
            $main = $( '#main-wrap' ),
            $inner = $( '#inner-wrap' ),
            $buddypress = $( '#buddypress' ),
            $item_nav = $buddypress.find( '#item-nav' ),
            Panels = { },
            inputsEnabled = $( 'body' ).data( 'inputs' ),
            rtl = Boolean( $( 'body' ).data( 'rtl' ) ),
            $selects,
            $mobile_nav_wrap,
            $mobile_item_wrap,
            $mobile_item_nav,
            panel_open_class = 'left-menu-open';

        // Detect android stock browser
        // http://stackoverflow.com/a/17961266
        var isAndroid = navigator.userAgent.indexOf( 'Android' ) >= 0;
        var webkitVer = parseInt( ( /WebKit\/([0-9]+)/.exec( navigator.appVersion ) || 0 )[1], 10 ) || void 0; // also match AppleWebKit
        var isNativeAndroid = isAndroid && webkitVer <= 534 && navigator.vendor.indexOf( 'Google' ) == 0;

        /*------------------------------------------------------------------------------------------------------
         1.0 - Core Functions
         --------------------------------------------------------------------------------------------------------*/

        /**
         * Checks for supported mobile resolutions via media query and
         * maximum window width.
         *
         * @return {boolean} True when screen size is mobile focused
         */
        function check_is_mobile() {
            // The $mobile_check element refers to an empty div#mobile-check we
            // hide or show with media queries. We use this to determine if we're
            // on mobile resolution
            $mobile_check.remove().appendTo( $body );

//                mobile_css = window.document.getElementById('boss-main-mobile-css'),
//                $mobile_css = $(mobile_css);

            if ( $.cookie( 'switch_mode' ) != 'mobile' ) {
//                    if(($mobile_css.attr('media') != 'all')) {
                if ( ( !translation.only_mobile ) ) {
                    if ( viewport().width < 480 ) {
                        $( 'body' ).removeClass( 'is-desktop' ).addClass( 'is-mobile' );
                    } else {
                        $( 'body' ).removeClass( 'is-mobile' ).addClass( 'is-desktop' );
                    }
                }
            }

            is_mobile = BuddyBoss.is_mobile = $( 'body' ).hasClass( 'is-mobile' );

            return is_mobile;
        }

        /**
         * Checks for a BuddyPress sub-page menu. On smaller screens we turn
         * this into a left/right swiper
         *
         * @return {boolean} True when BuddyPress item navigation exists
         */
        function check_has_item_nav() {
            if ( $item_nav && $item_nav.length ) {
                has_item_nav = true;
            }

            return has_item_nav;
        }

        function render_layout() {
            var
                window_height = $window.height(), // window height - 60px (Header height) - carousel_nav_height (Carousel Navigation space)
                carousel_width = ( $item_nav.find( 'li' ).length * 94 );

            // If on small screens make sure the main page elements are
            // full width vertically
            if ( is_mobile && ( $inner.height() < $window.height() ) ) {
                $( '#page' ).css( 'min-height', $window.height() - ( $( '#mobile-header' ).height() + $( '#colophon' ).height() ) );
            }

            //if ( is_mobile ) {
            //$( '#messages-layout' ).css( 'margin-top', $( '#leftcolumn' ).height() );
            //}

            // Swipe/panel shut area
            if ( is_mobile && $( '#buddyboss-swipe-area' ).length && Panels.state ) {
                $( '#buddyboss-swipe-area' ).css( {
                    left: Panels.state === 'left' ? 240 : 'auto',
                    right: Panels.state === 'right' ? 240 : 'auto',
                    width: $( window ).width() - 240,
                    height: $( window ).outerHeight( true ) + 200
                } );
            }

            // Log out link in left panel
            var $left_logout_link = $( '#wp-admin-bar-logout' ),
                $left_account_panel = $( '#wp-admin-bar-user-actions' ),
                $left_settings_menu = $( '#wp-admin-bar-my-account-settings .ab-submenu' ).first();

            if ( $left_logout_link.length && $left_account_panel.length && $left_settings_menu.length ) {
                // On mobile user's accidentally click the link when it's up
                // top so we move it into the setting menu
                if ( is_mobile ) {
                    $left_logout_link.appendTo( $left_settings_menu );
                }
                // On desktop we move it back to it's original place
                else {
                    $left_logout_link.appendTo( $left_account_panel );
                }
            }

            // Runs once, first time we experience a mobile resolution
            if ( is_mobile && has_item_nav && !mobile_modified ) {
                mobile_modified = true;
                $mobile_nav_wrap = $( '<div id="mobile-item-nav-wrap" class="mobile-item-nav-container mobile-item-nav-scroll-container">' );
                $mobile_item_wrap = $( '<div class="mobile-item-nav-wrapper">' ).appendTo( $mobile_nav_wrap );
                $mobile_item_nav = $( '<div id="mobile-item-nav" class="mobile-item-nav">' ).appendTo( $mobile_item_wrap );
                $mobile_item_nav.append( $item_nav.html() );

                $mobile_item_nav.css( 'width', ( $item_nav.find( 'li' ).length * 94 ) );
                $mobile_nav_wrap.insertBefore( $item_nav ).show();
                $( '#mobile-item-nav-wrap, .mobile-item-nav-scroll-container, .mobile-item-nav-container' ).addClass( 'fixed' );
                $item_nav.css( { display: 'none' } );
            }
            // Resized to non-mobile resolution
            else if ( !is_mobile && has_item_nav && mobile_modified ) {
                $mobile_nav_wrap.css( { display: 'none' } );
                $item_nav.css( { display: 'block' } );
                $document.trigger( 'menu-close.buddyboss' );
            }
            // Resized back to mobile resolution
            else if ( is_mobile && has_item_nav && mobile_modified ) {
                $mobile_nav_wrap.css( {
                    display: 'block',
                    width: carousel_width
                } );

                $mobile_item_nav.css( {
                    width: carousel_width
                } );

                $item_nav.css( { display: 'none' } );
            }

            // Update select drop-downs
            if ( typeof Selects !== 'undefined' ) {
                if ( $.isFunction( Selects.populate_select_label ) ) {
                    Selects.populate_select_label( is_mobile );
                }
            }
        }

        /**
         * Renders the layout, called when the page is loaded and on resize
         *
         * @return {void}
         */
        function do_render()
        {
            check_is_mobile();
            $( window ).resize( check_is_mobile );
            check_has_item_nav();
            render_layout();
            mobile_carousel();
        }
        /*------------------------------------------------------------------------------------------------------
         1.1 - Startup (Binds Events + Conditionals)
         --------------------------------------------------------------------------------------------------------*/

        // Render layout
        do_render();

        // Re-render layout after everything's loaded
        $window.bind( 'load', function () {
            do_render();
        } );

        // Re-render layout on resize
        var throttle;
        $window.resize( function () {
            clearTimeout( throttle );
            throttle = setTimeout( do_render, 150 );
        } );

        /*------------------------------------------------------------------------------------------------------
         2.1 - Mobile/Tablet Carousels
         --------------------------------------------------------------------------------------------------------*/

        function mobile_carousel() {
            if ( is_mobile && has_item_nav ) {
                /* Remove submenu if there is any */
                if ( $( '#mobile-item-nav #nav-bar-filter .hideshow ul' ).length > 0 ) {
                    $( '#mobile-item-nav #nav-bar-filter' ).append( $( '#mobile-item-nav #nav-bar-filter .hideshow ul' ).html() );
                    $( '#mobile-item-nav #nav-bar-filter .hideshow' ).remove();
                }

                if ( !swiper ) {
                    // console.log( 'Setting up mobile nav swiper' );
                    swiper = $( '.mobile-item-nav-scroll-container' ).swiper( {
                        scrollContainer: true,
                        slideElement: 'div',
                        slideClass: 'mobile-item-nav',
                        wrapperClass: 'mobile-item-nav-wrapper'
                    } );
                }
            }
        }

        /*------------------------------------------------------------------------------------------------------
         2.2 - Responsive Dropdowns
         --------------------------------------------------------------------------------------------------------*/
        if ( typeof Selects !== 'undefined' ) {
            if ( $.isFunction( Selects.init_select ) ) {
                Selects.init_select( is_mobile, inputsEnabled );
            }
        }

        if ( $( 'body' ).hasClass( 'messages' ) ) {
            $document.ajaxComplete( function () {
                setTimeout( function () {
                    if ( $.isFunction( Selects.init_select ) ) {
                        Selects.init_select( is_mobile, inputsEnabled );
                    }
                    if ( typeof Selects !== 'undefined' ) {
                        if ( $.isFunction( Selects.populate_select_label ) ) {
                            Selects.populate_select_label( is_mobile );
                        }
                    }
//                    $('.message-check, #select-all-messages').addClass('styled').after('<strong></strong>');

                }, 500 );
            } );
        }

        if ( $( 'body' ).find( '#siteRegisterBox-step-2' ).length !== 0 ) {
            $document.ajaxComplete( function () {
                setTimeout( function () {
                    if ( $.isFunction( Selects.init_select ) ) {
                        Selects.init_select( is_mobile, inputsEnabled );
                    }
                    if ( typeof Selects !== 'undefined' ) {
                        if ( $.isFunction( Selects.populate_select_label ) ) {
                            Selects.populate_select_label( is_mobile );
                        }
                    }

                }, 500 );
            } );
        }

        /* Reset selects on Event booking options changed */

        $( document ).on( 'em_bookings_filtered', function () {
            if ( $.isFunction( Selects.init_select ) ) {
                Selects.init_select( is_mobile, inputsEnabled );
            }
            if ( typeof Selects !== 'undefined' ) {
                if ( $.isFunction( Selects.populate_select_label ) ) {
                    Selects.populate_select_label( is_mobile );
                }
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         3.0 - Content
         --------------------------------------------------------------------------------------------------------*/
        /*------------------------------------------------------------------------------------------------------
         3.1 - Members (Group Admin)
         --------------------------------------------------------------------------------------------------------*/

        // Hide/Reveal action buttons
        $( 'a.show-options' ).click( function ( event ) {
            event.preventDefault;

            parent_li = $( this ).parent( 'li' );
            if ( $( parent_li ).children( 'ul#members-list span.small' ).hasClass( 'inactive' ) ) {
                $( this ).removeClass( 'inactive' ).addClass( 'active' );
                $( parent_li ).children( 'ul#members-list span.small' ).removeClass( 'inactive' ).addClass( 'active' );
            }
            else {
                $( this ).removeClass( 'active' ).addClass( 'inactive' );
                $( parent_li ).children( 'ul#members-list span.small' ).removeClass( 'active' ).addClass( 'inactive' );
            }

        } );


        /*------------------------------------------------------------------------------------------------------
         3.2 - Search Input Field
         --------------------------------------------------------------------------------------------------------*/
        $( '#buddypress div.dir-search form, #buddypress div.message-search form, div.bbp-search-form form, form#bbp-search-form' ).append( '<a href="#" id="clear-input"> </a>' );
        $( 'a#clear-input' ).click( function () {
            jQuery( "#buddypress div.dir-search form input[type=text], #buddypress div.message-search form input[type=text], div.bbp-search-form form input[type=text], form#bbp-search-form input[type=text]" ).val( "" );
        } );


        /*------------------------------------------------------------------------------------------------------
         3.3 - Hide Profile and Group Buttons Area, when there are no buttons (ex: Add Friend, Join Group etc...)
         --------------------------------------------------------------------------------------------------------*/

        if ( !$( '#buddypress #item-header #item-buttons .generic-button' ).length ) {
            $( '#buddypress #item-header #item-buttons' ).hide();
        }

        /*------------------------------------------------------------------------------------------------------
         3.4 - Move the Messages Checkbox, below the Avatar
         --------------------------------------------------------------------------------------------------------*/

        $( '#message-threads.messages-notices .thread-options .checkbox' ).each( function () {
            move_to_spot = $( this ).parent().siblings( '.thread-avatar' );
            $( this ).appendTo( move_to_spot );
        } );

        /*------------------------------------------------------------------------------------------------------
         3.5 - Select unread and read messages in inbox
         --------------------------------------------------------------------------------------------------------*/

        // Overwrite/Re-do some of the functionality in buddypress.js,
        // to accommodate for UL instead of tables in buddyboss theme
        jq( "#message-type-select" ).change(
            function () {
                var selection = jq( "#message-type-select" ).val();
                var checkboxes = jq( "ul input[type='checkbox']" );
                checkboxes.each( function ( i ) {
                    checkboxes[i].checked = "";
                } );

                switch ( selection ) {
                    case 'unread':
                        var checkboxes = jq( "ul.unread input[type='checkbox']" );
                        break;
                    case 'read':
                        var checkboxes = jq( "ul.read input[type='checkbox']" );
                        break;
                }
                if ( selection != '' ) {
                    checkboxes.each( function ( i ) {
                        checkboxes[i].checked = "checked";
                    } );
                } else {
                    checkboxes.each( function ( i ) {
                        checkboxes[i].checked = "";
                    } );
                }
            }
        );

        /* star ajax according to boss theme as boss not using old tables */
        if ( typeof starAction !== 'undefined' ) {
            jq( '#message-threads' ).on( 'click', '.thread-star a', starAction );
        }

        /* Bulk delete messages */
        jq( "#delete_inbox_messages, #delete_sentbox_messages" ).on( 'click', function () {
            checkboxes_tosend = '';
            checkboxes = jq( "#message-threads ul input[type='checkbox']" );

            jq( '#message' ).remove();
            jq( this ).addClass( 'loading' );

            jq( checkboxes ).each( function ( i ) {
                if ( jq( this ).is( ':checked' ) )
                    checkboxes_tosend += jq( this ).attr( 'value' ) + ',';
            } );

            if ( '' == checkboxes_tosend ) {
                jq( this ).removeClass( 'loading' );
                return false;
            }

            jq.post( ajaxurl, {
                action: 'messages_delete',
                'thread_ids': checkboxes_tosend
            }, function ( response ) {
                if ( response[0] + response[1] == "-1" ) {
                    jq( '#message-threads' ).prepend( response.substr( 2, response.length ) );
                } else {
                    jq( '#message-threads' ).before( '<div id="message" class="updated"><p>' + response + '</p></div>' );

                    jq( checkboxes ).each( function ( i ) {
                        if ( jq( this ).is( ':checked' ) )
                            jq( this ).parent().parent().fadeOut( 150 );
                    } );
                }

                jq( '#message' ).hide().slideDown( 150 );
                jq( "#delete_inbox_messages, #delete_sentbox_messages" ).removeClass( 'loading' );
            } );
            return false;
        } );

        /*------------------------------------------------------------------------------------------------------
         3.6 - Make Video Embeds Responsive - Fitvids.js
         --------------------------------------------------------------------------------------------------------*/
        if ( typeof $.fn.fitVids !== 'undefined' && $.isFunction( $.fn.fitVids ) ) {

            function videosWidth() {

                $( '#content' ).fitVids();

                if ( $( '.activity-inner' ).length > 0 ) {
                    $( '.activity-inner' ).find( '.fluid-width-video-wrapper' ).each( function () {
                        $( this ).parent().css( {
                            'max-width': '530px'
                        } );
                    } );
                }
            }

            videosWidth();

            // This ensures that after and Ajax call we check again for
            // videos to resize.
            $( document ).ajaxSuccess( videosWidth );
        }

        /*------------------------------------------------------------------------------------------------------
         Fix BuddyPanel
         --------------------------------------------------------------------------------------------------------*/

        var $primary = $( '#primary' );

        function fixBuddyPanel() {

            if ( !is_mobile && $primary.length > 0 ) {

                height = viewport().height;

                $( '#scroll-area' ).css( {
                    'position': 'relative'
                } );

                if ( $( '#scroll-area' ).outerHeight() + $( '#masthead' ).outerHeight() < height ) {
                    $( '#scroll-area' ).css( {
                        'position': 'fixed'
                    } );
                }

            } else {
                $( '#scroll-area' ).css( {
                    'position': 'relative'
                } );
            }
        }

        imagesLoaded( 'body', function ( instance ) {
            fixBuddyPanel();
        } );


        $window.resize( function () {
            fixBuddyPanel();
        } );

        // Ajax complete Sidebars Fix
        $( document ).ajaxComplete( function () {
            setTimeout( function () {
                fixBuddyPanel();
            }, 500 );
        } );

        setTimeout( function () {
            $( ".right-col" ).toggleClass( "open" );
            fixBuddyPanel();
        }, 500 );

        /*--------------------------------------------------------------------------------------------------------
         3.7 - Comment placeholder
         --------------------------------------------------------------------------------------------------------*/
        $( '#comment' ).attr( 'placeholder', translation.comment_placeholder );

        /*------------------------------------------------------------------------------------------------------
         3.8 - Initialise UI scripts
         --------------------------------------------------------------------------------------------------------*/

        // Accordion
        if ( $( ".accordion" ).length ) {
            $( ".accordion" ).each( function () {
                var open = $( this ).data( 'open' );
                if ( open == 'false' ) {
                    open = false;
                }
                $( this ).accordion( {
                    active: open,
                    heightStyle: "content",
                    collapsible: true
                } );
            } );
        }

        // Tabs
        if ( $( ".tabs" ).length ) {
            $( ".tabs" ).tabs();
        }

        // Progress Bar
        if ( $( ".progressbar" ).length ) {
            $( ".progressbar" ).each( function () {
                $( this ).progressbar( {
                    value: $( this ).data( 'progress' )
                } );
            } );
        }

        // Tooltip
        if ( $( ".tooltip" ).length ) {
            $( ".tooltip" ).tooltip( {
                position: {
                    my: "center bottom-10",
                    at: "center top",
                    using: function ( position, feedback ) {
                        $( this ).css( position );
                        $( "<div>" )
                            .addClass( "arrow" )
                            .addClass( feedback.vertical )
                            .addClass( feedback.horizontal )
                            .appendTo( this );
                    }
                }
            } );
        }

        // Menu
        if ( $( ".menu-dropdown > ul" ).length ) {
            $( '.menu-dropdown > ul' ).superfish();
        }

        /*--------------------------------------------------------------------------------------------------------
         3.9 - Some global functions
         --------------------------------------------------------------------------------------------------------*/

        //click events
        var ua = navigator.userAgent,
            clickevent = ( ua.match( /iPad/i ) || ua.match( /iPhone/i ) || ua.match( /Android/i ) ) ? "touch" : "click";

        // get viewport size
        function viewport() {
            var e = window, a = 'inner';
            if ( !( 'innerWidth' in window ) ) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[ a + 'Width' ], height: e[ a + 'Height' ] };
        }

        var disable = 0;

        // Remove inline styling
        $.fn.removeStyle = function ( style )
        {
            var search = new RegExp( style + '[^;]+;?', 'g' );

            return this.each( function ()
            {
                $( this ).attr( 'style', function ( i, style )
                {
                    if ( style ) {
                        return style.replace( search, '' );
                    }
                } );
            } );
        };

        /*--------------------------------------------------------------------------------------------------------
         3.10 - Fit Site Title
         --------------------------------------------------------------------------------------------------------*/

        // Fit Text
        $.fn.fitText = function ( kompressor, options ) {

            // Setup options
            var compressor = kompressor || 1,
                settings = $.extend( {
                    'minFontSize': Number.NEGATIVE_INFINITY,
                    'maxFontSize': Number.POSITIVE_INFINITY
                }, options );

            return this.each( function () {

                // Store the object
                var $this = $( this );

                // Resizer() resizes items based on the object width divided by the compressor * 10
                var resizer = function () {
                    $this.css( 'font-size', Math.max( Math.min( $this.width() / ( compressor * 10 ), parseFloat( settings.maxFontSize ) ), parseFloat( settings.minFontSize ) ) );
                };

                // Call once to set.
                resizer();

                // Call on resize. Opera debounces their resize by default.
                $( window ).on( 'resize.fittext orientationchange.fittext', resizer );

            } );

        };

        $( ".mobile-site-title" ).fitText( 1, { minFontSize: '18px', maxFontSize: '25px' } );

        if ( is_mobile ) {
            $( ".bb-slider-container .title" ).fitText( 1, { minFontSize: '18px', maxFontSize: '70px' } );
        }

        /**
         * Core for buddyboss left menu
         * @return (void)
         */

        /* add submenu title */
        if ( !$( "body" ).hasClass( panel_open_class ) ) {
            $( '#left-panel #nav-menu > ul > li' ).each( function () {
                var $element = $( this ).children( 'a:not(.fa)' ).clone();
                if ( $( this ).children( '.sub-menu-wrap' ).length ) {
                    $( this ).children( '.sub-menu-wrap' ).prepend( $element );
                } else {
                    var $submenu = $( '<div/>', {
                        'class': 'sub-menu-wrap'
                    } );

                    $element.appendTo( $submenu );
                    $( this ).append( $submenu );
                }
            } );
        }

        function func_left_menu() {
            $( "#left-menu-toggle" ).bind( 'click', function ( event ) {
                event.preventDefault();
                $( "body" ).toggleClass( panel_open_class );

                if ( $( "body" ).hasClass( panel_open_class ) ) {

                    /* remove submenu title */
                    $( '#left-panel #nav-menu > ul > li' ).each( function () {
                        if ( $( this ).children( '.sub-menu-wrap' ).find( 'ul' ).length ) {
                            $( this ).children( '.sub-menu-wrap' ).children( 'a' ).remove();
                        } else {
                            $( this ).children( '.sub-menu-wrap' ).remove();
                        }
                    } );

                    $.cookie( 'left-panel-status', 'open', { path: '/' } );

                } else {

                    /* add submenu title */
                    $( '#left-panel #nav-menu > ul > li' ).each( function () {
                        var $element = $( this ).children( 'a:not(.fa)' ).clone();
                        if ( $( this ).children( '.sub-menu-wrap' ).length ) {
                            $( this ).children( '.sub-menu-wrap' ).prepend( $element );
                        } else {
                            var $submenu = $( '<div/>', {
                                'class': 'sub-menu-wrap'
                            } );

                            $element.appendTo( $submenu );
                            $( this ).append( $submenu );
                        }
                    } );

                    $.cookie( 'left-panel-status', 'close', { path: '/' } );
                }

                setTimeout( function () {
                    if ( rtl ) {
                        $( ".left-col" ).toggleClass( "open" );
                    } else {
                        $( ".right-col" ).toggleClass( "open" );
                    }
                    $window.trigger( 'resize' );

                }, 500 );

                // arrows for tablet
                menuToggle();

            } );
        }


        func_left_menu();

        // Ajax complete Sidebars Fix
        $( document ).ajaxComplete( function () {
            setTimeout( function () {
                initSpinner();
            }, 500 );

            setTimeout( function () {
                initSpinner();
            }, 1500 );
        } );


        //BuddyBoss Inbox Additional Label Functionality Code

        jQuery( document ).on( 'click', '.bb-add-label-button', function ( e ) {
            e.preventDefault();

            _this = jQuery( this );

            _this.find( ".fa-spin" ).fadeOut();

            var label_name = jQuery( '.bb-label-name' ).val();
            var data = {
                action: 'bbm_label_ajax',
                task: 'add_new_label',
                thread_id: 0,
                label_name: label_name
            };

            jQuery.post( ajaxurl, data, function ( response ) {

                _this.find( ".fa-spin" ).fadeIn();

                var response = jQuery.parseJSON( response );

                if ( response.label_id != '' ) {

                    jQuery( ".bb-label-container" ).load( window.location.href + " .bb-label-container", function () {
                        jQuery( ".bb-label-container > .bb-label-container" ).attr( "class", "" );
                    } );

                }

                if ( typeof response.message == 'undefined' ) {
                    return false;
                }

                if ( response.message != '' ) {
                    alert( response.message );
                }

            } );
        } );

        jQuery( document ).on( "keydown", ".bb-label-name", function ( e ) {
            if ( e.keyCode == 13 ) {
                jQuery( ".bb-add-label-button" ).click();
            }
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.12 - Mobile & Tablet menu
         --------------------------------------------------------------------------------------------------------*/

        function attachArrows() {
            if ( $( '.menu-panel .open-submenu' ).length == 0 ) {
                $( '.menu-panel .bp_components ul li ul li.menupop' ).prepend( '<a class="open-submenu fa fa-angle-left" href="#"></a>' );

                $( '.menu-panel #nav-menu > ul > li' ).each( function () {
                    if ( $( this ).children( '.sub-menu-wrap' ).length ) {
                        $( this ).prepend( '<a class="open-submenu fa fa-angle-left" href="#"></a>' );
                    }
                } );

                $( window ).on( 'load', function () {
                    $( '.menu-panel #header-menu .sub-menu-wrap' ).hide();
                    $( '.menu-panel #header-menu ul li' ).each( function () {
                        if ( $( this ).children( '.sub-menu-wrap' ).length ) {
                            $( this ).prepend( '<a class="open-submenu fa fa-angle-left" href="#"></a>' );
                        }
                    } );
                } );
            }

            $( '.menu-panel .open-submenu' ).unbind();
//            $( 'body' ).unbind();
            $( 'body' ).off( 'click', '.menu-panel .open-submenu' );
            $( 'body' ).on( 'click', '.menu-panel .open-submenu', function ( event ) {
                event.preventDefault();

                $( this ).next().next().slideToggle( "fast", function () {
                } );

                $( this ).toggleClass( 'fa-angle-down' );
                $( this ).closest( 'li' ).toggleClass( 'dropdown' );
            } );
        }

        function removeArrows() {
            $( '.menu-panel .open-submenu' ).remove();
            $( '.menu-panel .ab-sub-wrapper, .sub-menu-wrap' ).removeAttr( "style" );
        }

        function menuToggle() {
            if ( is_mobile || ( $( 'body' ).hasClass( 'tablet' ) && $( 'body' ).hasClass( panel_open_class ) && $( 'body' ).hasClass( 'tablet' ) ) ) {
                attachArrows();
            } else {
                removeArrows();
            }
        }

        menuToggle();
        $( window ).resize( menuToggle );

        // Account Menu PopUp On Touch For Tablets
        $( '.tablet .header-account-login' ).on( "click touch", function ( e ) {
            $( this ).find( '.pop' ).toggleClass( 'hover' );
        } );

        if ( $( '#wp-admin-bar-shortcode-secondary' ).length ) {
            $( '.tablet #wp-admin-bar-shortcode-secondary .menupop' ).on( "click touch", function ( e ) {
                $( this ).find( '.ab-sub-wrapper' ).toggleClass( 'hover' );
            } );
        } else {
            $( '.tablet .header-notifications' ).on( "click touch", function ( e ) {
                $( this ).find( '.pop' ).toggleClass( 'hover' );
            } );
        }

        /*--------------------------------------------------------------------------------------------------------
         3.13 - Add spinner
         --------------------------------------------------------------------------------------------------------*/
        function initSpinner() {
            $( '#main-button, .generic-button:not(.pending):not(.group-subscription-options)' ).on( 'click', function () {
                $link = $( this ).find( 'a' );
                if ( !$link.find( 'i' ).length && !$link.hasClass( 'pending' ) ) {
                    $link.append( '<i class="fa fa-spinner fa-spin"></i>' );
                }
            } );
        }

        initSpinner();

        // to activity submit
        $( '#whats-new-submit' ).append( '<span class="spinner"></span>' );

        /*--------------------------------------------------------------------------------------------------------
         3.14 - To Top Button
         --------------------------------------------------------------------------------------------------------*/
        //Scroll Effect
        $( '.scroll' ).bind( 'click', function ( event ) {

            event.preventDefault();

            var $anchor = $( this );

            $( 'html, body' ).stop().animate( {
                scrollTop: $( $anchor.attr( 'href' ) ).offset().top + "px"
            }, 1000, 'easeInOutExpo' );

        } );

        /*--------------------------------------------------------------------------------------------------------
         3.14 - Custom File Input
         --------------------------------------------------------------------------------------------------------*/
        $( '#group-create-body input[type=file], #avatar-upload input[type=file], #group-settings-form input[type=file]' ).change( function ( e ) {
            var str = $( this ).val(),
                parts = str.split( '\\' ),
                result = parts[parts.length - 1];

            $( "#file-path" ).text( result );
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.15 - 404 Page Go Back Button
         --------------------------------------------------------------------------------------------------------*/
        $( '.back-btn' ).click( function ( event ) {
            event.preventDefault();
            window.history.back();
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.16 - Better Radios and Checkboxes Styling
         --------------------------------------------------------------------------------------------------------*/
        function initCheckboxes() {
            if ( !inputsEnabled ) {
                //only few buddypress and bbpress related fields
                $( '.events input[type="checkbox"], #buddypress table.notifications input, #send_message_form input[type="checkbox"], #profile-edit-form input[type="checkbox"],  #profile-edit-form input[type="radio"], #message-threads input, #settings-form input[type="radio"], #create-group-form input[type="radio"], #create-group-form input[type="checkbox"], #invite-list input[type="checkbox"], #group-settings-form input[type="radio"], #group-settings-form input[type="checkbox"], #new-post input[type="checkbox"], .bbp-form input[type="checkbox"], .bbp-form .input[type="radio"], .register-section .input[type="radio"], .register-section input[type="checkbox"], .message-check, #select-all-messages' ).each( function () {
                    var $this = $( this );
                    $this.addClass( 'styled' );
                    if ( $this.next( "label" ).length == 0 && $this.next( "strong" ).length == 0 ) {
                        $this.after( '<strong></strong>' );
                    }
                } );
            } else {
                //all fields
                $( 'input[type="checkbox"], input[type="radio"]' ).each( function () {
                    var $this = $( this );
                    if ( $this.val() == 'gf_other_choice' ) {
                        $this.addClass( 'styled' );
                        $this.next().wrap( '<strong class="other-option"></strong>' );
                    } else {
                        if ( !$this.parents( '#bp-group-documents-form' ).length ) {
                            $this.addClass( 'styled' );
                            if ( $this.next( "label" ).length == 0 && $this.next( "strong" ).length == 0 ) {
                                $this.after( '<strong></strong>' );
                            }
                        }
                    }
                } );
            }
        }

        initCheckboxes();

        /*--------------------------------------------------------------------------------------------------------
         3.17 - Mobile Panels
         --------------------------------------------------------------------------------------------------------*/
        $( document ).on( 'click', function ( event ) {

            if ( event.originalEvent && $( event.target )[0].id != 'profile-nav' && $( event.target ).closest( '#left-panel' ).length == 0 && is_mobile ) {
                closeRightMenu();
            }

            if ( event.originalEvent && $( event.target )[0].id != 'custom-nav' && $( event.target ).closest( '#mobile-menu' ).length == 0 && is_mobile ) {
                closeLeftMenu();
            }

        } );


        //menu button trigger
        $( document ).on( 'click', '#profile-nav', function ( event ) {
            event.preventDefault();
            if ( is_mobile ) {
                event.preventDefault();
                if ( $( '#right-panel' ).hasClass( 'side-menu-right' ) ) {
                    closeRightMenu();
                } else {
                    openRightMenu();
                }
            }
        } );

        $( document ).on( 'click', '#custom-nav', function ( event ) {
            event.preventDefault();
            if ( is_mobile ) {
                event.preventDefault();
                if ( $( '#right-panel' ).hasClass( 'side-menu-left' ) ) {
                    closeLeftMenu();
                } else {
                    openLeftMenu();
                }
            }
        } );

        // open
        function openRightMenu() {
            $( '#left-panel' ).css( 'opacity', '1' );
            $( '#left-panel' ).css( 'display', 'block' );
            $( '#profile-nav' ).addClass( 'close' );
            $( '#right-panel' ).addClass( 'side-menu-right' );
            $( '#mobile-header' ).addClass( 'side-menu-right' );
            $( '#left-panel-inner' ).addClass( 'animated BeanSidebarIn' ).removeClass( 'BeanSidebarOut' );
            $( '#masthead' ).css( 'margin-top', '0' );
            setTimeout( function () {
                $( '#left-panel' ).css( 'z-index', '0' );
            }, 300 );
        }

        function openLeftMenu() {
            $( '#mobile-menu' ).css( 'opacity', '1' );
            $( '#mobile-menu' ).css( 'display', 'block' );
            $( '#custom-nav' ).addClass( 'close' );
            $( '#right-panel' ).addClass( 'side-menu-left' );
            $( '#mobile-header' ).addClass( 'side-menu-left' );
            $( '#mobile-menu-inner' ).addClass( 'animated BeanSidebarIn' ).removeClass( 'BeanSidebarOut' );
            $( '#masthead' ).css( 'margin-top', '0' );
            setTimeout( function () {
                $( '#mobile-menu' ).css( 'z-index', '0' );
            }, 300 );
        }

        // close
        function closeRightMenu() {
            $( '#left-panel' ).css( 'z-index', '-1' );
            $( '#profile-nav' ).removeClass( 'close' );
            $( '#right-panel' ).removeClass( 'side-menu-right' );
            $( '#mobile-header' ).removeClass( 'side-menu-right' );
            $( '#left-panel-inner' ).removeClass( 'BeanSidebarIn' ).addClass( 'BeanSidebarOut' );
            $( '#left-panel-inner' ).addClass( 'animated ' );
            setTimeout( function () {
                $( '#left-panel' ).css( 'z-index', '-1' );
                $( '#left-panel' ).css( 'opacity', '0' );
            }, 300 );
        }

        function closeLeftMenu() {
            $( '#mobile-menu' ).css( 'z-index', '-1' );
            $( '#custom-nav' ).removeClass( 'close' );
            $( '#right-panel' ).removeClass( 'side-menu-left' );
            $( '#mobile-header' ).removeClass( 'side-menu-left' );
            $( '#mobile-menu-inner' ).removeClass( 'BeanSidebarIn' ).addClass( 'BeanSidebarOut' );
            $( '#mobile-menu-inner' ).addClass( 'animated ' );
            setTimeout( function () {
                $( '#mobile-menu' ).css( 'z-index', '-1' );
                $( '#mobile-menu' ).css( 'opacity', '0' );
            }, 300 );
        }

        /*--------------------------------------------------------------------------------------------------------
         3.19 - Advanced Search Scripts
         --------------------------------------------------------------------------------------------------------*/

        function searchWidthMobile() {
            if ( is_mobile ) {
                var $mobile_search = $( ".mobile-header-inner .searchform" );
                if ( $mobile_search.length ) {
                    $mobile_search.focusin( function () {
                        $( this ).css( {
                            'z-index': '2'
                        } ).stop().animate( {
                            'padding-left': '5px',
                            'padding-right': '5px'
                        }, 400 );
                    } );

                    $mobile_search.focusout( function () {
                        $( this ).stop().animate( {
                            'padding-left': '77px',
                            'padding-right': '77px'
                        }, 400 );
                        setTimeout( function () {
                            $mobile_search.css( {
                                'z-index': '0'
                            } );
                        }, 400 );
                    } );
                }
            }
        }

        searchWidthMobile();
//        $(window).resize(searchWidthMobile);

        if ( $( '.search-wrap input[type="text"]' ).hasClass( 'ui-autocomplete-input' ) ) {

            function searchWidth() {
                if ( !is_mobile ) {
                    $( "#header-search .search-wrap" ).focusin( function () {
                        $( this ).closest( '.search-wrap' ).stop().animate( {
                            width: '360px'
                        }, 400 );
                    } );

                    $( "#header-search .search-wrap" ).focusout( function () {
                        $( this ).closest( '.search-wrap' ).stop().animate( {
                            width: '100px'
                        }, 400 );
                    } );

                } else {
                    $( "#header-search .search-wrap" ).unbind( 'focus' );
                    $( "#header-search .search-wrap" ).unbind( 'focusout' );
                }
            }

            searchWidth();
//            $(window).resize(searchWidth);

            function dropdownPosition() {
                var offset = $( '.ui-autocomplete-input' ).offset().top + 48;
                $( '.bb-global-search-ac' ).css( {
                    'top': offset
                } );
            }

            $window.scroll( function () {
                dropdownPosition();
            } );

        }


        if ( !( '2' == $body.data( 'header' ) ) ) {

            $( '.search-toggle a' ).click( function ( e ) {
                e.preventDefault();

                var $this = $( this ),
                    $search_wrap = $( '#searchform' );

                if ( $this.hasClass( 'closed' ) ) {
                    $this.removeClass( 'closed' );
                    $this.addClass( 'open' );
                    setTimeout( function () {
                        $search_wrap.find( '#s' ).focus();
                    }, 301 );
                } else {
                    $this.removeClass( 'open' );
                    $this.addClass( 'closed' );
                }

                $search_wrap.fadeToggle( 300, 'linear' );

            } );

            $( document ).click( function ( e )
            {
                var container = $( "#searchform" ),
                    toggle = $( '.search-toggle' );

                if ( !container.is( e.target ) && !toggle.is( e.target ) && toggle.has( e.target ).length === 0
                    && container.has( e.target ).length === 0 && $( 'body' ).hasClass( 'boxed' ) )
                {
                    toggle.find( 'a' ).removeClass( 'open' ).addClass( 'closed' );
                    container.fadeOut();
                }
            } );

        }

        /*--------------------------------------------------------------------------------------------------------
         3.20 - Buttons Menu
         --------------------------------------------------------------------------------------------------------*/
        function attachClick() {
            $( '.more-items-btn' ).click( function () {
                $( this ).parent( '.single-member-more-actions' ).find( '.pop' ).slideToggle( 100 );
            } );
        }

        if ( is_mobile ) {
            attachClick();
        }

        /*--------------------------------------------------------------------------------------------------------
         3.21 - Responsive Menus (...)
         --------------------------------------------------------------------------------------------------------*/
        if ( !is_mobile ) {
            $( "#item-nav" ).find( "#nav-bar-filter" ).jRMenuMore( 60 );


            //Initialize jRMenuMore menu when it actually start falling outside of screen width
            var members_menu_items_width = 0;
            $( '#members-directory-form div.item-list-tabs ul:first-child li' ).each( function () {
                members_menu_items_width += $( this ).outerWidth();
            } );

            var members_ul_menu_width = $( '#members-directory-form div.item-list-tabs ul:first-child' ).width();

            if ( members_menu_items_width > members_ul_menu_width ) {
                $( '#members-directory-form div.item-list-tabs ul:first-child' ).jRMenuMore( 60 );
            }

            if ( '2' == $body.data( 'header' ) ) {
                $( "#header-menu > ul" ).jRMenuMore( 120 );
            } else {
                $( "#header-menu > ul" ).jRMenuMore( 70 );
            }
        }

        /*--------------------------------------------------------------------------------------------------------
         3.22 - BuddyPanel bubbles
         --------------------------------------------------------------------------------------------------------*/

        function setCounters() {
            $( '#wp-admin-bar-my-account-buddypress' ).find( 'li' ).each( function () {
                var $this = $( this ),
                    $count = $this.children( 'a' ).children( '.count' ),
                    id,
                    $target;

                if ( $count.length != 0 ) {
                    id = $this.attr( 'id' );
                    $target = $( '.bp-menu.bp-' + id.replace( /wp-admin-bar-my-account-/, '' ) + '-nav' );
                    if ( $target.find( '.count' ).length == 0 ) {
                        $target.find( 'a' ).append( '<span class="count">' + $count.html() + '</span>' );
                    }
                }
            } );
        }

        setCounters();

        /*--------------------------------------------------------------------------------------------------------
         3.23 - Titlebar position on mobile
         --------------------------------------------------------------------------------------------------------*/

        function attachMobileMenu() {
            if ( is_mobile ) {
                var $container = $( '#mobile-menu-inner' );
                if ( !$container.find( '#header-menu' ).length ) {
                    var $element = $( '#header-menu' ).clone(),
                        position = $container.data( 'titlebar' ),
                        $existing = $container.find( '#nav-menu' );

                    $element.find( '.hideshow ul li' ).each( function () {
                        $element.children( 'ul' ).append( $( this ) );
                    } );
                    $element.find( '.hideshow' ).remove();

                    if ( $existing.length ) {
                        if ( position == 'top' ) {
                            $existing.before( $element );
                        } else if ( position == 'bottom' ) {
                            $existing.after( $element );
                        }
                    } else {
                        $container.append( $element );
                    }
                }
            }
        }

        attachMobileMenu();

        $window.resize( attachMobileMenu );

        if ( is_mobile ) {
            $( '#switch_mode' ).val( 'desktop' );
            $( '#switch_submit' ).val( translation.view_desktop );
        } else {
            $( '#switch_mode' ).val( 'mobile' );
            $( '#switch_submit' ).val( translation.view_mobile );
        }

        $( '#switch_submit' ).click( function () {
            $.cookie( 'switch_mode', $( '#switch_mode' ).val(), { path: '/' } );
        } );

        /*--------------------------------------------------------------------------------------------------------
         3.24 - Infinite Scroll
         --------------------------------------------------------------------------------------------------------*/
        if ( $( '#masthead' ).data( 'infinite' ) == 'on' ) {
            var is_activity_loading = false;//We'll use this variable to make sure we don't send the request again and again.

            jq( document ).on( 'scroll', function () {
                //Find the visible "load more" button.
                //since BP does not remove the "load more" button, we need to find the last one that is visible.
                var load_more_btn = jq( ".load-more:visible" );
                //If there is no visible "load more" button, we've reached the last page of the activity stream.
                if ( !load_more_btn.get( 0 ) )
                    return;

                //Find the offset of the button.
                var pos = load_more_btn.offset();

                //If the window height+scrollTop is greater than the top offset of the "load more" button, we have scrolled to the button's position. Let us load more activity.
                //            console.log(jq(window).scrollTop() + '  '+ jq(window).height() + ' '+ pos.top);

                if ( jq( window ).scrollTop() + jq( window ).height() > pos.top ) {

                    load_more_activity();
                }

            } );

            /**
             * This routine loads more activity.
             * We call it whenever we reach the bottom of the activity listing.
             *
             */
            function load_more_activity() {

                //Check if activity is loading, which means another request is already doing this.
                //If yes, just return and let the other request handle it.
                if ( is_activity_loading )
                    return false;

                //So, it is a new request, let us set the var to true.
                is_activity_loading = true;

                //Add loading class to "load more" button.
                //Theme authors may need to change the selector if their theme uses a different id for the content container.
                //This is designed to work with the structure of bp-default/derivative themes.
                //Change #content to whatever you have named the content container in your theme.
                jq( "#content li.load-more" ).addClass( 'loading' );


                if ( null == jq.cookie( 'bp-activity-oldestpage' ) )
                    jq.cookie( 'bp-activity-oldestpage', 1, {
                        path: '/'
                    } );

                var oldest_page = ( jq.cookie( 'bp-activity-oldestpage' ) * 1 ) + 1;

                //Send the ajax request.
                jq.post( ajaxurl, {
                    action: 'activity_get_older_updates',
                    'cookie': encodeURIComponent( document.cookie ),
                    'page': oldest_page
                },
                function ( response )
                {
                    jq( ".load-more" ).hide();//Hide any "load more" button.
                    jq( "#content li.load-more" ).removeClass( 'loading' );//Theme authors, you may need to change #content to the id of your container here, too.

                    //Update cookie...
                    jq.cookie( 'bp-activity-oldestpage', oldest_page, {
                        path: '/'
                    } );

                    //and append the response.
                    jq( "#content ul.activity-list" ).append( response.contents );

                    //Since the request is complete, let us reset is_activity_loading to false, so we'll be ready to run the routine again.

                    is_activity_loading = false;
                }, 'json' );

                return false;

            }
        }


        /*------------------------------------------------------------------------------------------------------
         3.25 BP Profile Search
         --------------------------------------------------------------------------------------------------------*/

        $( '.page' ).find( '.standard-form' ).each( function () {
            var id = $( this ).attr( 'id' );
            if ( id && id.indexOf( 'bps_shortcode' ) >= 0 ) {
                $( '#' + id ).addClass( 'bps_form' );
            }
        } );

        /*------------------------------------------------------------------------------------------------------
         3.26 Add Photo Button
         --------------------------------------------------------------------------------------------------------*/

        function movePhotoButton() {
            if ( is_mobile ) {
                if ( $( '#aw-whats-new-submit' ).prev( '#buddyboss-media-add-photo' ).length == 0 ) {
                    $( '#buddyboss-media-add-photo' ).insertBefore( '#aw-whats-new-submit' );
                }
            } else {
                if ( $( '#whats-new-additional' ).find( '#buddyboss-media-add-photo' ).length == 0 ) {
                    $( '#whats-new-additional' ).append( $( '#buddyboss-media-add-photo' ) );
                }
            }
        }

        movePhotoButton();
        $window.resize( movePhotoButton );

        $( '#buddyboss-media-add-photo-button' ).text( '' );

        /*------------------------------------------------------------------------------------------------------
         3.27 Activity dropdown
         --------------------------------------------------------------------------------------------------------*/
        var $span = $( '.item-list-tabs.activity-type-tabs .selected-tab' ),
            $ul = $( '.item-list-tabs.activity-type-tabs > ul' ),
            $li = $( '.item-list-tabs.activity-type-tabs > ul > li' );

        $span.click( function ( e ) {
            e.stopPropagation();
            $ul.slideToggle();
        } );

        function cloneText() {
            $li.each( function () {
                if ( $ul.find( '.selected' ).length == 1 ) {
                    if ( $( this ).hasClass( 'selected' ) ) {
                        $span.text( $( this ).text() );
                    }
                } else {
                    $span.text( $( '#activity-all' ).text() );
                }
            } );
        }

        $( document ).ajaxComplete( function () {
            cloneText();
        } );

        cloneText();

        $li.click( function () {
            $span.text( $( this ).text() );
        } );

        /*------------------------------------------------------------------------------------------------------
         3.28 - Remove 'Cancel Friendship'
         --------------------------------------------------------------------------------------------------------*/
        $( '.dir-list div.is_friend' ).remove();

        /*------------------------------------------------------------------------------------------------------
         3.29 - Mobile header
         --------------------------------------------------------------------------------------------------------*/
        var mobileHeader = $( '#mobile-header' );

        if ( mobileHeader.hasClass( 'with-adminbar' ) ) {
            $( window ).scroll( function () {
                $fromTop = $( 'body' ).scrollTop();
                if ( $fromTop > 46 ) {
                    // bc < 600 gives absolute on adminbar
                    if ( viewport().width < 600 ) {
                        mobileHeader.css( {
                            position: 'fixed',
                            top: 0
                        } );
                    } else {
                        mobileHeader.css( {
                            position: 'fixed',
                            top: 46
                        } );
                    }
                } else {
                    mobileHeader.css( {
                        position: 'static',
                        top: 0
                    } );
                }
            } );
        }

        /*------------------------------------------------------------------------------------------------------
         Equal Pricing tables - Membership plugin
         --------------------------------------------------------------------------------------------------------*/
        /*!
         * Simple jQuery Equal Heights
         *
         * Copyright (c) 2013 Matt Banks
         * Dual licensed under the MIT and GPL licenses.
         * Uses the same license as jQuery, see:
         * http://docs.jquery.com/License
         *
         * @version 1.5.1
         */
        !function ( a ) {
            a.fn.equalHeights = function () {
                var b = 0, c = a( this );
                return c.each( function () {
                    var c = a( this ).outerHeight();
                    c > b && ( b = c )
                } ), c.css( "height", b - 34 )
            }, a( "[data-equal]" ).each( function () {
                var b = a( this ), c = b.data( "equal" );
                b.find( c ).equalHeights()
            } )
        }( jQuery );

        if ( $( '#pmpro_levels_pricing_tables' ) ) {
            function equalProjects() {
                $( '.pricing-content' ).css( 'height', 'auto' );
                $( '.pricing-content' ).equalHeights();
            }

            equalProjects();

            /* throttle */
            $( window ).resize( function () {
                clearTimeout( $.data( this, 'resizeTimer' ) );
                $.data( this, 'resizeTimer', setTimeout( function () {
                    equalProjects();
                }, 50 ) );
            } );

            $( '#left-menu-toggle' ).click( function () {
                setTimeout( function () {
                    equalProjects();
                }, 550 );
            } );

            $( window ).trigger( 'resize' );
        }

        /*------------------------------------------------------------------------------------------------------
         Header height
         --------------------------------------------------------------------------------------------------------*/
        if ( $( 'body' ).hasClass( 'boxed' ) && !is_mobile ) {
            function headerHeight() {
                var height = $( '#masthead' ).outerHeight();
                $( '#right-panel' ).css( {
                    'margin-top': height
                } );
            }

            headerHeight();

            $window.resize( function () {
                headerHeight();
            } );
        }

        /*------------------------------------------------------------------------------------------------------
         Double Tap for tablets navigation (boxed layout)
         --------------------------------------------------------------------------------------------------------*/
        $.fn.doubleTapToGo = function ( params )
        {
            if ( !( 'ontouchstart' in window ) &&
                !navigator.msMaxTouchPoints &&
                !navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) )
                return false;

            this.each( function ()
            {
                var curItem = false;

                $( this ).on( 'click', function ( e )
                {
                    var item = $( this );
                    if ( item[ 0 ] != curItem[ 0 ] )
                    {
                        e.preventDefault();
                        curItem = item;
                    }
                } );

                $( document ).on( 'click touchstart MSPointerDown', function ( e )
                {
                    var resetItem = true,
                        parents = $( e.target ).parents();

                    for ( var i = 0; i < parents.length; i++ )
                        if ( parents[ i ] == curItem[ 0 ] )
                            resetItem = false;

                    if ( resetItem )
                        curItem = false;
                } );
            } );
            return this;
        };

        if ( $( 'body' ).hasClass( 'boxed' ) && $( 'body' ).hasClass( 'tablet' ) ) {
            $( '#nav-menu > ul > li:has(ul)' ).doubleTapToGo();
        }

        /*------------------------------------------------------------------------------------------------------
         Heartbeat functions
         --------------------------------------------------------------------------------------------------------*/

        //Notifications related updates
        $( document ).on( 'heartbeat-tick.bb_notification_count', function ( event, data ) {
            setCounters();

            if ( data.hasOwnProperty( 'bb_notification_count' ) ) {
                data = data['bb_notification_count'];
                /********notification type**********/
                if ( data.notification > 0 ) { //has count
                    jQuery( "#ab-pending-notifications" ).text( data.notification ).removeClass( "no-alert" );
                    jQuery( "#ab-pending-notifications-mobile" ).text( data.notification ).removeClass( "no-alert" );
                    jQuery( "#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'>" + data.notification + "</span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( "#ab-pending-notifications" ).text( data.notification ).addClass( "no-alert" );
                    jQuery( "#ab-pending-notifications-mobile" ).text( data.notification ).addClass( "no-alert" );
                    jQuery( "#wp-admin-bar-my-account-notifications .ab-item[href*='/notifications/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from read ..
                jQuery( ".mobile #wp-admin-bar-my-account-notifications-read, #adminbar-links #wp-admin-bar-my-account-notifications-read" ).each( function () {
                    $( this ).find( "a" ).find( ".count" ).remove();
                } );
                /**********messages type************/
                if ( data.unread_message > 0 ) { //has count
                    jQuery( "#user-messages" ).find( "span" ).text( data.unread_message );
                    jQuery( ".ab-item[href*='/messages/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'>" + data.unread_message + "</span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( "#user-messages" ).find( "span" ).text( data.unread_message );
                    jQuery( ".ab-item[href*='/messages/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from unwanted place ..
                jQuery( ".mobile #wp-admin-bar-my-account-messages-default, #adminbar-links #wp-admin-bar-my-account-messages-default" ).find( "li:not('#wp-admin-bar-my-account-messages-inbox')" ).each( function () {
                    jQuery( this ).find( "span" ).remove();
                } );
                /**********messages type************/
                if ( data.friend_request > 0 ) { //has count
                    jQuery( ".ab-item[href*='/friends/']" ).each( function () {
                        jQuery( this ).append( "<span class='count'>" + data.friend_request + "</span>" );
                        if ( jQuery( this ).find( ".count" ).length > 1 ) {
                            jQuery( this ).find( ".count" ).first().remove(); //remove the old one.
                        }
                    } );
                } else {
                    jQuery( ".ab-item[href*='/friends/']" ).each( function () {
                        jQuery( this ).find( ".count" ).remove();
                    } );
                }
                //remove from unwanted place ..
                jQuery( ".mobile #wp-admin-bar-my-account-friends-default, #adminbar-links #wp-admin-bar-my-account-friends-default" ).find( "li:not('#wp-admin-bar-my-account-friends-requests')" ).each( function () {
                    jQuery( this ).find( "span" ).remove();
                } );

                //notification content
                jQuery( ".header-notifications.all-notifications .pop" ).html( data.notification_content );
            }
        } );

    }

    /**
     * BuddyPress Legacy Support
     */

    // Initialize
    BP_Legacy.init = function () {
        BP_Legacy.injected = false;
        _l.$document.ready( BP_Legacy.domReady );
    }

    // On dom ready we'll check if we need legacy BP support
    BP_Legacy.domReady = function () {
        BP_Legacy.check();
    }

    // Check for legacy support
    BP_Legacy.check = function () {
        if ( !BP_Legacy.injected && _l.body.hasClass( 'buddypress' ) && _l.$buddypress.length == 0 ) {
            BP_Legacy.inject();
        }
    }

    /*================================================================================================
     ** Cover Photo Functions **
     ==================================================================================================*/

    buddyboss_cover_photo = function ( option ) {

        $bb_cover_photo = $( "#page .bb-cover-photo:last" );
        object = $bb_cover_photo.data( "obj" ); // user or group
        object_id = $bb_cover_photo.data( "objid" ); // id of user or group
        nonce = $bb_cover_photo.data( "nonce" );
        $refresh_button = $( "#refresh-cover-photo-btn" );

        rebind_refresh_cover_events = function () {
            $refresh_button.click( function () {
                $( '.bb-cover-photo #growls' ).remove();
                $( "#update-cover-photo-btn" ).prop( "disabled", true ).removeClass( 'uploaded' ).addClass( 'disabled' ).find( "i" ).fadeIn();
                $refresh_button.prop( "disabled", true ).removeClass( 'uploaded' ).addClass( 'disabled' ).find( "i" ).fadeIn();

                $.ajax( {
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action': 'buddyboss_cover_photo_refresh',
                        'object': object,
                        'object_id': object_id,
                        'nonce': option.nonce,
                        'routine': $refresh_button.data( 'routine' )
                    },
                    success: function ( response ) {
                        var responseJSON = $.parseJSON( response );

                        $( "#update-cover-photo-btn" ).prop( "disabled", false ).removeClass( 'disabled' ).addClass( 'uploaded' ).find( "i.fa-spin" ).fadeOut();
                        $refresh_button.prop( "disabled", false ).removeClass( 'disabled' ).addClass( 'uploaded' ).find( "i.fa-spin" ).fadeOut();

                        if ( !responseJSON ) {
                            $.growl.error( { title: "", message: BuddyBossOptions.bb_cover_photo_failed_refresh } );
                        }

                        if ( responseJSON.error ) {
                            $.growl.error( { title: "", message: responseJSON.error } );
                        } else {
                            $bb_cover_photo.find( ".holder" ).remove();

                            image = responseJSON.image;
                            $bb_cover_photo.append( '<div class="holder"></div>' );
                            $bb_cover_photo.find( ".holder" ).css( "background-image", 'url(' + image + ')' );

                            if ( 'refresh' == $refresh_button.data( 'routine' ) ) {
                                $refresh_button.parent().toggleClass( 'no-photo' );
                                $refresh_button.find( '.fa-refresh' ).removeClass( 'fa-refresh' ).addClass( 'fa-times' );
                                $refresh_button.find( '>div' ).html( BuddyBossOptions.bb_cover_photo_remove_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>' );
                                $refresh_button.attr( 'title', BuddyBossOptions.bb_cover_photo_remove_title );
                                $refresh_button.data( 'routine', 'remove' );
                            } else {
                                $refresh_button.parent().toggleClass( 'no-photo' );
                                $refresh_button.find( '.fa-times' ).removeClass( 'fa-times' ).addClass( 'fa-refresh' );
                                $refresh_button.find( '>div' ).html( BuddyBossOptions.bb_cover_photo_refresh_title + '<i class="fa fa-spinner fa-spin" style="display: none;"></i>' );
                                $refresh_button.attr( 'title', BuddyBossOptions.bb_cover_photo_refresh_title );
                                $refresh_button.data( 'routine', 'refresh' );
                            }
                            $.growl.notice( { title: "", message: responseJSON.success } );
                        }
                    },
                    error: function ( ) {
                        $bb_cover_photo.find( ".progress" ).hide().find( "span" ).css( "width", '0%' );

                        $.growl.error( { message: 'Error' } );
                    }
                } );
            } );
        };

        if ( $refresh_button.length > 0 ) {
            rebind_refresh_cover_events();
        }
    }

    /** --------------------------------------------------------------- */

    /**
     * BuddyPress Legacy Support
     */

    // Initialize
    BP_Legacy.init = function () {
        BP_Legacy.injected = false;
        _l.$document.ready( BP_Legacy.domReady );
    }

    // On dom ready we'll check if we need legacy BP support
    BP_Legacy.domReady = function () {
        BP_Legacy.check();
    }

    // Check for legacy support
    BP_Legacy.check = function () {
        if ( !BP_Legacy.injected && _l.body.hasClass( 'buddypress' ) && _l.$buddypress.length == 0 ) {
            BP_Legacy.inject();
        }
    }

    // Inject the right code depending on what kind of legacy support
    // we deduce we need
    BP_Legacy.inject = function () {
        BP_Legacy.injected = true;

        var $secondary = $( '#secondary' ),
            do_legacy = false;

        var $content = $( '#content' ),
            $padder = $content.find( '.padder' ).first(),
            do_legacy = false;

        var $article = $content.children( 'article' ).first();

        var $legacy_page_title,
            $legacy_item_header;

        // Check if we're using the #secondary widget area and add .bp-legacy inside that
        if ( $secondary.length ) {
            $secondary.prop( 'id', 'secondary' ).addClass( 'bp-legacy' );

            do_legacy = true;
        }

        // Check if the plugin is using the #content wrapper and add #buddypress inside that
        if ( $padder.length ) {
            $padder.prop( 'id', 'buddypress' ).addClass( 'bp-legacy entry-content' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Adding #buddypress to .padder' );
        }
        else if ( $content.length ) {
            $content.wrapInner( '<div class="bp-legacy entry-content" id="buddypress"/>' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Dynamically wrapping with #buddypresss' );
        }

        // Apply legacy styles if needed
        if ( do_legacy ) {

            _l.$buddypress = $( '#buddypress' );

            $legacy_page_title = $( '.buddyboss-bp-legacy.page-title' );
            $legacy_item_header = $( '.buddyboss-bp-legacy.item-header' );

            // Article Element
            if ( $article.length === 0 ) {
                $content.wrapInner( '<article/>' );
                $article = $( $content.find( 'article' ).first() );
            }

            // Page Title
            if ( $content.find( '.entry-header' ).length === 0 || $content.find( '.entry-title' ).length === 0 ) {
                $legacy_page_title.prependTo( $article ).show();
                $legacy_page_title.children().unwrap();
            }

            // Item Header
            if ( $content.find( '#item-header-avatar' ).length === 0 && _l.$buddypress.find( '#item-header' ).length ) {
                $legacy_item_header.prependTo( _l.$buddypress.find( '#item-header' ) ).show();
                $legacy_item_header.children().unwrap();
            }
        }
    }

    // Inject the right code depending on what kind of legacy support
    // we deduce we need
    BP_Legacy.inject = function () {
        BP_Legacy.injected = true;

        var $secondary = $( '#secondary' ),
            do_legacy = false;

        var $content = $( '#content' ),
            $padder = $content.find( '.padder' ).first(),
            do_legacy = false;

        var $article = $content.children( 'article' ).first();

        var $legacy_page_title,
            $legacy_item_header;

        // Check if we're using the #secondary widget area and add .bp-legacy inside that
        if ( $secondary.length ) {
            $secondary.prop( 'id', 'secondary' ).addClass( 'bp-legacy' );

            do_legacy = true;
        }

        // Check if the plugin is using the #content wrapper and add #buddypress inside that
        if ( $padder.length ) {
            $padder.prop( 'id', 'buddypress' ).addClass( 'bp-legacy entry-content' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Adding #buddypress to .padder' );
        }
        else if ( $content.length ) {
            $content.wrapInner( '<div class="bp-legacy entry-content" id="buddypress"/>' );

            do_legacy = true;

            // console.log( 'Buddypress.js #buddypress fix: Dynamically wrapping with #buddypresss' );
        }

        // Apply legacy styles if needed
        if ( do_legacy ) {

            _l.$buddypress = $( '#buddypress' );

            $legacy_page_title = $( '.buddyboss-bp-legacy.page-title' );
            $legacy_item_header = $( '.buddyboss-bp-legacy.item-header' );

            // Article Element
            if ( $article.length === 0 ) {
                $content.wrapInner( '<article/>' );
                $article = $( $content.find( 'article' ).first() );
            }

            // Page Title
            if ( $content.find( '.entry-header' ).length === 0 || $content.find( '.entry-title' ).length === 0 ) {
                $legacy_page_title.prependTo( $article ).show();
                $legacy_page_title.children().unwrap();
            }

            // Item Header
            if ( $content.find( '#item-header-avatar' ).length === 0 && _l.$buddypress.find( '#item-header' ).length ) {
                $legacy_item_header.prependTo( _l.$buddypress.find( '#item-header' ) ).show();
                $legacy_item_header.children().unwrap();
            }
        }
    }

    // Boot er' up
    jQuery( document ).ready( function () {
        App.init();
    } );

}( jQuery, window ) );

/**
 * 3. Inline Plugins
 * ====================================================================
 * Inline Plugins
 */


/**
 * jRMenuMore to allow menu to have a More option for responsiveness
 * Credit to http://blog.sodhanalibrary.com/2014/02/jrmenumore-jquery-plugin-for-responsive.html
 *
 * uses resize.js for better resizing
 *
 **/
( function ( $ ) {
    $.fn.jRMenuMore = function ( widthfix ) {
        $( this ).each( function () {
            $( this ).addClass( "horizontal-responsive-menu" );
            alignMenu( this );
            var robj = this;

            $( '#right-panel-inner' ).resize( function () {
                $( robj ).append( $( $( $( robj ).children( "li.hideshow" ) ).children( "ul" ) ).html() );
                $( robj ).children( "li.hideshow" ).remove();
                alignMenu( robj );
            } );

            function alignMenu( obj ) {
                var w = 0;
                var mw = $( obj ).width() - widthfix;
                var i = -1;
                var menuhtml = '';
                jQuery.each( $( obj ).children(), function () {
                    i++;
                    w += $( this ).outerWidth( true );
                    if ( mw < w ) {
                        menuhtml += $( '<div>' ).append( $( this ).clone() ).html();
                        $( this ).remove();
                    }
                } );

                $( obj ).append(
                    '<li class="hideshow">' +
                    '<a href="#"><i class="fa fa-ellipsis-h"></i></a><ul>' +
                    menuhtml + '</ul></li>' );
                $( obj ).children( "li.hideshow ul" ).css( "top",
                    $( obj ).children( "li.hideshow" ).outerHeight( true ) + "px" );

                $( obj ).find( "li.hideshow > a" ).click( function ( e ) {
                    e.preventDefault();
                    var $horizontal_menu_ul = $( this ).parent( 'li.hideshow' ).children( "ul" );
                    $horizontal_menu_ul.toggle();
                    $( this ).parent( 'li.hideshow' ).parent( "ul" ).toggleClass( 'open' );

                    //Members Index > Too many member types
                    var $members_type_menu = $( '#members-directory-form div.item-list-tabs ul:first-child' );

                    if ( 0 < $members_type_menu.length ) {

                        //Change horizontal menu display from flex to block for member types tab
                        if ( $horizontal_menu_ul.is( ':visible' ) ) {
                            $horizontal_menu_ul.css( 'display', 'block' );
                        } else {
                            $horizontal_menu_ul.css( 'display', 'none' );
                        }

                        //Horizontal responsive menu right offset fix
                        var $horizontal_menu = $( 'div.item-list-tabs .horizontal-responsive-menu' );
                        var right_offset = ( $( window ).width() - ( $horizontal_menu.offset().left + $horizontal_menu.outerWidth() ) );
                        $( 'div.item-list-tabs li.hideshow > ul' ).css( { right: right_offset } );
                    }

                } );

                $( document ).mouseup( function ( e ) {
                    var container = $( 'li.hideshow' );

                    if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
                        container.children( "ul" ).hide();
                        container.parent( "ul" ).removeClass( 'open' );
                    }
                } );

                if ( $( obj ).find( "li.hideshow" ).find( "li" ).length > 0 ) {
                    $( obj ).find( "li.hideshow" ).show();
                } else {
                    $( obj ).find( "li.hideshow" ).hide();
                }
            }

        } );

    }

}( jQuery ) );

/* Support some plugins */

( function ( $ ) {

    "use strict";

    window.Plugins = {
        init: function () {
            this.groupHierarchy();
            this.hideActionWrap();
            this.onAjaxComplete();
        },
        groupHierarchy: function () {
            $( 'body' ).on( 'click', '.item-subitem-indicator a', function () {
                $( this ).parent().toggleClass( 'bb-subitem-open' );
            } );
        },
        onAjaxComplete: function () {
            $( document ).ajaxComplete( function () {
                $( '.directory.groups #primary #buddypress .item-list li .action .action-wrap' ).each( function () {
                    var elem = $( this );
                    if ( $.trim( elem.html() ) === '' ) {
                        if ( !elem.parent().hasClass( "bb-hide-elem" ) ) {
                            elem.parent().addClass( 'bb-hide-elem' );
                        }
                    }
                } );
            } );
        },
        hideActionWrap: function () {
            $( '.directory.groups #primary #buddypress .item-list li .action .action-wrap' ).each( function () {
                var elem = $( this );
                if ( $.trim( elem.html() ) === '' ) {
                    if ( !elem.parent().hasClass( "bb-hide-elem" ) ) {
                        elem.parent().addClass( 'bb-hide-elem' );
                    }
                }
            } );
        }
    };

    $( document ).on( 'ready', function () {
        Plugins.init();
    } );

} )( jQuery );
