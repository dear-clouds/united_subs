<?php
/**
 * Editor popup - Body row view
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

<!-- Type Selector -->
<table class="gwa-table">							
	<tr>
		<th><label><?php _e( 'Row Type', 'go_pricing_textdomain' ); ?></label></th>
		<td>
			<select name="type" data-title="type">
				<option value="html"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'html' ? ' selected="selected"' : ''; ?>><?php _e( 'HTML Content', 'go_pricing_textdomain' ); ?></option>
				<option value="button"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'button' ? ' selected="selected"' : ''; ?>><?php _e( 'Button', 'go_pricing_textdomain' ); ?></option>							
			</select>							
		</td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the row.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>
</table>
<div class="gwa-table-separator"></div>
<!-- / Type Selector -->

<div class="gwa-popup-tab-contents">
	
    <div class="gwa-popup-tab-content gwa-current">

     <!-- HTML Content -->
     <table class="gwa-table" data-parent-id="type" data-parent-value="html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'html' ) ? ' style="display:none;"' : ''; ?>>
        <tr class="gwa-row-fullwidth">
            <th><label><?php _e( 'Content', 'go_pricing_textdomain' ); ?></label></th>
            <td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><span class="gwa-textarea-align"><input type="hidden" name="html[text-align]" value="<?php echo !empty( $postdata['html']['text-align'] ) ? esc_attr( $postdata['html']['text-align'] ) : ''; ?>"><a href="#" data-align="left" title="<?php _e( 'Align Left', 'go_pricing_textdomain' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'left' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-left"></i></a><a href="#" data-align="" title="<?php _e( 'Align Center', 'go_pricing_textdomain' ); ?>" class="<?php echo empty( $postdata['html']['text-align'] ) ? 'gwa-current' : ''; ?>"><i class="fa fa-align-center"></i></a><a href="#" data-align="right" title="<?php _e( 'Align Right', 'go_pricing_textdomain' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'right' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-right"></i></a></span><a href="#" data-action="popup"  data-popup="sc-row-icon" data-preview-id="<?php echo esc_attr( !empty( $table_data['postid'] ) ? $table_data['postid'] : 0 ); ?>" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="html[content]" rows="5" data-popup="sc-row-icon" data-editor-height="180" data-editor-type="htmlmixed" data-preview="<?php esc_attr_e( 'Content', 'go_pricing_textdomain' ); ?>"><?php echo isset( $postdata['html']['content'] ) ? esc_textarea( $postdata['html']['content'] ) : '' ; ?></textarea></div></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Row content.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>
        <tr class="gwa-row-fullwidth">
	        <th><label><?php _e( 'Tooltip Content', 'go_pricing_textdomain' ); ?></label></th>
            <td><div class="gwa-textarea-code"><textarea name="html[tooltip][content]" rows="5" data-editor-height="180" data-editor-type="css"><?php echo isset( $postdata['html']['tooltip']['content'] ) ? esc_textarea( $postdata['html']['tooltip']['content'] ) : '' ; ?></textarea></div></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Tooltip content.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>
     </table>
	<!-- /HTML Content -->     

    <!-- Button -->
    <table class="gwa-table" data-parent-id="type" data-parent-value="button"<?php echo !empty( $postdata['type'] ) && $postdata['type'] != 'button' ? ' style="display:none;"' : ''; ?>>
        <?php include( 'part/button_general.php' ); ?>
    </table>
    <!-- / Button -->
    
    </div>
    
	<div class="gwa-popup-tab-content">    

         <!-- HTML Content -->
		<div class="gwa-section" data-parent-id="type" data-parent-value="html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'html' ) ? ' style="display:none;"' : ''; ?>><span><?php _e( 'Content Style', 'go_pricing_textdomain' ); ?></span></div>         
         <table class="gwa-table" data-parent-id="type" data-parent-value="html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'html' ) ? ' style="display:none;"' : ''; ?>>
            <tr>
                <th><label><?php _e( 'Font Family', 'go_pricing_textdomain' ); ?></label></th>
                <td>
                    <select name="html[font-family]">
                        <?php 
                        foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
                        if ( !empty( $fonts['group_name'] ) )	:
                        ?>
                        <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
                        <?php 
                        foreach ( (array)$fonts['group_data'] as $font_data ) :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['html']['font-family'] ) && $font_data['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
                        <?php
                        endforeach;
                        else :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['html']['font-family'] ) && $fonts['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
                        <?php 
                        endif;
                        endforeach;
                        ?>
                    </select>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the row content.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>							
            <tr>
                <th><label><?php _e( 'Font Size / Line H.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
                <td><input type="text" name="html[font-size]" value="<?php echo !empty( $postdata['html']['font-size'] ) ? esc_attr( $postdata['html']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="html[line-height]" value="<?php echo !empty( $postdata['html']['line-height'] ) ? esc_attr( $postdata['html']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'go_pricing_textdomain' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="html[font-style][bold]" value="<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? esc_attr( $postdata['html']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'go_pricing_textdomain' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="html[font-style][italic]" value="<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? esc_attr( $postdata['html']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'go_pricing_textdomain' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="html[font-style][strikethrough]" value="<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? esc_attr( $postdata['html']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the row content in pixels.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>
         </table>
        
        <div class="gwa-section" data-parent-id="type" data-parent-value="html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'html' ) ? ' style="display:none;"' : ''; ?>><span><?php _e( 'Tooltip Style', 'go_pricing_textdomain' ); ?></span></div>  
        <table class="gwa-table" data-parent-id="type" data-parent-value="html"<?php echo empty( $postdata['type'] ) || ( !empty( $postdata['type'] ) && $postdata['type'] != 'html' ) ? ' style="display:none;"' : ''; ?>>
            <tr>
                <th><label><?php _e( 'Font Family', 'go_pricing_textdomain' ); ?></label></th>
                <td>
                    <select name="html[tooltip][font-family]">
                        <?php 
                        foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
                        if ( !empty( $fonts['group_name'] ) )	:
                        ?>
                        <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
                        <?php 
                        foreach ( (array)$fonts['group_data'] as $font_data ) :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['html']['tooltip']['font-family'] ) && $font_data['value'] == $postdata['html']['tooltip']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
                        <?php
                        endforeach;
                        else :
                        ?>
                        <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['html']['tooltip']['font-family'] ) && $fonts['value'] == $postdata['html']['tooltip']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
                        <?php 
                        endif;
                        endforeach;
                        ?>
                    </select>
                <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the tooltip content.', 'go_pricing_textdomain' ); ?></p></td>
            </tr>							
            <tr>
                <th><label><?php _e( 'Font Size / Line H.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
                <td><input type="text" name="html[tooltip][font-size]" value="<?php echo !empty( $postdata['html']['tooltip']['font-size'] ) ? esc_attr( $postdata['html']['tooltip']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="html[tooltip][line-height]" value="<?php echo !empty( $postdata['html']['tooltip']['line-height'] ) ? esc_attr( $postdata['html']['tooltip']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'go_pricing_textdomain' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['html']['tooltip']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="html[tooltip][font-style][bold]" value="<?php echo !empty( $postdata['html']['tooltip']['font-style']['bold'] ) ? esc_attr( $postdata['html']['tooltip']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'go_pricing_textdomain' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['html']['tooltip']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="html[tooltip][font-style][italic]" value="<?php echo !empty( $postdata['html']['tooltip']['font-style']['italic'] ) ? esc_attr( $postdata['html']['tooltip']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'go_pricing_textdomain' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['html']['tooltip']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="html[tooltip][font-style][strikethrough]" value="<?php echo !empty( $postdata['html']['tooltip']['font-style']['strikethrough'] ) ? esc_attr( $postdata['html']['tooltip']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
            </tr>
        </table>         
        <!-- /HTML Content --> 
        
        <!-- Button -->
        <table class="gwa-table" data-parent-id="type" data-parent-value="button"<?php echo !empty( $postdata['type'] ) && $postdata['type'] != 'button' ? ' style="display:none;"' : ''; ?>>
            <?php include( 'part/button_style.php' ); ?>
        </table>
        <!-- / Button -->  
    
    </div>    
    
</div>

<?php
$content = ob_get_clean();
$content = apply_filters( "go_pricing_admin_editor_popup_{$action_type}_{$skin}", $content, ( !empty( $postdata ) ? $postdata : '' ) );
echo $content;
?>