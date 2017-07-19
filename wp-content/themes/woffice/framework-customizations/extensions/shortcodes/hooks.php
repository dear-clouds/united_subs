<?php if (!defined('FW')) die('Forbidden');

/** @internal */
function _filter_disable_shortcodes($to_disable)
{
	$to_disable[] = 'team_member';
	$to_disable[] = 'widget_area';
	$to_disable[] = 'button';
	$to_disable[] = 'special_heading';
	$to_disable[] = 'contact_form';
	$to_disable[] = 'notification';
	$to_disable[] = 'calendar';
	$to_disable[] = 'call_to_action';
	$to_disable[] = 'form';
	return $to_disable;
}
add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_disable_shortcodes');