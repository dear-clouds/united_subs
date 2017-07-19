<?php
/**
 * Editor popup - General Layout & Style view
 */

 
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;

$skin = isset( $_POST['skin'] ) ? sanitize_key( $_POST['skin'] ) : 'clean';
$action_type = isset( $_POST['_action_type'] ) ? sanitize_key( $_POST['_action_type'] ) : '';

ob_start();
?>

<?php if ( $skin == 'clean') : ?>
<div class="gwa-section"><span><?php _e( 'Layout Settings', 'go_pricing_textdomain' ); ?></span></div>
<?php endif; ?>
<table class="gwa-table">
    <tr>
        <th><label><?php _e( 'Highlight Column?', 'go_pricing_textdomain' ); ?></label></th>
        <td><p><label><span class="gwa-checkbox<?php echo !empty( $postdata['highlight'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="highlight" tabindex="-1" value="1" <?php echo !empty( $postdata['highlight'] ) ? ' checked="checked"' : ''; ?> data-preview="<?php _e( 'Highlighted', 'go_pricing_textdomain' ); ?>"></span></label></p></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable hover / active state of the column.', 'go_pricing_textdomain' ); ?></p></td>									
    </tr>										
    <tr>
        <th><label><?php _e( 'Disable Hover?', 'go_pricing_textdomain' ); ?></label></th>
        <td><p><label><span class="gwa-checkbox<?php echo !empty( $postdata['disable-hover'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-hover" tabindex="-1" value="1" <?php echo !empty( $postdata['disable-hover'] ) ? ' checked="checked"' : ''; ?> data-preview="<?php _e( 'Disable Hover', 'go_pricing_textdomain' ); ?>"></span></label></p></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to disable hover / active state of the column.', 'go_pricing_textdomain' ); ?></p></td>									
    </tr>
    <tr>
        <th><label><?php _e( 'Disable Enlarge?', 'go_pricing_textdomain' ); ?></label></th>
        <td><p><label><span class="gwa-checkbox<?php echo !empty( $postdata['disable-enlarge'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-enlarge" tabindex="-1" value="1" <?php echo !empty( $postdata['disable-enlarge'] ) ? ' checked="checked"' : ''; ?> data-preview="<?php _e( 'Disable Enlarge', 'go_pricing_textdomain' ); ?>"></span></label></p></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to disable enlarge effect on column hover / highlight.', 'go_pricing_textdomain' ); ?></p></td>									
    </tr>																						
</table>
<?php if ( $skin == 'clean') : ?>
<div class="gwa-table-separator"></div>
<div class="gwa-section"><span><?php _e( 'Style Settings', 'go_pricing_textdomain' ); ?></span></div>
<table class="gwa-table">
    <tr>
        <th><label><?php _e( 'Main Color', 'go_pricing_textdomain' ); ?></label></th>
        <td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="main-color" value="<?php echo esc_attr( isset( $postdata['main-color'] ) ? $postdata['main-color'] : '' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $postdata['main-color'] ) ? ' style="background:' . $postdata['main-color'] . ';"' : '' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $postdata['main-color'] ) ? $postdata['main-color'] : '&nbsp;' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $postdata['main-color'] ) ? $postdata['main-color'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Main color of the pricing table.', 'go_pricing_textdomain' ); ?></p></td>
    </tr>
</table>
<?php endif; ?>

<?php
$content = ob_get_clean();
$content = apply_filters( "go_pricing_admin_editor_popup_{$action_type}_{$skin}", $content, ( !empty( $postdata ) ? $postdata : '' ) );
echo $content;
?>

