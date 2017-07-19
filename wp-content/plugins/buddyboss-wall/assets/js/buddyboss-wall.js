/**
 * BuddyBoss Wall
 *
 * A BuddyPress plugin for activity feeds
 *
 * This file should load in the footer
 *
 * @author      BuddyBoss
 * @since       BuddyBoss Wall (1.0.0)
 * @package     BuddyBoss Wall
 *
 * ====================================================================
 *
 * 1. jQuery + Globals
 * 2. Main Wall Functionality
 * 3. Wall Tooltips
 */


/**
 * 1. jQuery + Globals
 * ====================================================================
 */
var jq = $ = jQuery;

// Window.Code fallback
window.Code = window.Code || {};

// Util
window.Code.BuddyBoss_Wall_Util = ( function( window, $, opt, undefined ) {

  var Util = {
    state: opt,
    lang: function( key ) {
      var key = key || 'undefined key!';
      return opt[key] || 'Language key missing for: ' + key;
    }
  }

  return Util;

}
(
  window,
  window.jQuery,
  window.BuddyBoss_Wall_Appstate || false
));

/**
 * 2. Main Wall Functionality
 * ====================================================================
 * @returns {object} BuddyBoss_Wall
 */

window.Code.BuddyBoss_Wall = ( function( window, $, util, undefined ) {

  var _l = {};

  var state = util.state || {},
      lang  = util.lang;

  var Wall = {
    on: null,
    setup_form: function() {
      var $form = $('#buddyboss-wall-tpl-form'),
          $activity = $('body.just-me.has-activity #item-body > .activity').first(),
          $whats_new = $('#whats-new-form');


      if ( ! $whats_new.length && $form.length && $activity.length ) {
        // $activity.before( $form.html() );
        // $(document).trigger('buddyboss:post:form:injected');
        // $(document).trigger('ready');
      }
      // console.log( 'form' );
      // console.log( $form );
    },
    setup_comments: function() {
      var $comments = $('.buddyboss-wall-tpl-activity-comments');

      $comments.each(function(){
        var $comment = $(this),
            $wrap    = $comment.parent().find('.activity-comments');

        if ( $wrap.length && ! $comment.data( 'buddyboss-wall-appended' ) ) {
          $comment.data( 'buddyboss-wall-appended', true )
          $wrap.prepend( $comment.html() );
        }
      });
    },
    setup_link_previews: function(){
        jQuery( '#whats-new' ).addClass( 'bblinkBox' );

		jQuery( '#whats-new-textarea' ).append( '<div class="bb-url-scrapper-container"><i class="bb-url-scrapper-loading buddyboss-wall-ajax-loader fa fa-spinner"></i><div id="bb-url-scrapper"><div id="bb-url-scrapper-img-holder"><div id="bb-url-scrapper-img"><img src="" /><a title="Cancel Preview Image" href="#" id="bbimagecloselinksuggestion"><i class="fa fa-times"></i></a></div><div class="bb-url-thumb-nav"><input type="button" id="bb-url-prevPicButton" value="<" /><input type="button" id="bb-url-nextPicButton" value=">"><div id="bb-url-scrapper-img-count"></div></div></div><div id="bb-url-scrapper-text-holder"><div id="bb-url-scrapper-title"></div><div id="bb-url-scrapper-url"></div><div id="bb-url-scrapper-description"></div><div id="bb-url-error"></div><a title="Cancel Preview" href="#" id="bbcloselinksuggestion"><i class="fa fa-times"></i></a></div></div></div>' );

		jQuery( '#whats-new-form' ).append( '<input type="hidden" id="bb-url-scrapper-img-hidden" name="bb-url-scrapper-img-hidden" value="" /><input type="hidden" id="bb-url-scrapper-title-hidden"  name="bb-url-scrapper-title-hidden" value="" /><input type="hidden" id="bb-url-scrapper-url-hidden" name="bb-url-scrapper-url-hidden" value="" /><input type="hidden" id="bb-url-scrapper-description-hidden" name="bb-url-scrapper-description-hidden" value="" /><input type="hidden" id="bb-url-no-scrapper" name="bb-url-no-scrapper" value="1" />' );

		jQuery( '#bb-url-scrapper' ).hide();

		jQuery( "#bb-url-nextPicButton" ).click( function ( $ ) {
			bb_url_imgArrayCounter ++;
			if ( bb_url_imgArrayCounter >= bb_url_imgSrcArray.length )
				bb_url_imgArrayCounter = 0;
			jQuery( '#bb-url-scrapper-img' ).find( 'img' ).attr( 'src', bb_url_imgSrcArray[bb_url_imgArrayCounter] );
			jQuery( '#bb-url-scrapper-img-hidden' ).val( bb_url_imgSrcArray[bb_url_imgArrayCounter] );
			jQuery( '#bb-url-scrapper-img-count' ).text( ( bb_url_imgArrayCounter + 1 ) + ' of ' + bb_url_imgSrcArray.length )
		} );

		jQuery( "#bb-url-prevPicButton" ).click( function ( $ ) {
			bb_url_imgArrayCounter --;
			if ( bb_url_imgArrayCounter < 0 )
				bb_url_imgArrayCounter = bb_url_imgSrcArray.length - 1;
			jQuery( '#bb-url-scrapper-img' ).find( 'img' ).attr( 'src', bb_url_imgSrcArray[bb_url_imgArrayCounter] );
			jQuery( '#bb-url-scrapper-img-hidden' ).val( bb_url_imgSrcArray[bb_url_imgArrayCounter] );
			jQuery( '#bb-url-scrapper-img-count' ).text( ( bb_url_imgArrayCounter + 1 ) + ' of ' + bb_url_imgSrcArray.length )
		} );

		jQuery( "#bbimagecloselinksuggestion" ).click( function ( e ) {
			e.preventDefault();
			jQuery( '#bb-url-scrapper-img-holder' ).hide();
			jQuery( '#bb-url-scrapper-img-hidden' ).val( '' );
            // enable photo upload button if image is cancelled from posted link
            jQuery('#buddyboss-media-add-photo-button').prop('disabled', false);
        } );
		
		jQuery( "#bbcloselinksuggestion" ).click( function ( e ) {
			e.preventDefault();
			jQuery( '.bb-url-scrapper-container' ).hide();
			jQuery( '#bb-url-no-scrapper' ).val( "1" );
            jQuery( '#bb-url-scrapper-description' ).text( '' );
			jQuery( '#bb-url-scrapper-description-hidden' ).val( '' );
			jQuery( '#bb-url-scrapper-title' ).text( '' );
			jQuery( '#bb-url-scrapper-title-hidden' ).val( '' );
			jQuery( '#bb-url-scrapper-url' ).text( '' );
			jQuery( '#bb-url-scrapper-url-hidden' ).val( '' );
			jQuery( '#bb-url-scrapper-img' ).css( 'backgroundImage', '' );
		} );

		jQuery( ".bblinkBox" ).on( "keyup", function ( event ) {
			if ( jQuery( '#bb-url-no-scrapper' ).val() === "1" ) {
				urlText = this.value;
				bb_url_abortTimer();
				bb_url_tid = setTimeout( function () {
					bb_url_scrapeURL( urlText )
				}, 1000 );
				if ( event.which == 13 ) {
					this.rows ++
				}
			}
		} );
    },
    setup: function() {
      Wall.on = true;

      $.ajaxPrefilter( Wall.prefilter );
      $(document).ajaxSuccess( function( response ) {
        Wall.setup_comments();
        setTimeout( Wall.setup_comments, 205 );
        setTimeout( Wall.setup_comments, 500 );
      } );

      Wall.setup_form();

      Wall.setup_comments();
      
      if( state.enabled_link_preview ){
        Wall.setup_link_previews();
      }

      // Activity greeting
      var $greeting_tpl = $('#buddyboss-wall-tpl-greeting').html(),
          $greeting     = $('#whats-new-form .activity-greeting');

      if ( $greeting.length && !! $greeting_tpl ) {
        $greeting.html( $greeting_tpl ).show();
      }

    },
    teardown: function() {
      Wall.on = false;
    },
    prefilter: function( options, origOptions, jqXHR ) {
	item_type = origOptions.data && origOptions.data.item_type || '';

	var act_id         = parseInt( origOptions.data && origOptions.data.id || 0 ),
		action         = origOptions.data && origOptions.data.action || '',
		is_like_action = ( action === 'activity_mark_fav' || action === 'activity_mark_unfav' ),
		is_update_action = ( action === 'post_update' ),
		is_a_comment	 = ( item_type === 'comment' ),
		target,
		new_data;

      /**
      console.dir({
        options: options,
        origOptions: origOptions,
        act_id: act_id,
        action: action,
        is_like_action: is_like_action
      });
      /**/
		
	if ( is_update_action && state.enabled_link_preview ) {
		target = $( '#bb-url-scrapper-url' ).html().length;
		
		if( target > 0) {
			options.data += "&bb_link_url=" + encodeURIComponent( $( "#bb-url-scrapper-url-hidden" ).val() ); // URL link preview
			options.data += "&bb_link_title=" + encodeURIComponent( $( "#bb-url-scrapper-title-hidden" ).val() );  // URL link preview
			options.data += "&bb_link_img=" + encodeURIComponent( $( '#bb-url-scrapper-img-hidden' ).val() ); // URL link preview
			options.data += "&bb_link_description=" + encodeURIComponent( $( "#bb-url-scrapper-description-hidden" ).val() );  // URL link preview
			
			//Removing the preview box
			$( '.bb-url-scrapper-container' ).hide();
			$( '#bb-url-no-scrapper' ).val( "1" ); // URL link preview
			$( '#bb-url-scrapper-description' ).text( '' );
			$( '#bb-url-scrapper-description-hidden' ).val( '' );
			$( '#bb-url-scrapper-title' ).text( '' );
			$( '#bb-url-scrapper-title-hidden' ).val( '' );
			$( '#bb-url-scrapper-url' ).text( '' );
			$( '#bb-url-scrapper-url-hidden' ).val( '' );
			$( '#bb-url-scrapper-img' ).css( 'backgroundImage', '' );
			
		}
		
	}

      if ( is_like_action && act_id > 0 ) {

        target = $( '#activity-' + act_id ).find( '.button.loading' );
        type   = target.hasClass('fav') ? 'fav' : 'unfav';

	if( is_a_comment ){
	    target = $( '#acomment-' + act_id ).find( '.acomment-like.loading' );
	    type   = target.hasClass('fav-comment') ? 'fav' : 'unfav';
	}

        options.success = ( function( old_success ) {
          return function( response, txt, xhr ) {
            // Let the default buddypress.js return handler
            // take care of errors
            if ( response[0] + response[1] === '-1' && $.isFunction( old_success ) ) {
              old_success( response );
            }
            else {
              Wall.success( target, type, is_a_comment, response, txt, xhr );
            }
          }
        })(options.success);

      }

    },
    success: function( target, type, is_a_comment, response, text, xhr ) {

      /* BuddyBoss: Modified to get number of likes */
      var has_like_text = false,
          but_text = '',
          num_likes_text = '',
          bp_default_like_count = 0,
          remove_comment_ul = false,
          responseJSON = response.indexOf('{') != -1
                       ? jQuery.parseJSON( response )
                       : false;

      // console.log( response );

      // We have a response and button text
      if ( responseJSON && responseJSON.but_text ) {
        but_text = responseJSON.but_text;
      }
      else {
        but_text = response;
      }

      // We have a response and like count (int)
      if ( responseJSON && responseJSON.hasOwnProperty( 'like_count' ) ) {

        // If the count is above 0
        if ( responseJSON.like_count ) {
          has_like_text = true;
          num_likes_text = responseJSON.num_likes;
        }

        // If the count is 0 we need to remove the activity wrap
        else {
          remove_comment_ul = true;
        }
      }

      // console.log(  has_like_text  );

      target.fadeOut( 200, function() {
        var button             = jq(this),
            item               = button.parents('.activity-item'),
            comments_wrap      = item.find('.activity-comments'),
            comments_ul        = comments_wrap.find('ul').first(),
            existing_like_text = comments_wrap.find('.activity-like-count:not(.reply-like-count)'),
            existing_comments  = comments_wrap.find('li').not('.activity-like-count'),
            new_like_text      = num_likes_text;

	if( is_a_comment ){
	    comments_wrap	= button.parents('.acomment-options');
	    comments_ul		= comments_wrap.find('ul').first();
            existing_like_text	= comments_wrap.find('.activity-like-count');
            existing_comments	= comments_wrap.find('li').not('.activity-like-count');
	    new_like_text	= num_likes_text;
	}

        /**
        console.dir({
          item: item,
          comments_wrap: comments_wrap,
          comments_ul: comments_ul
        });
        /**/

        // Take care of replacing the button with like/unlike
        button.html(but_text);
        button.attr('title', 'fav' == type ? BP_DTheme.remove_fav : BP_DTheme.mark_as_fav);
        button.fadeIn(200);

        // Remove existing like text, might be replaced if this isn't an unlike
        // or there are existing likes left
        existing_like_text.remove();

        // If we have 'you like this' type text
        if ( has_like_text ) {

          // console.log( num_likes_text );
          // console.log( new_like_text );
          // console.log( bp_default_like_count );

          // If we have an existing UL prepend the LI
          if ( comments_ul.length ) {
            comments_ul.prepend( new_like_text );
            // console.log( 'UL found' );
          }

          // Otherwise lets wrap it up again and add to the comments
          else {
	      if( is_a_comment ){
		  comments_wrap.append( '<ul class="acomment-reply-like-content">' + new_like_text + '</ul>' );
	      }
	      else{
		  comments_wrap.prepend( '<ul>' + new_like_text + '</ul>' );
	      }
            // console.log( 'UL not found' );
          }

        }

        // If we need to clean up the comment UL, this happens when
        // someone unlikes a post and there are no comments so an empty
        // UL element stays around causing some spacing and design flaws,
        // we remove that below
        if ( remove_comment_ul && comments_ul.length && ! existing_comments.length ) {
          comments_ul.remove();
        }

      });

      if ( 'fav' == type ) {
        var bp_default_like_count_str = jq('.item-list-tabs ul #activity-favorites span').html();
		
		if ( bp_default_like_count_str != undefined ) {
			bp_default_like_count = Number( bp_default_like_count_str.replace(/,/g, '') ) + 1;
		}

        if ( !jq('.item-list-tabs #activity-favorites').length )
          jq('.item-list-tabs ul li#activity-mentions').before( '<li id="activity-favorites"><a href="#" class="localized">' + BP_DTheme.my_favs + ' <span>0</span></a></li>');

	  if( is_a_comment ){
	      target.removeClass('fav-comment');
	      target.addClass('unfav-comment');
	  }
	  else{
	      target.removeClass('fav');
	      target.addClass('unfav');
	  }
        jq('.item-list-tabs ul #activity-favorites span').html( Number( jq('.item-list-tabs ul #activity-favorites span').html() ) + 1 );

      }
      else {

        var bp_default_like_count_str = jq('.item-list-tabs ul #activity-favorites span').html();
		
		if ( bp_default_like_count_str != undefined ) {
			bp_default_like_count = Number( bp_default_like_count_str.replace(/,/g, '') ) - 1;
		}
		
	if( is_a_comment ){
	    target.removeClass('unfav-comment');
	    target.addClass('fav-comment');
	}
	else{
	    target.removeClass('unfav');
	    target.addClass('fav');
	}
		if ( bp_default_like_count_str ) {
			jq('.item-list-tabs ul #activity-favorites span').html( bp_default_like_count );
		}

        if ( bp_default_like_count == 0 ) {
          if ( jq('.item-list-tabs ul #activity-favorites').hasClass('selected') )
            bp_activity_request( null, null );

          jq('.item-list-tabs ul #activity-favorites').remove();
        }
      }

      // BuddyBoss: usually there's parent().parent().parent(), but our markup is slightly different.
      if ( 'activity-favorites' == jq( '.item-list-tabs li.selected').attr('id') )
        //target.parent().parent().slideUp(100);
	target.closest('.activity-item').slideUp(100);

      target.removeClass('loading');
      // document.write = document.oldDocumentWrite;


    //   function(response) {
    //     target.removeClass('loading');

    //     target.fadeOut( 200, function() {
    //       jq(this).html(response);
    //       jq(this).attr('title', 'fav' == type ? BP_DTheme.remove_fav : BP_DTheme.mark_as_fav);
    //       jq(this).fadeIn(200);
    //     });

    //     if ( 'fav' == type ) {
    //       if ( !jq('.item-list-tabs #activity-favs-personal-li').length ) {
    //         if ( !jq('.item-list-tabs #activity-favorites').length )
    //           jq('.item-list-tabs ul #activity-mentions').before( '<li id="activity-favorites"><a href="#">' + BP_DTheme.my_favs + ' <span>0</span></a></li>');

    //         jq('.item-list-tabs ul #activity-favorites span').html( Number( jq('.item-list-tabs ul #activity-favorites span').html() ) + 1 );
    //       }

    //       target.removeClass('fav');
    //       target.addClass('unfav');

    //     } else {
    //       target.removeClass('unfav');
    //       target.addClass('fav');

    //       jq('.item-list-tabs ul #activity-favorites span').html( Number( jq('.item-list-tabs ul #activity-favorites span').html() ) - 1 );

    //       if ( !Number( jq('.item-list-tabs ul #activity-favorites span').html() ) ) {
    //         if ( jq('.item-list-tabs ul #activity-favorites').hasClass('selected') )
    //           bp_activity_request( null, null );

    //         jq('.item-list-tabs ul #activity-favorites').remove();
    //       }
    //     }

    //     if ( 'activity-favorites' == jq( '.item-list-tabs li.selected').attr('id') )
    //       target.parent().parent().parent().slideUp(100);
    //   });
    // }

    } // success()

  }; // Wall {}

	$( document ).ready( function () {
		Wall.setup();


		// start -  fetch URL on activity
		jQuery.ajax = ( function ( _ajax ) {
			var protocol = location.protocol,
					hostname = location.hostname,
					exRegex = RegExp( protocol + '//' + hostname ),
					YQL = 'http' + ( /^https/.test( protocol ) ? 's' : '' ) + '://query.yahooapis.com/v1/public/yql?callback=?',
					query = 'select * from html where url="{URL}" and xpath="*"';

			function isExternal( url ) {
				return ! exRegex.test( url ) && /:\/\//.test( url )
			}

			return function ( o ) {
				var url = o.url;
				if ( /get/i.test( o.type ) && ! /json/i.test( o.dataType ) && isExternal( url ) ) {
					o.url = YQL;
					o.dataType = 'json';
					o.data = {
						q: query.replace( '{URL}', url + ( o.data ? ( /\?/.test( url ) ? '&' : '?' ) + jQuery.param( o.data ) : '' ) ),
						format: 'xml'
					};
					if ( ! o.success && o.complete ) {
						o.success = o.complete;
						delete o.complete
					}
					o.success = ( function ( _success ) {
						return function ( data ) {
							if ( _success ) {
								_success.call( this, {
									responseText: ( data.results[0] || '' ).replace( /<script[^>]+?\/>|<script(.|\s)*?\/script>/gi, '' )
								}, 'success' )
							}
						}
					} )( o.success )
				}
				return _ajax.apply( this, arguments )
			}
		} )( jQuery.ajax );

		String.prototype.startsWith = function ( str ) {
			return ( this.match( "^" + str ) == str )
		};
	} );

  var API = {
    setup: function() {
      Wall.setup();
    },
    teardown: function() {
      Wall.teardown();
    }
  } // API

  return API;
}
(
  window,
  window.jQuery,
  window.Code.BuddyBoss_Wall_Util
));



/**
 * 3. Wall Tooltips
 * ====================================================================
 */

;( function ( window, $, util, undefined ) {

  var config = {
    ajaxResetTimeout: 201
  }

  var state = util.state || {};
  var lang  = util.lang;

  var Tooltips = {};
  var $el = {};

  /**
   * Init

   * @return {void}
   */
  Tooltips.init = function() {
    // Globals
    $el.document = $(document);

    // Events
    $el.document.ajaxSuccess( Tooltips.ajaxSuccessListener );

    // console.log( '' );
    // console.log( 'Tooltips:' );
    // console.log( '=========' );
    // console.log( 'state' );
    // console.log( state );

    // First run
    Tooltips.initTooltips();

    // Localization, we need to override some BP_Dtheme variables
    if ( BP_DTheme && state ) {
      $.extend( BP_DTheme, state );
    }
  }

  /**
   * Listen to AJAX requests and refresh dynamic content/functionality

   * @return {void}
   */
  Tooltips.ajaxSuccessListener = function( event, jqXHR, options ) {
    Tooltips.destroyTooltips();

    window.setTimeout( Tooltips.initTooltips, config.ajaxResetTimeout );
  }

  /**
   * Teardown tooltips if they exist
   *
   * @return {void}
   */
  Tooltips.destroyTooltips = function() {
    if ( $el.tooltips && $el.tooltips.length ) {
      $el.tooltips.tooltipster('destroy');
      $el.tooltips = null;
    }
  }

  /**
   * Prepare tooltips
   *
   * @return {void}
   */
  Tooltips.initTooltips = function() {
    // Destroy any existing tooltips
    // if ( $el.tooltips && $el.tooltips.length ) {
    //  $el.tooltips.tooltipster('destroy');
    //  $el.tooltips = null;
    // }

    // Find tooltips on page
    $el.tooltips = $('.buddyboss-wall-tt-others');

    // Init tooltips
    if ( $el.tooltips.length ) {
      $el.tooltips.tooltipster({
        contentAsHTML:  true,
        functionInit:   Tooltips.getTooltipContent,
        interactive:    true,
        position:       'top-left',
        theme:          'tooltipster-buddyboss'
      });
    }
  }

  /**
   * Get tooltip content
   *
   * @param  {object} origin  Original tooltip element
   * @param  {string} content Current tooltip content
   *
   * @return {string}         Tooltip content
   */
  Tooltips.getTooltipContent = function( origin, content ) {
    var $content = origin.parent().find('.buddyboss-wall-tt-content').detach().html();

    return $content;
  }

  if ( state.load_tooltips ) {
      Tooltips.load_tooltips = true;
	//Tooltips.init();
  }
  jQuery(document).ready(function(){
    if( Tooltips.load_tooltips===true )
    Tooltips.init();
 });
}
(
  window,
  window.jQuery,
  window.Code.BuddyBoss_Wall_Util
));

function budyboss_wall_comment_like_unlike(target){
    jq = jQuery;
    target = jq(target);

   /* Favoriting activity stream items */
    if ( target.hasClass('fav-comment') || target.hasClass('unfav-comment') ) {
	    var type = target.hasClass('fav-comment') ? 'fav' : 'unfav';
	    var parent = target.closest('[id^=acomment-]');
	    var parent_id = parent.attr('id').substr( 9, parent.attr('id').length );

	    target.addClass('loading');

	    jq.post( ajaxurl, {
		    action: 'activity_mark_' + type,
		    'cookie': bp_get_cookies(),
		    'id': parent_id,
		    'item_type' : 'comment'
	    },
	    function(response) {
		    target.removeClass('loading');

		    target.fadeOut( 200, function() {
			    jq(this).html(response);
			    jq(this).attr('title', 'fav' == type ? BP_DTheme.remove_fav : BP_DTheme.mark_as_fav);
			    jq(this).fadeIn(200);
		    });

		    if ( 'fav' == type ) {
			    if ( !jq('.item-list-tabs #activity-favs-personal-li').length ) {
				    if ( !jq('.item-list-tabs #activity-favorites').length )
					    jq('.item-list-tabs ul #activity-mentions').before( '<li id="activity-favorites"><a href="#">' + BP_DTheme.my_favs + ' <span>0</span></a></li>');

				    jq('.item-list-tabs ul #activity-favorites span').html( Number( jq('.item-list-tabs ul #activity-favorites span').html() ) + 1 );
			    }

			    target.removeClass('fav-comment');
			    target.addClass('unfav-comment');

		    } else {
			    target.removeClass('unfav-comment');
			    target.addClass('fav-comment');

			    jq('.item-list-tabs ul #activity-favorites span').html( Number( jq('.item-list-tabs ul #activity-favorites span').html() ) - 1 );

			    if ( !Number( jq('.item-list-tabs ul #activity-favorites span').html() ) ) {
				    if ( jq('.item-list-tabs ul #activity-favorites').hasClass('selected') )
					    bp_activity_request( null, null );

				    jq('.item-list-tabs ul #activity-favorites').remove();
			    }
		    }

		    /*if ( 'activity-favorites' == jq( '.item-list-tabs li.selected').attr('id') )
			    target.closest( '.activity-item' ).slideUp( 100 );*/
	    });
    }
    return false;
}

var bb_url_imgSrcArray = [ ];
var bb_url_imgArrayCounter = 0;
var bb_url_tid;

function bb_url_scrapeURL( urlText ) {
    var urlString = "";
    if ( urlText.indexOf( 'http://' ) >= 0 ) {
        urlString = bb_url_getUrl( 'http://', urlText );
    } else if ( urlText.indexOf( 'https://' ) >= 0 ) {
        urlString = bb_url_getUrl( 'https://', urlText );
    } else if ( urlText.indexOf( 'www.' ) >= 0 ) {
        urlString = bb_url_getUrl( 'www', urlText );
    }

    if( urlString != "" ){
        //check if the url of any of the excluded video oembeds
        var url_a = document.createElement( 'a' );
        url_a.href = urlString;
        var hostname = url_a.hostname;
        if ( window.Code.BuddyBoss_Wall_Util.state.excluded_oembed_hosts.indexOf( hostname ) != - 1 ) {
            urlString = "";
        }
    }

    if( '' === urlString ) {
        jQuery( '#bb-url-scrapper' ).hide();
        jQuery( '.bb-url-scrapper-container' ).hide();
        return;
    } else {
        bb_load_url_preview( urlString );
    }
}

function bb_load_url_preview( urlString ) {
    if ( bb_is_valid_url( urlString ) ) {
        bb_url_getUrlData( urlString );
    }
}

function bb_url_abortTimer() {
    if ( null != bb_url_tid )
        clearTimeout( bb_url_tid )
}

function bb_url_getUrlData( urlString ) {
    jQuery('#whats-new-submit input').prop('disabled', true);
    jQuery( '.bb-url-scrapper-container' ).show();
    jQuery( '.bb-url-scrapper-loading' ).show();
    jQuery( '#bb-url-scrapper' ).hide();
    jQuery( '#bb-url-error' ).hide();
    var ajaxdata = {
        action: 'bb_url_parser',
        url: urlString
    }
    jQuery.ajax( {
        url: ajaxurl,
        data: ajaxdata,
        type: 'POST',
        dataType: 'json',
        success: function ( res ) {
            jQuery('#whats-new-submit input').prop('disabled', false);
            jQuery('#buddyboss-media-add-photo-button').prop('disabled', false);
            jQuery('#bb-url-scrapper-img-holder').show();
            if ( res.title == "" ) {
                jQuery( '.bb-url-scrapper-container' ).hide();
                return;
            }
            jQuery( '.bb-url-scrapper-loading' ).hide();
            if ( res.error == '' ) {
                jQuery( '#bb-url-error' ).hide();
                jQuery( '#bb-url-scrapper' ).show();
                bb_urlInUse = urlString;
                var imgSrc;
                var title = '';
                jQuery( '#bb-url-scrapper-description' ).text( '' );
                jQuery( '#bb-url-scrapper-description-hidden' ).val( '' );
                jQuery( '#bb-url-scrapper-title' ).text( '' );
                jQuery( '#bb-url-scrapper-title-hidden' ).val( '' );
                jQuery( '#bb-url-scrapper-url' ).text( '' );
                jQuery( '#bb-url-scrapper-url-hidden' ).val( '' );
                jQuery( '#bb-url-scrapper-img' ).css( 'backgroundImage', '' );
                bb_url_imgSrcArray = [ ];
                bb_url_imgArrayCounter = 0;
                title = res.title;
                jQuery( '#bb-url-scrapper-title' ).html( title );
                jQuery( '#bb-url-scrapper-title-hidden' ).val( title );
                jQuery( '#bb-url-scrapper-url' ).text( urlString );
                jQuery( '#bb-url-scrapper-url-hidden' ).val( urlString );
                jQuery( '#bb-url-scrapper-description' ).html( res.description );
                jQuery( '#bb-url-scrapper-description-hidden' ).val( res.description );
                jQuery.each( res.images, function ( index, value ) {
                    bb_url_imgSrcArray.push( value );
                } );
                // disable photo upload button if there is image available in posted link
                if (bb_url_imgSrcArray.length != 0) {
                    jQuery('#buddyboss-media-add-photo-button').prop('disabled', true);
                }
            } else {
                jQuery( '#bb-url-error' ).text( res.error );
                jQuery( '.bb-url-scrapper-container' ).hide();
                jQuery( '#bb-url-error' ).show();
            }

            jQuery( '#bb-url-scrapper-img' ).find( 'img' ).attr( 'src', bb_url_imgSrcArray[bb_url_imgArrayCounter] );
            jQuery( '#bb-url-scrapper-img-hidden' ).val( bb_url_imgSrcArray[bb_url_imgArrayCounter] );
            jQuery( '#bb-url-scrapper-img-count' ).text( '1 of ' + bb_url_imgSrcArray.length );
        }
    } )
}

function bb_is_valid_url( url ) {
    var regexp = /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    return regexp.test( url );
}

function bb_url_getUrl( prefix, urlText ) {
    var urlString = '';
    var startIndex = urlText.indexOf( prefix );
    for ( var i = startIndex; i < urlText.length; i ++ ) {
        if ( urlText[i] == ' ' || urlText[i] == '\n' )
            break;
        else
            urlString += urlText[i]
    }
    if ( prefix === 'www' ) {
        prefix = 'http://';
        urlString = prefix + urlString;
    }
    return urlString;
} // end -  fetch URL on activity