<?php

// Get all the options from the database
global $options, $shortname;
$get_option = get_option($shortname);
foreach ($options as $value) {
    if (isset($value['id']) && get_option( $value['id'] ) === FALSE && isset($value['std'])) {
    	$$value['id'] = $value['std'];
    }
    elseif (isset($value['id'])) { $$value['id'] = get_option( $value['id'] ); }
}

?>