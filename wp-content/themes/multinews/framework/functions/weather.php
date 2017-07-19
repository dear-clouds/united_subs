<?php
add_action( 'wp_ajax_mom_ajaxweather', 'momizat_weather' );  
add_action( 'wp_ajax_nopriv_mom_ajaxweather', 'momizat_weather');



function mom_isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}



function momizat_weather ($city, $units = 'metric', $date_format = 'm/d/Y', $lang = 'en', $display='', $days = 6) {
    $api_key = mom_option('weather_api_key');
if ($api_key == '') {
    //$api_key = '8cf2ffe6901005e706ec4e9c593588e2';
    echo __('Please Go to Theme options -> API\'s Authentication and add the weather API key');
    return;
}

if (isset($_COOKIE['lon']) && $_COOKIE['lon'] != '') {
    $lon = isset($_COOKIE['lon']) ? $_COOKIE['lon'] : '';
    $lat = isset($_COOKIE['lat']) ? $_COOKIE['lat'] : '';
} else {
    $lon = isset($_POST['lon']) ? $_POST['lon'] : '';
    $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
    if ($lat != '' && $lon != '') {
        if(function_exists('mom_setcookie')) {
            mom_setcookie('lat',$lat);
            mom_setcookie('lon',$lon);
        }
    }
}


$today_weather_data = get_transient('mom_weather_data_'.$city);
// Today Weather
$city_name = $city;
$city = str_replace(' ', '+', $city);

if (mom_option('automatic_weather') != 1) {
    $lat = ''; 
    $lon = '';
}
if ($lat != '' && $lon != '') {$today_weather_data = false;}
if ($today_weather_data == false) {

if ($lat != '' && $lon != '') {
    $today_weather_url = wp_remote_get('http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lon.'&units='.$units.'&lang='.$lang.'&appid='.$api_key);    
} else {
    $today_weather_url = wp_remote_get('http://api.openweathermap.org/data/2.5/weather?q='.$city.'&units='.$units.'&lang='.$lang.'&appid='.$api_key);
}


if (is_wp_error($today_weather_url)) return false;

$today_weather_data = json_decode( $today_weather_url['body'], true);
set_transient('mom_weather_data_'.$city, $today_weather_data, 3600 );
}

$code = $today_weather_data['cod'];
if ($code != 404) { 

$today_temp = (int)$today_weather_data['main']['temp'];
$today_icon = $today_weather_data['weather'][0]['icon'];

$this_day = date($date_format);
$today_date =  date("m/d/Y");
$x = '';
if ($units == 'metric') {
    $x = '&#8451;';
} elseif ($units == 'imperial') {
    $x = '&#8457;';
}
$base_cloud = '<i class="basecloud"></i>';
switch ($today_icon) {
    case '01d':
        $today_icon_class = 'icon-sun';
        $base_cloud = '';
    break;

    case '01n':
        $today_icon_class = 'icon-moon';
        $base_cloud = '';
    break;
    case '02d':
        $today_icon_class = 'icon-sunny';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;

    case '02n':
        $today_icon_class = 'icon-night';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;
    case '03d':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '';
    break;

    case '03n':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '';
    break;
    case '04d':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;

    case '04n':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;
    case '09d':
        $today_icon_class = 'icon-drizzle icon-sunny';
    break;

    case '09n':
        $today_icon_class = 'icon-drizzle icon-night';
    break;

    case '10d':
        $today_icon_class = 'icon-rainy icon-sunny';
    break;

    case '10n':
        $today_icon_class = 'icon-rainy icon-night';
    break;

    case '11d':
        $today_icon_class = 'icon-thunder icon-sunny';
    break;

    case '11n':
        $today_icon_class = 'icon-thunder icon-night';
    break;

    case '13d':
        $today_icon_class = 'icon-snowy icon-sunny';
    break;

    case '13n':
        $today_icon_class = 'icon-snowy icon-night';
    break;
    
    case '50d':
        $today_icon_class = 'icon-mist';
        $base_cloud = '';
    break;

    case '50n':
        $today_icon_class = 'icon-mist';
        $base_cloud = '';
    break;
}
?>
                            

                            <div class="weather-widget">
                                <div class="first-weather">
                                    <div class="weather-data">
                                        <h2><?php 
                                        if ($lat != '' && $lon != '') { 
                                                echo isset($today_weather_data['name'])? $today_weather_data['name'] : __('Your Location', 'theme');
                                        } else { if ($display != ''){ 
                                            echo $display; } else { echo $city_name; } 
                                        } ?></h2>
                                        <div class="weather-date"><span><?php _e('Today', 'framework'); ?></span><?php echo $this_day; ?></div>
                                    </div>
                                    <div class="weather-result">
                                        <div class="weather-icon">
                                            <?php echo $base_cloud; ?>
                                        <i class="<?php echo $today_icon_class; ?>"></i></div>
                                        <span><?php echo $today_temp.$x; ?></span>
                                    </div>
                                </div>
                                <?php

                                if ($lat != '' && $lon != '') {
                                $daily_weather_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$lat.'&lon='.$lon.'&mode=xml&units='.$units.'&cnt='.($days+1).'&lang='.$lang.'&appid='.$api_key;
                                } else {
                                    $daily_weather_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q='.$city.'&mode=xml&units='.$units.'&cnt='.($days+1).'&lang='.$lang.'&appid='.$api_key;
                                }
                                $daily_weather_data = wp_remote_get($daily_weather_url);
                                if (! is_wp_error($daily_weather_data)) {
                                $daily_weather_data = wp_remote_retrieve_body($daily_weather_data);
                                if (!mom_isJson($daily_weather_data)) {
                                $daily_weather_data = simplexml_load_string($daily_weather_data);

                                $count = 0;
                                $i = 1;

                                foreach ( $daily_weather_data->forecast->time as $day ) {
                                    if($count++ < 1) continue ;
$today = new DateTime($today_date);
$date = $today->add(new DateInterval('P'.$i.'D'));

                                    $desc = $day->symbol['name']; 
                                    $icon = $day->symbol['var'];
                                    $clouds = $day->clouds['all'].$day->clouds['unit'];
                                    $humidity = $day->humidity['value'].$day->humidity['unit'];
                                    $wind = $day->windSpeed['mps'];
                                    $wind_dir = $day->windDirection['code'];
                                    $min_temp = (int)$day->temperature['min'];
                                    $max_temp = (int)$day->temperature['max'];
                                    $pressure = (int)$day->pressure['value'].$day->pressure['unit'];
                                    $base_cloud = '<i class="basecloud"></i>';
switch ($icon) {
    case '01d':
        $icon_class = 'icon-sun';
        $base_cloud = '';
    break;

    case '01n':
        $icon_class = 'icon-moon';
        $base_cloud = '';
    break;
    case '02d':
        $icon_class = 'icon-sunny';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;

    case '02n':
        $icon_class = 'icon-night';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;
    case '03d':
        $icon_class = 'icon-cloud';
        $base_cloud = '';
    break;

    case '03n':
        $icon_class = 'icon-cloud';
        $base_cloud = '';
    break;
    case '04d':
        $icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;

    case '04n':
        $icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;
    case '09d':
        $icon_class = 'icon-drizzle icon-sunny';
    break;

    case '09n':
        $icon_class = 'icon-drizzle icon-night';
    break;

    case '10d':
        $icon_class = 'icon-rainy icon-sunny';
    break;

    case '10n':
        $icon_class = 'icon-rainy icon-night';
    break;

    case '11d':
        $icon_class = 'icon-thunder icon-sunny';
    break;

    case '11n':
        $icon_class = 'icon-thunder icon-night';
    break;

    case '13d':
        $icon_class = 'icon-snowy icon-sunny';
    break;

    case '13n':
        $icon_class = 'icon-snowy icon-night';
    break;
    
    case '50d':
        $icon_class = 'icon-mist';
        $base_cloud = '';
    break;

    case '50n':
        $icon_class = 'icon-mist';
        $base_cloud = '';
    break;
}

switch ($date->format('D')) {
    case 'Fri':
        $d_print = __('Fri', 'framework');
    break;
    case 'Sat':
        $d_print = __('Sat', 'framework');
    break;
    case 'Sun':
        $d_print = __('Sun', 'framework');
    break;
    case 'Mon':
        $d_print = __('Mon', 'framework');
    break;
    case 'Tue':
        $d_print = __('Tue', 'framework');
    break;
    case 'Wed':
        $d_print = __('Wed', 'framework');
    break;
    case 'Thu':
        $d_print = __('Thu', 'framework');
    break;
}
?>
                                <div class="w-item-wrap w-item-closed">
                                    <h4 class="w-item-title">
                                        <span class="w-item-day"><?php echo $d_print; ?></span>
                                        <div class="time"><?php echo $date->format($date_format); ?></div>
                                        <span class="w-item-status"><?php echo $desc; ?></span>
                                        <div class="weather-icon">
                                            <?php echo $base_cloud; ?>
                                        <i class="<?php echo $icon_class; ?>"></i></div>
                                        <div class="t-ic"><i></i></div>
                                    </h4>
                                    <div class="w-item-content">
                                        <ul class="w-co-w">
                                            <li class="w-status"><span><?php echo $desc; ?></span></li>
                                            <li><span><?php _e('HI/LO:', 'framework'); ?> </span><?php echo $max_temp; ?>/<?php echo $min_temp; ?></li>
                                            <li><span><?php _e('Clouds:', 'framework'); ?> </span><?php echo $clouds; ?></li>
                                            <li><span><?php _e('Wind:', 'framework'); ?> </span><?php echo $wind; ?> <?php _e('m/s', 'framework'); ?></li>
                                            <li><span><?php _e('Wind Direction:', 'framework'); ?> </span><?php echo $wind_dir; ?></li>
                                            <li><span><?php _e('Pressure:', 'framework'); ?> </span> <?php echo $pressure; ?></li>
                                            <li><span><?php _e('Humidity:', 'framework'); ?> </span><?php echo $humidity; ?></li>
                                        </ul>
                                    </div>
                                </div>                                        
                                <?php $i++; } 
                            } //end if not json

                            } // end if not error?>
                            </div>
<?php
if (isset($_POST['lon']) && isset($_POST['lat'])) {
    exit();    
}

} //cod not = 404
}



// Weather Page
function mom_weather_page($city,$units = 'metric', $date_format = 'm/d/Y', $lang = 'en', $display='') {
wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('mom-weather', get_template_directory_uri() . '/js/weather.js', array('jquery'), '1.0', true);

    $api_key = mom_option('weather_api_key');
if ($api_key == '') {
    //$api_key = '8cf2ffe6901005e706ec4e9c593588e2';
    echo __('Please Go to Theme options -> API\'s Authentication and add the weather API key');
    return;
}



if (isset($_COOKIE['lon']) && $_COOKIE['lon'] != '') {
    $lon = isset($_COOKIE['lon']) ? $_COOKIE['lon'] : '';
    $lat = isset($_COOKIE['lat']) ? $_COOKIE['lat'] : '';
} else {
    $lon = isset($_POST['lon']) ? $_POST['lon'] : '';
    $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
    if ($lat != '' && $lon != '') {
        if(function_exists('mom_setcookie')) {
            mom_setcookie('lat',$lat);
            mom_setcookie('lon',$lon);
        }
    }
}

if (mom_option('automatic_weather') != 1) {
    $lat = ''; 
    $lon = '';
}
// Today Weather
if ($lat != '' && $lon != '') {
    $today_weather_url_orig = 'http://api.openweathermap.org/data/2.5/weather?mode=xml&lat='.$lat.'&lon='.$lon.'&units='.$units.'&lang='.$lang.'&appid='.$api_key;
    $daily_weather_url_orig = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$lat.'&lon='.$lon.'&mode=xml&units='.$units.'&lang='.$lang.'&appid='.$api_key.'&cnt=7';
} else {
    $today_weather_url_orig = 'http://api.openweathermap.org/data/2.5/weather?mode=xml&q='.$city.'&units='.$units.'&lang='.$lang.'&appid='.$api_key;
    $daily_weather_url_orig = 'http://api.openweathermap.org/data/2.5/forecast/daily?q='.$city.'&mode=xml&units='.$units.'&lang='.$lang.'&appid='.$api_key.'&cnt=7';
}

if (isset($_POST['location']) && $_POST['location'] != '') {
    $city = $_POST['location'];
}
$city = str_replace(' ', '+', $city);
if (isset($_POST['units']) && $_POST['units'] != '') {
    $units = $_POST['units'];
    if ($units == 'on') {
        $units = 'metric';
    }
} 
if ($lat != '' && $lon != '' && !isset($_POST['location'])) {
    $today_weather_url = 'http://api.openweathermap.org/data/2.5/weather?mode=xml&lat='.$lat.'&lon='.$lon.'&units='.$units.'&lang='.$lang.'&appid='.$api_key;
} else {
    $today_weather_url = 'http://api.openweathermap.org/data/2.5/weather?mode=xml&q='.$city.'&units='.$units.'&lang='.$lang.'&appid='.$api_key;
}
$today_weather_data = wp_remote_get($today_weather_url);
if($today_weather_data===FALSE) {
$today_weather_data = wp_remote_get($today_weather_url_orig);
}
$today_weather_data = wp_remote_retrieve_body($today_weather_data);

$today_temp = '';
$today_icon = '';
$city_name = '';
$today_desc = '';
$today_date = '';
$this_day = '';
if (!mom_isJson($today_weather_data)) {
$today_weather_data = simplexml_load_string($today_weather_data);

$today_weather = $today_weather_data;
if ($display == '') {
$city_name = $today_weather->city['name'];
} else {
    $city_name = $display;
}
if (isset($_POST['location']) && $_POST['location'] != '') {
    $city_name = $today_weather->city['name'];
}
$today_temp = (int)$today_weather->temperature['value'];
$today_icon = $today_weather->weather['icon'];
$today_desc = $today_weather->weather['value']; 

$this_day = date($date_format);
$today_date =  date("m/d/Y");
}

$x = '';
$selected_c = '';
$selected_f = '';
if ($units == 'metric') {
    $x = '&#8451;';
    $selected_c = 'selected';
} elseif ($units == 'imperial') {
    $x = '&#8457;'; 
    $selected_f = 'selected';
}
$base_cloud = '<i class="basecloud"></i>';
switch ($today_icon) {
    case '01d':
        $today_icon_class = 'icon-sun';
        $base_cloud = '';
    break;

    case '01n':
        $today_icon_class = 'icon-moon';
        $base_cloud = '';
    break;
    case '02d':
        $today_icon_class = 'icon-sunny';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;

    case '02n':
        $today_icon_class = 'icon-night';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;
    case '03d':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '';
    break;

    case '03n':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '';
    break;
    case '04d':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;

    case '04n':
        $today_icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;
    case '09d':
        $today_icon_class = 'icon-drizzle icon-sunny';
    break;

    case '09n':
        $today_icon_class = 'icon-drizzle icon-night';
    break;

    case '10d':
        $today_icon_class = 'icon-rainy icon-sunny';
    break;

    case '10n':
        $today_icon_class = 'icon-rainy icon-night';
    break;

    case '11d':
        $today_icon_class = 'icon-thunder icon-sunny';
    break;

    case '11n':
        $today_icon_class = 'icon-thunder icon-night';
    break;

    case '13d':
        $today_icon_class = 'icon-snowy icon-sunny';
    break;

    case '13n':
        $today_icon_class = 'icon-snowy icon-night';
    break;
    
    case '50d':
        $today_icon_class = 'icon-mist';
        $base_cloud = '';
    break;

    case '50n':
        $today_icon_class = 'icon-mist';
        $base_cloud = '';
    break;
}
if ($lat != '' && $lon != '' && !isset($_POST['location'])) {
    $daily_weather_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?lat='.$lat.'&lon='.$lon.'&mode=xml&units='.$units.'&cnt=7&lang='.$lang.'&appid='.$api_key;
} else {
    $daily_weather_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q='.$city.'&mode=xml&units='.$units.'&cnt=7&lang='.$lang.'&appid='.$api_key;    
}

$daily_weather_data = wp_remote_get($daily_weather_url);
if($daily_weather_data===FALSE) {
$daily_weather_data = wp_remote_get($daily_weather_url_orig);
$val_class = '';
$invalid_input = 'invalid';
} else {
    $val_class ="hidden";
    $invalid_input = '';
}
$daily_weather_data = wp_remote_retrieve_body($daily_weather_data);
if (!mom_isJson($daily_weather_data)) {
$daily_weather_data = simplexml_load_string($daily_weather_data);


global $post;
$weaherbg = get_post_meta($post->ID, 'mom_we_bg_img', true);
$icon = get_post_meta($post->ID, 'mom_page_icon', true);
?>
    <section class="weather-page-wrap" style="<?php if($weaherbg != '') { ?>background:url(<?php echo $weaherbg; ?>) no-repeat center;<?php } else { ?>background: url(<?php echo MOM_IMG ?>/image-bg3.jpg) no-repeat center;<?php } ?>">
        <div class="inner">
                
                <div class="weather-page-icon">
                		<?php if($icon != '') { ?>
				        <span class="<?php echo $icon; ?>"></span>
				        <?php } else { ?>
                        <span class="brankic-icon-cloudy"></span>	
                        <?php } ?>
                </div>
                <div class="weather-page-head">
                        <h2><?php _e('Weather', 'framework'); ?></h2>
                        <div class="weather-switch-tabs">
                            <form action="<?php the_permalink(); ?>" method="post" id="units-form">
                                <label class="w-unit <?php echo $selected_f; ?>">°F <input type="radio" value="imperial" name="units"></label>
                                <label class="w-unit <?php echo $selected_c; ?>">°C <input type="radio" value="metric" name="units"></label>
                            </form>
                        </div>
                </div>
                <div class="weather-data-wrap">
                    <span class="not-valid-city <?php echo $val_class; ?>"><?php _e('Not found', 'framework'); ?><i class="brankic-icon-error"></i></span>
                     <div class="today-weather-box">
                        <div class="t-w-title">
                                <h2><?php if ($display != ''){ echo $display; } else { echo $city_name; } ?></h2>
                                <div class="weather-date"><span></span><?php echo $this_day; ?></div>
                        </div>
                        <div class="weather-results">
                                <div class="weather-results-status"><?php echo $today_desc; ?></div>
                                <div class="weather-icon">
                                            <?php echo $base_cloud; ?>
                                        <i class="<?php echo $today_icon_class; ?>"></i>
                                </div>
                                <span><?php echo $today_temp.$x; ?></span>
                        </div>
                </div>
                    
                <div class="week-weather-wrap">
                <ul class="week-weather-box">
                                <?php
                                $count = 0;
                                $i = 1;
                                foreach ( $daily_weather_data->forecast->time as $day ) {
                                    if($count++ < 1) continue ;

$today = new DateTime($today_date);
$date = $today->add(new DateInterval('P'.$i.'D'));

                                    $desc = $day->symbol['name']; 
                                    $icon = $day->symbol['var'];
                                    $clouds = $day->clouds['all'].$day->clouds['unit'];
                                    $humidity = $day->humidity['value'].$day->humidity['unit'];
                                    $wind = $day->windSpeed['mps'];
                                    $wind_dir = $day->windDirection['code'];
                                    $min_temp = (int)$day->temperature['min'];
                                    $max_temp = (int)$day->temperature['max'];
                                    $pressure = (int)$day->pressure['value'].$day->pressure['unit'];
                                    $base_cloud = '<i class="basecloud"></i>';
switch ($icon) {
    case '01d':
        $icon_class = 'icon-sun';
        $base_cloud = '';
    break;

    case '01n':
        $icon_class = 'icon-moon';
        $base_cloud = '';
    break;
    case '02d':
        $icon_class = 'icon-sunny';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;

    case '02n':
        $icon_class = 'icon-night';
        $base_cloud = '<i class="icon-cloud"></i>';
    break;
    case '03d':
        $icon_class = 'icon-cloud';
        $base_cloud = '';
    break;

    case '03n':
        $icon_class = 'icon-cloud';
        $base_cloud = '';
    break;
    case '04d':
        $icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;

    case '04n':
        $icon_class = 'icon-cloud';
        $base_cloud = '<i class="icon-cloud behind"></i>';
    break;
    case '09d':
        $icon_class = 'icon-drizzle icon-sunny';
    break;

    case '09n':
        $icon_class = 'icon-drizzle icon-night';
    break;

    case '10d':
        $icon_class = 'icon-rainy icon-sunny';
    break;

    case '10n':
        $icon_class = 'icon-rainy icon-night';
    break;

    case '11d':
        $icon_class = 'icon-thunder icon-sunny';
    break;

    case '11n':
        $icon_class = 'icon-thunder icon-night';
    break;

    case '13d':
        $icon_class = 'icon-snowy icon-sunny';
    break;

    case '13n':
        $icon_class = 'icon-snowy icon-night';
    break;
    
    case '50d':
        $icon_class = 'icon-mist';
        $base_cloud = '';
    break;

    case '50n':
        $icon_class = 'icon-mist';
        $base_cloud = '';
    break;
}
switch ($date->format('D')) {
    case 'Fri':
        $d_print = __('Fri', 'framework');
    break;
    case 'Sat':
        $d_print = __('Sat', 'framework');
    break;
    case 'Sun':
        $d_print = __('Sun', 'framework');
    break;
    case 'Mon':
        $d_print = __('Mon', 'framework');
    break;
    case 'Tue':
        $d_print = __('Tue', 'framework');
    break;
    case 'Wed':
        $d_print = __('Wed', 'framework');
    break;
    case 'Thu':
        $d_print = __('Thu', 'framework');
    break;
}
?>
                     <li>
                                <div class="t-w-title">
                                        <h2><?php echo $d_print; ?></h2>
                                        <div class="weather-date"><?php echo $date->format($date_format); ?></div>
                                </div>
                                <div class="weather-results">
                                        <div class="weather-results-status"><?php echo $desc; ?></div>
                                        <div class="weather-icon">
                                            <?php echo $base_cloud; ?>
                                            <i class="<?php echo $icon_class; ?>"></i>
                                        </div>
                                        <span><?php echo $max_temp.$x; ?></span>
                                        <small><?php echo $min_temp.$x; ?></small>
                                </div>
                        </li>
                        <?php  $i++; } ?>
                </ul>
                
                <div class="find-weather-box">
                        <span><?php _e('Find a Forecast', 'theme'); ?></span>
                        <form action="<?php the_permalink(); ?>" method="post" id="find-weather">
                             <input type="text" name="location" id="locator-form-search"  class="<?php echo $invalid_input; ?>" value="" placeholder="<?php _e('Search for a location' , 'theme'); ?>" title="<?php _e('Search for a location' , 'framework'); ?>" maxlength="75"></span>
                       </form>
                </div>
                </div> <!--week weather wrap-->
</div> <!--weather data wrap-->
        </div>
</section>
<?php 
    } //end if the xml not json error 
}