<?php
function mom_youtube_covtime($youtube_time){
    preg_match_all('/(\d+)/',$youtube_time,$parts);

    // Put in zeros if we have less than 3 numbers.
    if (count($parts[0]) == 1) {
        array_unshift($parts[0], "0", "0");
    } elseif (count($parts[0]) == 2) {
        array_unshift($parts[0], "0");
    }

    $sec_init = isset($parts[0][2]) ? $parts[0][2] : '';
    $seconds = $sec_init%60;
    $seconds_overflow = floor($sec_init/60);

    $min_init = isset($parts[0][1]) ? $parts[0][1]: '';
    $min_init += $seconds_overflow;
    $minutes = ($min_init)%60;
    $minutes_overflow = floor(($min_init)/60);

    $hours = isset($parts[0][0]) ? $parts[0][0] : '';
    $hours += $minutes_overflow;

    if($hours != 0)
        return $hours.':'.$minutes.':'.$seconds;
    else
        return $minutes.':'.$seconds;
}   

// Yotube video duration
function mom_youtube_duration ($id) {
   delete_option('mom_yotube3_video_duration_'.$id);
    $key = mom_option('youtube_api_key');
if ($key != '') {
$duration =  get_transient('mom_yotube3_video_duration_'.$id);
$duration = 0;
$data = wp_remote_get('https://www.googleapis.com/youtube/v3/videos?id='.$id.'&part=contentDetails&key='.$key);
    if (!is_wp_error($data)) {
                $json = json_decode( $data['body'], true );
		          $duration = isset($json['items'][0]['contentDetails']['duration']) ? $json['items'][0]['contentDetails']['duration'] : '';
                  $duration = mom_youtube_covtime($duration);
                set_transient('mom_yotube3_video_duration_'.$id, $duration, 60*60*24);
    return $duration;
    } else {
        return 'error';
    }
} else {
    return false;
}
    
}

// Vimeo video duration
function mom_vimeo_duration ($id) {
   //delete_option('mom_yotube_video_duration_'.$id);
$x = "H:i:s";
$duration =  get_transient('mom_vimeo_video_duration_'.$id);
if (false !== $duration) {
if ($duration < 3600) { $x = "i:s";}
    return gmdate($x, $duration);
}

$duration = 0;
$data = wp_remote_get('http://vimeo.com/api/v2/video/'.$id.'.json');
    if (!is_wp_error($data)) {
                $json = json_decode( $data['body'], true );
		$duration = intval($json[0]['duration']);
                if ($duration < 3600) { $x = "i:s";}
                set_transient('mom_vimeo_video_duration_'.$id, $duration, 60*60*24);
    return gmdate($x, $duration);
    } else {
        return 'error';
    }
    
}
