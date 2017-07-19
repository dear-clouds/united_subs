/* global confirm, redux, redux_change */

/*global redux_change, redux*/

( function ( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || { };
    redux.field_objects.custom_image_select = redux.field_objects.custom_image_select || { };

    $( document ).ready(
        function () {
            //redux.field_objects.custom_image_select.init();
        }
    );

    redux.field_objects.custom_image_select.init = function ( selector ) {

        if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-custom_image_select:visible' );
        }

        $( selector ).each(
            function () {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }
                // On label click, change the input and class
                el.find( '.redux-image-select label img, .redux-image-select label .tiles' ).click(
                    function ( e ) {
                        var id = $( this ).closest( 'label' ).attr( 'for' );

                        /**
                         * unset name of boss_scheme_select hidden input before importing color preset to avoid submit multiple value of the color set
                         * the one from selected radio and another is hidden boss_scheme_select input field
                         */
                        $('input[type="hidden"][name="boss_options[boss_scheme_select]"]').attr( 'name', '' );

                        $( this ).parents( "fieldset:first" ).find( '.redux-image-select-selected' ).removeClass( 'redux-image-select-selected' ).find( "input[type='radio']" ).attr(
                            "checked", false
                            );
                        $( this ).closest( 'label' ).find( 'input[type="radio"]' ).prop( 'checked' );

                        if ( $( this ).closest( 'label' ).hasClass( 'redux-image-select-preset-' + id ) ) { // If they clicked on a preset, import!
                            e.preventDefault();

                            var presets = $( this ).closest( 'label' ).find( 'input' );
                            var data = presets.data( 'presets' );
                            var merge = presets.data( 'merge' );

                            if ( merge !== undefined && merge !== null ) {
                                if ( $.type( merge ) === 'string' ) {
                                    merge = merge.split( '|' );
                                }

                                $.each( data, function ( index, value ) {
                                    if ( ( merge === true || $.inArray( index, merge ) != -1 ) && $.type( redux.options[index] ) === 'object' ) {
                                        data[index] = $.extend( redux.options[index], data[index] );
                                    }
                                } );
                            }

                            if ( presets !== undefined && presets !== null ) {

                                var parentElem = $( this ).parents( '.redux-main' );

                                if ( parentElem.find( '.bb-confirm-dialog-wrapper' ).length === 0 ) {
                                    parentElem.append( '<div class="bb-confirm-dialog-wrapper"><div class="bb-confirm-dialog-overlay"></div><div class="bb-confirm-dialog">Your current options will be replaced with the values of this preset. Would you like to proceed? <div class="bb-button-wrap"><button class="bb-confirm button button-primary" type="button" data-action="confirm">Yes</button><button class="bb-cancel button" type="button" data-action="cancel">Cancel</button></div></div></div>' );
                                }

                                $( document ).on( 'click', '.bb-button-wrap .button', function () {

                                    var action = $( this ).data( 'action' );
                                    $( '.bb-confirm-dialog-wrapper' ).remove();

                                    if ( action === 'confirm' ) {
                                        el.find( 'label[for="' + id + '"]' ).addClass( 'redux-image-select-selected' ).find( "input[type='radio']" ).attr( "checked", true );
                                        if ( $( '#import-code-value' ).length === 0 ) {
                                            $( this ).append( '<textarea id="import-code-value" style="display:none;" name="' + redux.args.opt_name + '[import_code]">' + JSON.stringify( data ) + '</textarea>' );
                                        } else {
                                            $( '#import-code-value' ).val( JSON.stringify( data ) );
                                        }
                                        if ( $( '#publishing-action #publish' ).length !== 0 ) {
                                            $( '#publish' ).click();
                                        } else {
                                            $( '#redux-import' ).click();
                                        }
                                    } else {

                                    }

                                } );

                            } else {
                            }

                            return false;
                        } else {
                            el.find( 'label[for="' + id + '"]' ).addClass( 'redux-image-select-selected' ).find( "input[type='radio']" ).attr(
                                "checked", true
                                ).trigger( 'change' );

                            redux_change( $( this ).closest( 'label' ).find( 'input[type="radio"]' ) );
                        }
                    }
                );

                // Used to display a full image preview of a tile/pattern
                el.find( '.tiles' ).qtip(
                    {
                        content: {
                            text: function ( event, api ) {
                                return "<img src='" + $( this ).attr( 'rel' ) + "' style='max-width:150px;' alt='' />";
                            },
                        },
                        style: 'qtip-tipsy',
                        position: {
                            my: 'top center', // Position my top left...
                            at: 'bottom center', // at the bottom right of...
                        }
                    }
                );
            }
        );

    };
} )( jQuery );