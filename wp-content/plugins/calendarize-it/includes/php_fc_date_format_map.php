<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

$php_fc_date_format_map = array(
	'd' => 'dd',
	'D' => 'ddd',
	'j' => 'd',
	'l' => 'dddd',
	'N' => '', //no corresponding format
	'S' => 'S',
	'w' => '',
	'z' => '',
	'W' => 'W',
	'F' => 'MMMM',
	'm' => 'MM',
	'M' => 'MMM',
	'n' => 'M',
	't' => '',
	'L' => '',
	'o' => 'yyyy',
	'Y' => 'yyyy',
	'y' => 'yy',
	'a' => 'tt',
	'A' => 'TT',
	'B' => '',
	'g' => 'h',
	'G' => 'H',
	'h' => 'hh',
	'H' => 'HH',
	'i' => 'mm',
	's' => 'ss',
	'u' => '',
	'e' => '',
	'I' => '',
	'O' => '',
	'P' => '',
	'T' => '',
	'Z' => '',
	'c' => '',
	'r' => '',
	'U' => ''
);

if(!function_exists('sort_by_length')):
function sort_by_length($val_a,$val_b){
	$a = strlen( $val_a );
	$b = strlen( $val_b );
	if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? 1 : -1;
}
endif;

uasort($php_fc_date_format_map, 'sort_by_length');


?>