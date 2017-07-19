<?php
/**
 * Editor popup - General Animation View
 */

 
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;

$skin = isset( $_POST['skin'] ) ? sanitize_key( $_POST['skin'] ) : 'clean';
$action_type = isset( $_POST['_action_type'] ) ? sanitize_key( $_POST['_action_type'] ) : '';

ob_start();
?>
<table class="gwa-table">
    <tr>
        <td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Animations should be enabled globally first!', 'go_pricing_textdomain' ); ?></p></td>
    </tr>
</table>    
<div class="gwa-section"><span><?php _e( 'Transition', 'go_pricing_textdomain' ); ?></span></div>
<table class="gwa-table">
	<tr>
		<th><label><?php _e( 'Transition', 'go_pricing_textdomain' ); ?></label></th>
		<td>
			<select name="transition" data-preview="<?php esc_attr_e( 'Transition', 'go_pricing_textdomain' ); ?>">
				<?php 
				if ( !empty( $go_pricing['column-transition'] ) ) : 
				foreach ( (array)$go_pricing['column-transition'] as $col_trans ) :
				if ( !empty( $col_trans['group_name'] ) )	:
				?>
				<optgroup label="<?php echo esc_attr( $col_trans['group_name'] ); ?>"></optgroup>
				<?php 
				foreach ( (array)$col_trans['group_data'] as $col_trans_data ) :
				?>
				<option value="<?php echo esc_attr( !empty( $col_trans_data['value'] ) ? $col_trans_data['value'] : '' ); ?>"<?php echo ( !empty( $col_trans_data['value'] ) && !empty ( $postdata['transition'] ) && $col_trans_data['value'] == $postdata['transition'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $col_trans_data['name'] ) ? $col_trans_data['name'] : '' ); ?></option>
				<?php
				endforeach;
				else :
				?>
				<option value="<?php echo esc_attr( !empty( $col_trans['value'] ) ? $col_trans['value'] : '' ); ?>"<?php echo ( !empty( $col_trans['value'] ) && !empty ( $postdata['transition'] ) && $col_trans['value'] == $postdata['transition'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $col_trans['name'] ) ? $col_trans['name'] : '' ); ?></option>
				<?php 
				endif;
				endforeach;
				endif;
				?>
			</select>        
            
            
		</td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of column transition.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>
	<tr data-parent-id="transition" data-parent-value="*">
		<th><label><?php _e( 'Duration', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(ms)</span></label></th>
		<td><input type="text" name="trans[duration]" value="<?php echo esc_attr( isset( $postdata['trans']['duration'] ) ? (int)$postdata['trans']['duration'] : 500 ); ?>"></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Duration of the transition in milliseconds.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>        
	<tr data-parent-id="transition" data-parent-value="*">
		<th><label><?php _e( 'Delay', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(ms)</span></label></th>
		<td><input type="text" name="trans[delay]" value="<?php echo esc_attr( isset( $postdata['trans']['delay'] ) ? (int)$postdata['trans']['delay'] : 0 ); ?>"></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Initial delay before the transition starts in milliseconds.', 'go_pricing_textdomain' ); ?></p></td>
	</tr> 
	<tr data-parent-id="transition" data-parent-value="*">
		<th><label><?php _e( 'Easing', 'go_pricing_textdomain' ); ?></label></th>
		<td>
			<select name="trans[ease]">
				<?php 
				if ( !empty( $go_pricing['easing'] ) ) : 

				foreach ( (array)$go_pricing['easing'] as $easing ) : 
				?>			
				<option value="<?php echo esc_attr( !empty( $easing['value'] ) ? $easing['value'] : '' ); ?>"<?php echo ( !empty( $easing['value'] ) && !empty ( $postdata['trans']['ease'] ) && $easing['value'] == $postdata['trans']['ease'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $easing['name'] ) ? $easing['name'] : '' ); ?></option>
				<?php
				endforeach;
				endif;
				?>
			</select>
		</td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Easing type of the transition.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>																															
</table>
<div class="gwa-section"><span><?php _e( 'Price Counter', 'go_pricing_textdomain' ); ?></span></div>
<table class="gwa-table">
    <tr>
        <td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Please note, counter works only if you use "price" price type!', 'go_pricing_textdomain' ); ?></p></td>
    </tr>
	<tr>
		<th><label><?php _e( 'Enable Counter', 'go_pricing_textdomain' ); ?></label></th>
		<td><p><label><span class="gwa-checkbox<?php echo isset( $postdata['counter'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="counter" tabindex="-1" value="1" <?php echo isset( $postdata['counter'] ) ? ' checked="checked"' : ''; ?> data-preview="<?php _e( 'Price Counter', 'go_pricing_textdomain' ); ?>"></span></label></p></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable price counter.', 'go_pricing_textdomain' ); ?></p></td>		
	</tr>  
	<tr data-parent-id="counter" data-parent-value="on">
		<th><label><?php _e( 'Initial value', 'go_pricing_textdomain' ); ?></label></th>
		<td><input type="text" name="count[from]" value="<?php echo esc_attr( isset( $postdata['count']['from'] ) ? (int)$postdata['count']['from'] : 0 ); ?>"></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Initial value of counter the animation.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>
	<tr data-parent-id="counter" data-parent-value="on">
		<th><label><?php _e( 'Duration', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(ms)</span></label></th>
		<td><input type="text" name="count[duration]" value="<?php echo esc_attr( isset( $postdata['count']['duration'] ) ? (int)$postdata['count']['duration'] : 1000 ); ?>"></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Duration of the animation in milliseconds.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>        
	<tr data-parent-id="counter" data-parent-value="on">
		<th><label><?php _e( 'Delay', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(ms)</span></label></th>
		<td><input type="text" name="count[delay]" value="<?php echo esc_attr( isset( $postdata['count']['delay'] ) ? (int)$postdata['count']['delay'] : 0 ); ?>"></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Initial delay before the animation starts in milliseconds.', 'go_pricing_textdomain' ); ?></p></td>
	</tr> 
	<tr data-parent-id="counter" data-parent-value="on">
		<th><label><?php _e( 'Easing', 'go_pricing_textdomain' ); ?></label></th>
		<td>
			<select name="count[ease]">
				<?php 
				if ( !empty( $go_pricing['easing'] ) ) : 

				foreach ( (array)$go_pricing['easing'] as $easing ) : 
				?>			
				<option value="<?php echo esc_attr( !empty( $easing['value'] ) ? $easing['value'] : '' ); ?>"<?php echo ( !empty( $easing['value'] ) && !empty ( $postdata['count']['ease'] ) && $easing['value'] == $postdata['count']['ease'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $easing['name'] ) ? $easing['name'] : '' ); ?></option>
				<?php
				endforeach;
				endif;
				?>
			</select>
		</td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Easing type of the animation.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>																															
</table>

<?php
$content = ob_get_clean();
$content = apply_filters( "go_pricing_admin_editor_popup_{$action_type}_{$skin}", $content, ( !empty( $postdata ) ? $postdata : '' ) );
echo $content;
?>