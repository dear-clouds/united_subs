<?php
/**
 * Editor popup - Header price view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;

$skin = isset( $_POST['skin'] ) ? sanitize_key( $_POST['skin'] ) : 'clean';
$action_type = isset( $_POST['_action_type'] ) ? sanitize_key( $_POST['_action_type'] ) : '';

ob_start();

// Define tabs
add_action( 'go_pricing_editor_popup_content_before_html', 'popup_tabs' );

function popup_tabs() {
	
	?>
	<div class="gwa-popup-tabs gwa-clearfix">
    	<div class="gwa-popup-tab gwa-current"><?php _e( 'General', 'go_pricing_textdomain' ); ?></div>
        <div class="gwa-popup-tab"><?php _e( 'Style', 'go_pricing_textdomain' ); ?></div>     
    </div>
    <?php
}

?>

<div class="gwa-popup-tab-contents">
	<div class="gwa-popup-tab-content gwa-current">
        <table class="gwa-table">							
            <tr>
                <th><label><?php _e( 'Price Type', 'go_pricing_textdomain' ); ?></label></th>
                <td>
                    <select name="type" data-title="type">
                        <option value="price"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'price' ? ' selected="selected"' : ''; ?>><?php _e( 'Price', 'go_pricing_textdomain' ); ?></option>
                        <option value="price-html"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'price-html' ? ' selected="selected"' : ''; ?>><?php _e( 'HTML Content', 'go_pricing_textdomain' ); ?></option>							
                    </select>							
                </td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the price.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
        </table>
		
        <div class="gwa-table-separator"></div>
        <!-- Price -->
        <table class="gwa-table" data-parent-id="type" data-parent-value="price"<?php echo !empty( $postdata['type'] ) && $postdata['type'] != 'price' ? ' style="display:none;"' : ''; ?>>																		
            <?php 
            $general_settings = get_option( self::$plugin_prefix . '_table_settings' );
            if ( !empty( $general_settings['currency'] ) ) :
            foreach( (array)$general_settings['currency'] as $currency_index => $currency_value ) : 
            ?>						
            <tr>
                <th><label><?php _e( 'Price', 'go_pricing_textdomain' ); ?></label> <span class="gwa-info"><?php echo !empty( $currency_value['currency'] ) ? sprintf( '(%s)', $currency_value['currency'] ) : ''; ?></span></th>
                <td><input type="text" name="price[0][amount][0]" value="<?php echo esc_attr( isset( $postdata['price'][0]['amount'][0] ) ?  $postdata['price'][0]['amount'][0] : '' ); ?>" data-preview="<?php esc_attr_e( sprintf( __( 'Price %s', 'go_pricing_textdomain' ) , !empty( $currency_value['currency'] ) ? sprintf( '(%s)', $currency_value['currency'] ) : '' ) ); ?>"></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Amount of the price.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
            <?php 
            endforeach;
            endif;
            ?>			
            <tr>
                <th><label><?php _e( 'Payment Name', 'go_pricing_textdomain' ); ?></label></th>
                <td><input type="text" name="price[0][name]" value="<?php echo esc_attr( isset( $postdata['price'][0]['name'] ) ? $postdata['price'][0]['name'] : '' ); ?>" data-preview="<?php _e( 'Payment', 'go_pricing_textdomain' ); ?>"></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Name of the payment e.g. "per month", "annual".', 'go_pricing_textdomain' ); ?></p></td>
            </tr>			
        </table>
        <!-- / Price -->
        
        <!-- HTML Content -->
        <table class="gwa-table" data-parent-id="type" data-parent-value="price-html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'price-html' ) ? ' style="display:none;"' : ''; ?>>
            <tr>
                <th><label><?php _e( 'Price Content', 'go_pricing_textdomain' ); ?></label></th>
                <td><div class="gwa-input-btn"><input type="text" name="price-html[content]" value="<?php echo isset( $postdata['price-html']['content'] ) ? esc_attr( $postdata['price-html']['content'] ) : ''; ?>" data-popup="sc-font-icon" data-preview="<?php _e( 'Price', 'go_pricing_textdomain' ); ?>"><a href="#"  data-action="popup" data-popup="sc-font-icon" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>"><i class="fa fa-code"></i></a></div></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Price content.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
            <tr>
                <th><label><?php _e( 'Payment Content', 'go_pricing_textdomain' ); ?></label></th>
                <td><div class="gwa-input-btn"><input type="text" name="payment[content]" value="<?php echo isset( $postdata['payment']['content'] ) ? esc_attr( $postdata['payment']['content'] ) : ''; ?>" data-popup="sc-font-icon" data-preview="<?php _e( 'Payment', 'go_pricing_textdomain' ); ?>"><a href="#" data-action="popup" data-popup="sc-font-icon" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>"><i class="fa fa-code"></i></a></div></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Payment content.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
        </table>			
        <!-- / HTML Content -->        
                
    </div>
	<div class="gwa-popup-tab-content">
        <div class="gwa-section"><span><?php _e( 'Price Style', 'go_pricing_textdomain' ); ?></span></div>
        <table class="gwa-table">
            <tr>
                <th><label><?php _e( 'Font Family', 'go_pricing_textdomain' ); ?></label></th>
                <td>
                    <select name="price-style[font-family]">
                        <?php 
                        foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
                        if ( !empty( $fonts['group_name'] ) )	:
                        ?>
                        <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
                        <?php 
                        foreach ( (array)$fonts['group_data'] as $font_data ) :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['price-style']['font-family'] ) && $font_data['value'] == $postdata['price-style']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
                        <?php
                        endforeach;
                        else :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['price-style']['font-family'] ) && $fonts['value'] == $postdata['price-style']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
                        <?php 
                        endif;
                        endforeach;
                        ?>
                    </select>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the price.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>		
            <tr>
                <th><label><?php _e( 'Font Size / Line H.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
                <td><input type="text" name="price-style[font-size]" value="<?php echo isset( $postdata['price-style']['font-size'] ) ? esc_attr( (int)$postdata['price-style']['font-size'] ) : 32; ?>" class="gwa-input-mid"><input type="text" name="price-style[line-height]" value="<?php echo isset( $postdata['price-style']['line-height'] ) ? esc_attr( (int)$postdata['price-style']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'go_pricing_textdomain' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['price-style']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="price-style[font-style][bold]" value="<?php echo !empty( $postdata['price-style']['font-style']['bold'] ) ? esc_attr( $postdata['price-style']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'go_pricing_textdomain' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['price-style']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="price-style[font-style][italic]" value="<?php echo !empty( $postdata['price-style']['font-style']['italic'] ) ? esc_attr( $postdata['price-style']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'go_pricing_textdomain' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['price-style']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="price-style[font-style][strikethrough]" value="<?php echo !empty( $postdata['price-style']['font-style']['strikethrough'] ) ? esc_attr( $postdata['price-style']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the price in pixels.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
        </table>
        <div class="gwa-section"><span><?php _e( 'Payment Style', 'go_pricing_textdomain' ); ?></span></div>		
        <table class="gwa-table">
            <tr>
                <th><label><?php _e( 'Font Family', 'go_pricing_textdomain' ); ?></label></th>
                <td>
                    <select name="payment[font-family]">
                        <?php 
                        foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
                        if ( !empty( $fonts['group_name'] ) )	:
                        ?>
                        <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
                        <?php 
                        foreach ( (array)$fonts['group_data'] as $font_data ) :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['payment']['font-family'] ) && $font_data['value'] == $postdata['payment']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
                        <?php
                        endforeach;
                        else :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['payment']['font-family'] ) && $fonts['value'] == $postdata['payment']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
                        <?php 
                        endif;
                        endforeach;
                        ?>
                    </select>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the payment.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>			
            <tr>
                <th><label><?php _e( 'Font Size / Line H.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
                <td><input type="text" name="payment[font-size]" value="<?php echo isset( $postdata['payment']['font-size'] ) ? esc_attr( (int)$postdata['payment']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="payment[line-height]" value="<?php echo isset( $postdata['payment']['line-height'] ) ? esc_attr( $postdata['payment']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'go_pricing_textdomain' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['payment']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="payment[font-style][bold]" value="<?php echo !empty( $postdata['payment']['font-style']['bold'] ) ? esc_attr( $postdata['payment']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'go_pricing_textdomain' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['payment']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="payment[font-style][italic]" value="<?php echo !empty( $postdata['payment']['font-style']['italic'] ) ? esc_attr( $postdata['payment']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'go_pricing_textdomain' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['payment']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="payment[font-style][strikethrough]" value="<?php echo !empty( $postdata['payment']['font-style']['strikethrough'] ) ? esc_attr( $postdata['payment']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the payment in pixels.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
        </table>   
    </div>
    
</div>    

<?php
$content = ob_get_clean();
$content = apply_filters( "go_pricing_admin_editor_popup_{$action_type}_{$skin}", $content, ( !empty( $postdata ) ? $postdata : '' ) );
echo $content;
?>