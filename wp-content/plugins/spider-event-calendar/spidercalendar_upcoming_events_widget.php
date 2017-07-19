<?php
$firtstime=1;
add_action( 'wp_print_scripts', 'cal_scripts' );

function  cal_scripts(){
  global $wd_spider_calendar_version;
  wp_enqueue_script("Calendar", plugins_url("elements/calendar.js", __FILE__), array(), $wd_spider_calendar_version, FALSE);
  wp_enqueue_script("calendar-setup", plugins_url("elements/calendar-setup.js", __FILE__), array(), $wd_spider_calendar_version, FALSE);
  wp_enqueue_script("calendar_function", plugins_url("elements/calendar_function.js", __FILE__), array(), $wd_spider_calendar_version, FALSE);
  wp_enqueue_style("Css", plugins_url("elements/calendar-jos.css", __FILE__), array(), $wd_spider_calendar_version, FALSE);
  wp_enqueue_script('wp-color-picker');
  wp_enqueue_style( 'wp-color-picker' );
}

if (!class_exists('WP_Widget')) {
  return;
}

class upcoming_events extends WP_Widget {
  // Constructor //
  function __construct() {
    $widget_ops = array(
      'classname' => 'upcoming_events',
      'description' => ''
    );
    $control_ops = array('id_base' => 'upcoming_events'); // Widget Control Settings.
    parent::__construct('upcoming_events', 'Upcoming Events', $widget_ops, $control_ops); // Create the widget.
  }

  // Extract Args //
  function widget($args, $instance) {
	  if(empty($instance)){
		      $instance = array(
			  'title' => 'Upcoming events',
			  'calendar' => '0',
			  'theme' => '0',
			  'view_type' => '0',
			  'event_qauntity1' => '1',
			  'follow_quality1' => '10',
			  'follow_quality3' => '10',
			  'event_qauntity2' => '1',
			  'ordering' => '0',
			  'event_qauntity22' => '1',
			  'ordering1' => '0',
			  'event_select' => '',
			  'start_date' => '',
			  'starting' => '0',
			  'follow_quality2' => '10',
			  'event_qauntity3' => '1',
			  'event_date' => '1',
			  'repeat_rate' => '1',
			  'numbering' => '1',
			  'ev_text' => '1',
			  'width' => '200',
			  'bg_color' => 'FFFFFF',
			  'title_color' => '000000',
			  'title_size' => '14',
			  'title_font' => 'Arial',
			  'date_color' => '000000',
			  'date_format' => 'd F Y',
			  'repeat_color' => '000000',
			  'text_color' => '000000',
			  'divider_color' => 'C2C2C2',
			);
	  }
    extract($args);
    $title = $instance['title'];
    $calendar_id = $instance['calendar'];
	$view_type = $instance['view_type'];
	$theme_id = (($instance['theme']) ? $instance['theme'] : 1);
    $event_from_current_day = $instance['event_qauntity1'];
    $since = $instance['follow_quality1'];
	$since1 = $instance['follow_quality3'];
	$count = $instance['event_qauntity2'];
	$count1 = $instance['event_qauntity22'];
	$ordering = $instance['ordering'];
	$ordering1 = $instance['ordering1'];
	$event_select = $instance['event_select'];
	$start_day_calendar = $instance['start_date'];
	$event_from_day_interval = $instance['starting'];
	$follow_quality2 = $instance['follow_quality2'];
	$event_qauntity3 = $instance['event_qauntity3'];
	
	$show_time = $instance['event_date'];
	$show_repeat = $instance['repeat_rate'];
	$show_numbering = $instance['numbering'];
	$show_eventtext = $instance['ev_text'];
	
	$width = $instance['width'];
	$bg_color = $instance['bg_color'];
	$title_color = $instance['title_color'];
	$title_size = $instance['title_size'];
	$title_font = $instance['title_font'];
	$date_color = $instance['date_color'];
	$date_format = $instance['date_format'];
	$repeat_color = $instance['repeat_color'];
	$text_color = $instance['text_color'];
	$divider_color = $instance['divider_color'];
	
    
    // Before widget //
    echo $before_widget;
    // Title of widget //
    if ($title) {
      echo $before_title . $title . $after_title;
    }
    // Widget output //
    
global $wpdb;

  $many_sp_calendar = ((isset($_GET['many_sp_calendar']) && is_numeric(esc_html($_GET['many_sp_calendar']))) ? esc_html($_GET['many_sp_calendar']) : rand(10, 10000));
  ?>
  <script>

var thickDims, tbWidth, tbHeight;
        jQuery(document).ready(function ($) {
          thickDims = function () {
            var tbWindow = $('#TB_window'), H = $(window).height(), W = $(window).width(), w, h;
            if (tbWidth) {
              if (tbWidth < (W - 90)) w = tbWidth; else  w = W - 200;
            } 
			else w = W - 200;
            if (tbHeight) {
              if (tbHeight < (H - 90)) h = tbHeight; else  h = H - 200;
            } else h = H - 200;
            if (tbWindow.size()) {
              tbWindow.width(w).height(h);
			  
              $('#TB_iframeContent').width(w).height(h - 27);
	
			  tbWindow.css({'margin-left':'-' + parseInt((w / 2), 10) + 'px'});
			  
			   if (typeof document.body.style.maxWidth != 'undefined')
                tbWindow.css({'top':(H - h) / 2, 'margin-top':'0'});
				
            }
			  
			 if(jQuery(window).width() < 640 ){
			 var tb_left = parseInt((w / 2), 10) + 20;
			 
			  tbWindow.css({'left':'' + tb_left + 'px'});
			  jQuery('#TB_window').css('width','91%');
			  jQuery('#TB_window').css('height','80%');
				jQuery('#TB_window').css('margin-top','-10%');
				jQuery('#TB_window iframe').css('width','100%');
				jQuery('#TB_window iframe').css('height','87%');
				
			   }
             
          };
          thickDims();
          $(window).resize(function () {
            thickDims()
          });

          $('a.thickbox-preview<?php echo $many_sp_calendar?>').click(function () {
	
            tb_click.call(this);
            var alink = jQuery(this).parents('.available-theme').find('.activatelink'), link = '', href = jQuery(this).attr('href'), url, text;
            var reg_with = new RegExp(xx_cal_xx + "tbWidth=[0-9]+");
	
            if (tbWidth = href.match(reg_with))
              tbWidth = parseInt(tbWidth[0].replace(/[^0-9]+/g, ''), 10);
            else
              tbWidth = jQuery(window).width() - 90;
			 
			
			  
            var reg_heght = new RegExp(xx_cal_xx + "tbHeight=[0-9]+");
            if (tbHeight = href.match(reg_heght))
              tbHeight = parseInt(tbHeight[0].replace(/[^0-9]+/g, ''), 10);
            else
              tbHeight = jQuery(window).height() - 60;
            jQuery('#TB_title').css({'background-color':'#222', 'color':'#dfdfdf'});
            jQuery('#TB_closeAjaxWindow').css({'float':'left'});
            jQuery('#TB_ajaxWindowTitle').css({'float':'right'}).html(link);
            jQuery('#TB_iframeContent').width('100%');
            thickDims();
            return false;
          });
        });

</script>
  
  <?php
  
  
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 1);
  
$query="SELECT popup_width,popup_height FROM " . $wpdb->prefix . "spidercalendar_widget_theme WHERE id=".$theme_id;
$popup_w_hs= $wpdb->get_results($query);

$popup_w_h = array(
    0 => $popup_w_hs[0]->popup_width,
    1 => $popup_w_hs[0]->popup_height,
);

$popup_width = $popup_w_h[0];
$popup_height = $popup_w_h[1];

$cal= strtotime($start_day_calendar);

$id = $this->get_field_id('title');
global $callone;
$callone=$callone+1;

if($callone==1)
{
function compare_str_to_array($string,$array,$end_date)
{

	foreach($array as $value)
	{
		if($string<=$value and $end_date>=$value)
		{
			return $value;
			break;
		}

	}


}


function compare_str_to_array1($string,$array)
{

	foreach($array as $value)
	{
		if($string<=$value)
		{
			return $value;
			break;
		}

	}


}


function week_number_recent($x) {
  if ($x == 1) {
    return __('First', 'sp_calendar');
  }
  elseif ($x == 8) {
    return __('Second', 'sp_calendar');
  }
  elseif ($x == 15) {
    return __('Third', 'sp_calendar');
  }
  elseif ($x == 22) {
    return __('Fourth', 'sp_calendar');
  }
  elseif ($x == 'last') {
    return __('Last', 'sp_calendar');
  }
}


 function week_convert_recent($x)

 {
  if ($x == 'Mon') {
    return __('Monday', 'sp_calendar');
  }
  elseif ($x == 'Tue') {
    return __('Tuesday', 'sp_calendar');
  }
  elseif ($x == 'Wed') {
    return __('Wednesday', 'sp_calendar');
  }
  elseif ($x == 'Thu') {
    return __('Thursday', 'sp_calendar');
  }
  elseif ($x == 'Fri') {
    return __('Friday', 'sp_calendar');
  }
  elseif ($x == 'Sat') {
    return __('Saturday', 'sp_calendar');
  }
  elseif ($x == 'Sun') {
    return __('Sunday', 'sp_calendar');
  }
}


function sorrt($st_date,$array,$en_date)
{
$ids=array();
$dat=array();
$dats=array();
$ret_array=array();
foreach($array as $key=>$value)
{
$ids[]=$key;
$dat[]=compare_str_to_array($st_date,$value,$en_date);
$dats[]=$value;
}

asort($dat);

foreach($dat as $key=>$val)
{
$ret_array[$ids[$key]]=$dats[$key];
}

return $ret_array;

}

function sorrt1($st_date,$array)
{
$ids=array();
$dat=array();
$dats=array();
$ret_array=array();
foreach($array as $key=>$value)
{
$ids[]=$key;
$dat[]=compare_str_to_array1($st_date,$value);
$dats[]=$value;
}

asort($dat);

foreach($dat as $key=>$val)
{
$ret_array[$ids[$key]]=$dats[$key];
}

return $ret_array;

}

function add_00($str)
{

	if(strlen($str)==1)
		return '0'.$str;
	else
		return $str;


}

function num_to_str($x)
{
switch($x)
{
case '1':
return 'first';
break;

case '8':
return 'second';
break;

case '15':
return 'third';
break;

case '22':
return 'Fourth';
break;

case 'last':
return 'last';
break;


}


}
}
$id = $this->get_field_id('title');
?>

<style type="text/css">

#event_repeat<?php echo $id?>{
color:#<?php echo str_replace('#','',$repeat_color); ?>;
padding-top:14px;
<?php if($show_eventtext==1){?>
padding-bottom:14px!important;

<?php }?>

}
#event_table<?php echo $id?>{

border:0px !important;
border-spacing:0px !important;
border-collapse:collapse;

}

#event_text<?php echo $id?>{
padding:15px;
color:#<?php echo str_replace('#','',$text_color); ?>;
padding-bottom:14px!important;
<?php if($show_repeat==1) {?>
padding-top:14px!important;
<?php } ?>
padding-left: 8px;
} 


#event_date<?php echo $id?>
{
color:#<?php echo str_replace('#','',$date_color); ?>;
<?php if($show_eventtext==1){?>
padding-bottom:14px!important;
<?php } ?>
<?php if($show_repeat==1){?>
padding-bottom:14px!important;
<?php } ?>
}



#title<?php echo $id?>:link,
#see_more<?php echo $id?>
{
font-size:<?php echo $title_size?>px;
font-family:<?php echo $title_font?>;
color:#<?php echo str_replace('#','',$title_color); ?> !important;
text-decoration:none;

}

#title<?php echo $id?>:hover{
background:none ;
text-decoration:underline ;

}



 tr, td{
 border:0px;
 padding-left:7px;
 padding-right:12px;
padding-bottom:4px;
padding-top:2px;
 }
 #divider<?php echo $id?>
 {
 background-color:#<?php echo str_replace('#','',$instance['divider_color']); ?>;
 border:none; 
 height:1px;
 }

.pad
{
<?php if($show_time==1){?>
padding-bottom:14px;
<?php } ?>
}

.module<?php echo $id?>
{
background-color:#<?php echo str_replace('#','',$bg_color);?>;
width:<?php echo $width?>px;
border:1px ;
border-radius:8px;
-moz-border-radius: 8px;
 -webkit-border-radius: 8px;
padding-right:10px;
padding-left:10px;
border:2px solid #6A6A6A;;

}
 
</style>



<?php
$query1= "SELECT * FROM " . $wpdb->prefix . "spidercalendar_event WHERE published='1' LIMIT 0,".$event_from_current_day;
$rows = $wpdb->get_results($query1);


 $daysarray = array();

foreach($rows as $row)
{

  if($row -> date_end!='0000-00-00')
  {
$Startdate = $row->date;
$Enddate = $row->date_end ;


$ts1 = strtotime($Startdate);
$ts2 = strtotime($Enddate);


$seconds_diff = ($ts2 - $ts1);


$day_diff = floor($seconds_diff/3600/24+1);


for($i=0; $i<$day_diff; $i+=$row->repeat)
{
$Nextdate = strtotime(date("Y-m-d", strtotime($row->date)) . " +".$i." day");

$Nextdate =  date("Y-m-d",$Nextdate);
 array_push($daysarray,$Nextdate);
 
}


$weekdays = explode(',',$row->week);
$weekdays= array_slice($weekdays,0,count($weekdays)-1);
}

 }


echo '<div class="module'.$id.'">';

 if($view_type==0)
{
	$query="SELECT * FROM   " . $wpdb->prefix . "spidercalendar_event WHERE calendar=".$calendar_id."  AND published='1'  ORDER BY date";	
$evs = $wpdb->get_results($query);

$st_date=date('Y-m-d');
$dates=array();
foreach($evs as $ev)
{
$weekdays_start=array();
$st=$ev->date;
if($ev->date_end!='0000-00-00')
$en=$ev->date_end;
else
$en=date('Y-m-d', strtotime('+24 year', strtotime($st)));

$date_st=explode('-',$st);

$date_end=explode('-',$en);

$st_d= mktime(0, 0, 0,  $date_st[1],  $date_st[2], $date_st[0]);
$en_d = mktime(0, 0, 0,  $date_end[1],  $date_end[2], $date_end[0]);
$tarb=$en_d-$st_d;

$weekly_array=explode(',',$ev->week);
		for($j=0; $j<=6;$j++)
					{
						if( in_array(date("D", mktime(0, 0, 0, $date_st[1], $date_st[2]+$j, $date_st[0])),$weekly_array))
						{	
						
						$weekdays_start[]=$date_st[2]+$j;}
											
					}


					
if($ev->repeat_method=="no_repeat")
{
$dates[$ev->id][0]=$ev->date;
}					

///////////////////get days for daily repeat 
if($ev->repeat_method=="daily")
{	
if($ev->repeat=="" || $ev->repeat=="0")
$ev->repeat = "1";

if($tarb<=0)
$day_count=((($st_d-$en_d)/3600)/24)/($ev->repeat);
else
$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat);

$dates[$ev->id][0]=$ev->date;
for($i=0;$i<$day_count;$i++)
	{
	if($ev->repeat_method=="daily")
	$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' day', strtotime($dates[$ev->id][$i])));
	}
}
///////////////////get days for weekly repeat 
if($ev->repeat_method=="weekly")
{

$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat*7);

$d=array();
$dat=array();
for($j=0;$j<count($weekdays_start);$j++)
	{

	unset($dat);
	$dat[0]=$date_st[0].'-'.$date_st[1].'-'.add_00($weekdays_start[$j]);

		
		for($i=0;$i<$day_count-1;$i++)
			{
				$dat[]=date('Y-m-d', strtotime('+'.($ev->repeat).' week', strtotime($dat[$i])));
			}
			
	
			$d=array_merge($d,$dat);
	}	

sort($d);
		$dates[$ev->id]=$d;
}	

///////////////////get days for monthly repeat 
if($ev->repeat_method=="monthly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$month_count = 0;

while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
    $month_count++;
}

$month_days = date('t',mktime(0, 0, 0, $date_st[1], 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
				
					}
												
				}
			}
			
			
	}
	
			for($i=0;$i<$month_count;$i++)
			{
				$mon=date('F', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				
				date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));

				if($ev->month_type==1)
				$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				else
				{
				$mon=date('F', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));				
				$dates[$ev->id][]=date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));	
				}
			}
	
	

}


if($ev->repeat_method=="yearly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$year_count = 0;

while (($min_date = strtotime("+1 year", $min_date)) <= $max_date) {
    $year_count++;
}

$month_days = date('t',mktime(0, 0, 0, add_00($ev->year_month), 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
				
					}
												
				}
			}
			
			
	}
	
			for($i=0;$i<$year_count;$i++)
			{


				if($ev->month_type==1)
				$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));
				else
				{
				$mon=date('F', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));				
				$dates[$ev->id][]=date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));	
				}
			}
	
	

}


sort($dates[$ev->id]);
}

foreach($dates as $ev_id=>$date )
{
//echo compare_str_to_array($st_date,$date,$en_date). ' ';

$gag[$ev_id]=compare_str_to_array1($st_date,$date);
}

$dates=sorrt1($st_date,$dates);


$isk=1;	
$j=0;	

$p=0;

foreach($dates as $ev_id=>$date)
{

	$query0=" SELECT * FROM   " . $wpdb->prefix . "spidercalendar_event WHERE id=".$ev_id;				
	$curr_event = $wpdb->get_row($query0);

	if(compare_str_to_array1($st_date,$date)=='')
	continue;

$event_id = $curr_event->id;
$event_title = $curr_event->title;

$event_date =  compare_str_to_array1($st_date,$date);
$event_end_date = $curr_event->date_end;
$event_text = $curr_event->text_for_date;
$calendar_id = $curr_event->calendar;
$repeat = $curr_event->repeat;
$week=explode(',',$curr_event->week);


$year=substr($event_date,0,4);
$month=substr($event_date,5,-3);
$day=substr($event_date,8);

/*$month_date_year = date("F j, Y",mktime(0,0,0,$month,$day,$year));
$jd=gregoriantojd($month,$day,$year);
$weekday = jddayofweek($jd,2);
$date = $weekday.' '.$month_date_year; 
echo $weekday;*/
echo '<div id="event_table'.$id.'" >';
if($show_numbering==1) 
{
echo '<div style="padding-top:0px;" class="pad"><a id="title'.$id.'"  class="thickbox-preview' . $many_sp_calendar . '"   
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
							  'calendar_id' => $id,
                              'theme_id' => $theme_id,
                              'eventID' => $ev_id,
							  'widget' => $widget,							  
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '"
 ></br><b>'. $isk++.'.'.$event_title.'</b></a></div>';

}
else
{
echo '<div style="padding-top:0px;" class="pad"><a id="title'.$id.'" class="thickbox-preview' . $many_sp_calendar . '"
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
							  'calendar_id' => $id,
                              'theme_id' => $theme_id,
                              'eventID' => $ev_id,
							  'widget' => $widget,
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" ></br><b>'.$event_title.'</b></a></div>';

}	

?>

<style>
<?php if($event_text==''){?>
td #event_date<?php echo $id?> 
{
padding-bottom:14px;

} 
<?php }?>
</style>

<?php
$activedatestr = '';
$date_format_array = explode(' ', $date_format);

for ($i = 0; $i < count($date_format_array); $i++) {
    $activedatestr .= __(date("" . $date_format_array[$i] . "", strtotime($event_date)), 'sp_calendar') . ' ';
  }

if($show_time==1)
echo '<div id="event_date'.$id.'">'.$activedatestr.'</div>';


if($show_repeat==1)
{
if($event_text=='')
{if($curr_event->repeat_method=="no_repeat")
echo '';
else
{
echo '<div id="event_repeat'.$id.'" >';

	if($curr_event->repeat_method=='daily')
	echo '<div >'.__('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Day', 'sp_calendar') . '</div>';

		if($curr_event->repeat_method=='weekly')

		{

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Week(s) on', 'sp_calendar') . '</br>';

		for ($g=0;$g<count($week);$g++) 

		{

			if($week[$g]!=''){

				if($g!=count($week)-2)

					echo week_convert_recent($week[$g]).',';

				else

					echo week_convert_recent($week[$g]);

			

			}

			

		}

		echo '</div>';

		}

		if($curr_event->repeat_method=='monthly' and $curr_event->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Month(s) on the', 'sp_calendar') . ' '.$curr_event->month.'</div>';	

		if($curr_event->repeat_method=='monthly' and $curr_event->month_type==2)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' '.$repeat.' ' . __('Month(s) on the', 'sp_calendar') . ' '.week_number_recent($curr_event->monthly_list).' '.week_convert_recent($curr_event->month_week).'</div>';



		if($curr_event->repeat_method=='yearly' and $curr_event->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$curr_event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.$curr_event->month.'</div>';	



		if($curr_event->repeat_method=='yearly' and $curr_event->month_type==2)

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$curr_event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.week_number_recent($curr_event->monthly_list).' '.week_convert_recent($curr_event->month_week).'</div>';		






echo '</div>';	
}

}
else
{
if($curr_event->repeat_method=="no_repeat")
echo '';
else
{
echo '<div id="event_repeat'.$id.'" >';

	if($curr_event->repeat_method=='daily')
	echo '<div >'.__('Repeat Every', 'sp_calendar').' '.$repeat.' ' . __('Day', 'sp_calendar') . '</div>';

		if($curr_event->repeat_method=='weekly')

		{

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Week(s) on', 'sp_calendar') . ' : ';

		for ($g=0;$g<count($week);$g++) 

		{

			if($week[$g]!=''){

				if($g!=count($week)-2)

					echo week_convert_recent($week[$g]).',';

				else

					echo week_convert_recent($week[$g]);

			

			}

			

		}

		echo '</div>';

		}

		if($curr_event->repeat_method=='monthly' and $curr_event->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' '.$repeat.' ' . __('Month(s) on the', 'sp_calendar') . ' '.$curr_event->month.'</div>';	



		if($curr_event->repeat_method=='monthly' and $curr_event->month_type==2)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' '.$repeat.' ' . __('Month(s) on the', 'sp_calendar') . ' '.week_number_recent($curr_event->monthly_list).' '.week_convert_recent($curr_event->month_week).'</div>';



		if($curr_event->repeat_method=='yearly' and $curr_event->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$curr_event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.$curr_event->month.'</div>';	



		if($curr_event->repeat_method=='yearly' and $curr_event->month_type==2)

		echo '<div >'. __('Repeat Every', 'sp_calendar').' '.$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$curr_event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.week_number_recent($curr_event->monthly_list).' '.week_convert_recent($curr_event->month_week).'</div>';		






echo '</div>';	
}
}
}
if($show_eventtext==1)
{
if($event_text)
{
//$length = strlen($event_text);
$text = mb_substr(html_entity_decode(strip_tags($event_text)), 0, 50);

echo '<div id="event_text'.$id.'" style="padding-bottom:14px;">'.$text;

echo '<br><a class="thickbox-preview' . $many_sp_calendar . '"    id="see_more'.$id.'" style="text-decoration:none;"
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,						  
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" >'. __('See more', 'sp_calendar').'</a></div>';


}
}



echo '<hr id="divider'.$id.'"/>';
$j++;
echo'</div>';


$p++;
if($p==$event_from_current_day)
break;
}
}

if($view_type==1)
{
if($event_from_day_interval==0)		
{			
$st_date=date('Y-m-d');
$en_date=date('Y-m-d', strtotime('+'.$since.' day', strtotime($st_date)));
if($ordering==0)
$order="ORDER BY date";
else
$order="ORDER BY RAND()";

$limit=$count;
}
else
{
$st_date=$start_day_calendar;
$en_date=date('Y-m-d', strtotime('+'.$since1.' day', strtotime($st_date)));
if($ordering1==0)
$order="ORDER BY date";
else
$order="ORDER BY RAND()";
$limit=$count1;
}

$query=" SELECT * FROM   " . $wpdb->prefix . "spidercalendar_event WHERE calendar= ".$calendar_id."  AND  published='1' ".$order;	
$evs= $wpdb->get_results($query);
$dates=array();
foreach($evs as $ev)
{
$weekdays_start=array();
$st=$ev->date;
if($ev->date_end!='0000-00-00' AND $ev->date_end!='')
{
$en=$ev->date_end;

}
else
{
$en=date('Y-m-d', strtotime('+24 year', strtotime($st)));

}
$date_st=explode('-',$st);

$date_end=explode('-',$en);


$st_d= mktime(0, 0, 0,  $date_st[1],  $date_st[2], $date_st[0]);
$en_d = mktime(0, 0, 0,  $date_end[1],  $date_end[2], $date_end[0]);
$tarb=$en_d-$st_d;
$weekly_array=explode(',',$ev->week);
		for($j=0; $j<=6;$j++)
					{
						if( in_array(date("D", mktime(0, 0, 0, $date_st[1], $date_st[2]+$j, $date_st[0])),$weekly_array))
						{	
						
						$weekdays_start[]=$date_st[2]+$j;}
							
					}


					
if($ev->repeat_method=="no_repeat")
{
$dates[$ev->id][0]=$ev->date;
}					

///////////////////get days for daily repeat 
if($ev->repeat_method=="daily")
{
if($ev->repeat=="" || $ev->repeat=="0")
$ev->repeat = "1";

if($tarb<=0)
$day_count=((($st_d-$en_d)/3600)/24)/($ev->repeat);
else
$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat);

$dates[$ev->id][0]=$ev->date;
for($i=0;$i<$day_count;$i++)
	{
	if($ev->repeat_method=="daily")
	$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' day', strtotime($dates[$ev->id][$i])));
	}
}
///////////////////get days for weekly repeat 
if($ev->repeat_method=="weekly")
{
$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat*7);

$d=array();
$dat=array();
for($j=0;$j<count($weekdays_start);$j++)
	{

	unset($dat);
	$dat[0]=$date_st[0].'-'.$date_st[1].'-'.add_00($weekdays_start[$j]);

		
		for($i=0;$i<$day_count-1;$i++)
			{
				$dat[]=date('Y-m-d', strtotime('+'.($ev->repeat).' week', strtotime($dat[$i])));
			}
			
	
			$d=array_merge($d,$dat);
	}	

sort($d);
		$dates[$ev->id]=$d;
}	

///////////////////get days for monthly repeat 
if($ev->repeat_method=="monthly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$month_count = 0;

while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
    $month_count++;
}

$month_days = date('t',mktime(0, 0, 0, $date_st[1], 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
				
					}
												
				}
			}
			
			
	}
	
			for($i=0;$i<$month_count;$i++)
			{
				$mon=date('F', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				
				date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));

				if($ev->month_type==1)
				$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				else
				{
				$mon=date('F', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' month', strtotime($dates[$ev->id][$i])));				
				$dates[$ev->id][]=date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));	
				}
			}
	
	

}


if($ev->repeat_method=="yearly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$year_count = 0;

while (($min_date = strtotime("+1 year", $min_date)) <= $max_date) {
    $year_count++;
}

$month_days = date('t',mktime(0, 0, 0, add_00($ev->year_month), 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
				
					}
												
				}
			}
			
			
	}
	
			for($i=0;$i<$year_count;$i++)
			{


				if($ev->month_type==1)
				$dates[$ev->id][]=date('Y-m-d', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));
				else
				{
				$mon=date('F', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));
				$year=date('Y', strtotime('+'.($ev->repeat).' year', strtotime($dates[$ev->id][$i])));				
				$dates[$ev->id][]=date('Y-m-d', strtotime(''.num_to_str($ev->monthly_list).' '.$ev->month_week.' of '.$mon.' '.$year.''));	
				}
			}
	
	

}


sort($dates[$ev->id]);

}


foreach($dates as $ev_id=>$date )
{
//echo compare_str_to_array($st_date,$date,$en_date). ' ';

$gag[$ev_id]=compare_str_to_array($st_date,$date,$en_date);
}

if($ordering==0 or $ordering1==0)
$dates=sorrt($st_date,$dates,$en_date);



$isk=1;	
$j=0;	

$p=0;


foreach($dates as $ev_id=>$date)
{

if(compare_str_to_array($st_date,$date,$en_date)=='')
	continue;

if(compare_str_to_array($st_date,$date,$en_date)!='')
{
	
	$query0=" SELECT * FROM   " . $wpdb->prefix . "spidercalendar_event WHERE id=".$ev_id;				
	$curr_event1 = $wpdb->get_results($query0);
	$order_event_current_day=$curr_event1[0];
	
   $event_id = $order_event_current_day->id; 
   $event_title = $order_event_current_day->title;
   $event_date =compare_str_to_array($st_date,$date,$en_date);
   $event_end_date = $order_event_current_day->date_end;
   $event_text = $order_event_current_day->text_for_date;
   $calendar_id = $order_event_current_day->calendar;
   $repeat = $order_event_current_day->repeat;
   
   $year=substr($event_date,0,4);
   $month=substr($event_date,5,-3);
   $day=substr($event_date,8);
   
   
  
		$week=explode(',',$order_event_current_day->week);

		
   echo '<div id="event_table'.$id.'" >';
 if($show_numbering==1) 
{
echo '<div style="padding-top:14px;" class="pad"><a id= "title'.$id.'"  class="thickbox-preview' . $many_sp_calendar . '"   
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,							  
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" ><b>'. $isk++.'.'.$event_title.'</b></a></div>';
}
else
{
echo '<div style="padding-top:14px;" class="pad" ><a id="title'.$id.'" class="thickbox-preview' . $many_sp_calendar . '"   
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,							  
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" ><b>'.$event_title.'</b></a></div>';
}
	
?>

<style>
<?php if($event_text==''){?>
td #event_date<?php echo $id?> 
{
padding-bottom:14px;

} 
<?php }?>
</style>

<?php

$activedatestr = '';
$date_format_array = explode(' ', $date_format);

for ($i = 0; $i < count($date_format_array); $i++) {
    $activedatestr .= __(date("" . $date_format_array[$i] . "", strtotime($event_date)), 'sp_calendar') . ' ';
  }

if($show_time==1)
echo '<div id="event_date'.$id.'">'.__($activedatestr, 'sp_calendar').'</div>';

if($show_repeat==1)
{

if($order_event_current_day->repeat_method=="no_repeat")
echo '';
else
{
echo '<div id="event_repeat'.$id.'" >';

	if($order_event_current_day->repeat_method=='daily')
	echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Day', 'sp_calendar') . '</div>';

		if($order_event_current_day->repeat_method=='weekly')

		{

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Week(s) on', 'sp_calendar') . ' : ';

		for ($g=0;$g<count($week);$g++) 

		{

			if($week[$g]!=''){

				if($g!=count($week)-2)

					echo week_convert_recent($week[$g]).',';

				else

					echo week_convert_recent($week[$g]);

			

			}

			

		}

		echo '</div>';

		}

		if($order_event_current_day->repeat_method=='monthly' and $order_event_current_day->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '. __('Month(s) on the', 'sp_calendar').' '.$order_event_current_day->month.'</div>';	



		if($order_event_current_day->repeat_method=='monthly' and $order_event_current_day->month_type==2)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' '.$repeat.' '. __('Month(s) on the', 'sp_calendar').' '.week_number_recent($order_event_current_day->monthly_list).' '.week_convert_recent($order_event_current_day->month_week).'</div>';



		if($order_event_current_day->repeat_method=='yearly' and $order_event_current_day->month_type==1)

		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$order_event_current_day->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.$order_event_current_day->month.'</div>';	



		if($order_event_current_day->repeat_method=='yearly' and $order_event_current_day->month_type==2)

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$order_event_current_day->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.week_number_recent($order_event_current_day->monthly_list).' '.week_convert_recent($order_event_current_day->month_week).'</div>';		






echo '</div>';	
}


}
if($show_eventtext==1)
{

if($event_text)
{
$text = mb_substr(html_entity_decode(strip_tags($event_text)), 0, 50);

echo '<div id="event_text'.$id.'" >'.$text;
echo '<br><a class="thickbox-preview' . $many_sp_calendar . '"    id="see_more'.$id.'" style="text-decoration:none;"
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" >'. __('See more', 'sp_calendar').'</a></div>';

}
}


echo '<div style="padding-top:6px"><hr id="divider'.$id.'"/></div>';
$j++;
echo'</div>';
}

$p++;
if($p==$limit)
break;
}


}
 
 if($view_type==2){
$events_id=explode(',',$event_select);
	
				$events_id= array_slice($events_id,1, count($events_id)-2);
		

if(!empty($events_id))	{	
		foreach($events_id as $event_id)
				{
				
					$query ="SELECT * FROM " . $wpdb->prefix . "spidercalendar_event WHERE id=".$event_id;
					$events[] = $wpdb->get_row($query);

				}

$dates=array();


foreach($events as $ev)
{
$weekdays_start=array();
$st=$ev->date;

if($ev->date_end!='0000-00-00')
$en=$ev->date_end;
else
$en=date('Y-m-d', strtotime('+24 year', strtotime($st)));

$date_st=explode('-',$st);

$date_end=explode('-',$en);


$st_d= mktime(0, 0, 0,  $date_st[1],  $date_st[2], $date_st[0]);
$en_d = mktime(0, 0, 0,  $date_end[1],  $date_end[2], $date_end[0]);
$tarb=$en_d-$st_d;
$weekly_array=explode(',',$ev->week);

		for($j=0; $j<=6;$j++)
					{
						if( in_array(date("D", mktime(0, 0, 0, $date_st[1], $date_st[2]+$j, $date_st[0])),$weekly_array))
						{	
						
						$weekdays_start[]=$date_st[2]+$j;}
					}

					
	
if($ev->repeat_method=="no_repeat")
{
$dates[$ev->id][0]=$ev->date;
}		

///////////////////get days for daily repeat 
if($ev->repeat_method=="daily")
{
if($ev->repeat=="" || $ev->repeat=="0")
$ev->repeat = "1";

if($tarb<=0)
$day_count=((($st_d-$en_d)/3600)/24)/($ev->repeat);
else
$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat);

$dates[$ev->id][0]=$ev->date;

}
///////////////////get days for weekly repeat 
if($ev->repeat_method=="weekly")
{
$day_count=((($en_d-$st_d)/3600)/24)/($ev->repeat*7);

$d=array();
$dat=array();
for($j=0;$j<count($weekdays_start);$j++)
	{

	unset($dat);
	$dat[]=$date_st[0].'-'.$date_st[1].'-'.add_00($weekdays_start[$j]);


			
	
			$d=array_merge($d,$dat);
	}	

sort($d);
		$dates[$ev->id]=$d;

}	
///////////////////get days for monthly repeat 
if($ev->repeat_method=="monthly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$month_count = 0;

while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
    $month_count++;
}

$month_days = date('t',mktime(0, 0, 0, $date_st[1], 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, $date_st[1], $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.$date_st[1].'-'.add_00($j);
				
					}
												
				}
			}
			
			
	}
	

	
	

}


if($ev->repeat_method=="yearly")
{

$start_date = strtotime($ev->date);
$end_date = strtotime($en);
$min_date = min($start_date, $end_date);
$max_date = max($start_date, $end_date);
$year_count = 0;

while (($min_date = strtotime("+1 year", $min_date)) <= $max_date) {
    $year_count++;
}

$month_days = date('t',mktime(0, 0, 0, add_00($ev->year_month), 1, $date_st[0]));

	if($ev->month_type==1)
	{
	$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($ev->month);

	}
	else
	{
		if($ev->monthly_list!='last'){
			for($j=$ev->monthly_list; $j<$ev->monthly_list+7;$j++)
				{
				if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	


						$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
							
													
					}
				}
			}
		else
			{
			 for($j=1; $j<=$month_days;$j++)
				{
					if(date("D", mktime(0, 0, 0, add_00($ev->year_month), $j, $date_st[0])) == $ev->month_week)
					{	
					$dates[$ev->id][0]=$date_st[0].'-'.add_00($ev->year_month).'-'.add_00($j);
				
					}
												
				}
			}
			
			

	}
	

	
	

}


sort($dates[$ev->id]);

}

	$isk=1;
	$j=0;
	$ev=0;

	  foreach ($dates as $ev_id=>$date)
	 {

	 
	 	$events = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_event WHERE id='.$ev_id);

		$event=$events[0];
		
	  $event_id = $event->id; 
      $event_title = $event->title;
   $event_date =$date[0];
	  $event_end_date = $event->date_end;
      $event_text = $event->text_for_date;
      $calendar_id = $event->calendar;
      $repeat = $event->repeat;
	  
  $published = $event->published;
   $year=substr($event_date,0,4);
   $month=substr($event_date,5,-3);
   $day=substr($event_date,8);
   
   if( $published == 1){
   echo '<div id="event_table'.$id.'" >';
 if($show_numbering==1) 
{
echo '<div style="padding-top:0px;" class="pad"><a id="title'.$id.'"  class="thickbox-preview' . $many_sp_calendar . '"  
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" ></br><b>'. $isk++.'.'.$event_title.'</b></a></div>';
}
else
{
echo '<div style="padding-top:0px;" class="pad"><a id="title'.$id.'"  class="thickbox-preview' . $many_sp_calendar . '" 
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" ></br><b>'.$event_title.'</b></a></div>';
}
	
?>

<style>
<?php if($event_text==''){?>
td #event_date<?php echo $id?> 
{
padding-bottom:14px;

} 
<?php }?>
</style>

<?php

if($repeat==1)
$repeat="";

$activedatestr = '';
$date_format_array = explode(' ', $date_format);

for ($i = 0; $i < count($date_format_array); $i++) {
    $activedatestr .= __(date("" . $date_format_array[$i] . "", strtotime($event_date)), 'sp_calendar') . ' ';
  }

if($show_time==1)
echo '<div id="event_date'.$id.'">'.__($activedatestr, 'sp_calendar').'</div>';

if($show_repeat==1)
{

if($event->repeat_method=="no_repeat")
echo '';
else
{
echo '<div id="event_repeat'.$id.'" >';

	if($event->repeat_method=='daily')
	echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Day', 'sp_calendar') . '</div>';

		if($event->repeat_method=='weekly')

		{

		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Week(s) on', 'sp_calendar') . ' : ';

		$week=explode(',',$event->week);
		for ($g=0;$g<count($week);$g++) 

		{

			if($week[$g]!=''){

				if($g!=count($week)-2)

					echo week_convert_recent($week[$g]).',';

				else

					echo week_convert_recent($week[$g]);

			

			}

			

		}

		echo '</div>';

		}

		if($event->repeat_method=='monthly' and $event->month_type==1)
		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Month(s) on the', 'sp_calendar').' '.$event->month.'</div>';	



		if($event->repeat_method=='monthly' and $event->month_type==2)
		echo '<div>'. __('Repeat Every', 'sp_calendar').' '.$repeat.' '.__('Month(s) on the', 'sp_calendar').' '.week_number_recent($event->monthly_list).' '.week_convert_recent($event->month_week).'</div>';



		if($event->repeat_method=='yearly' and $event->month_type==1)
		echo '<div>'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.$event->month.'</div>';	



		if($event->repeat_method=='yearly' and $event->month_type==2)
		echo '<div >'. __('Repeat Every', 'sp_calendar').' ' .$repeat.' ' . __('Year(s) in', 'sp_calendar') . ' '.date('F',mktime(0,0,0,$event->year_month + 1,0,0)).' '. __('on the', 'sp_calendar').' '.week_number_recent($event->monthly_list).' '.week_convert_recent($event->month_week).'</div>';		






echo '</div>';		
}


}
if($show_eventtext==1)
{

if($event_text)
{

//$length = strlen($event_text);
$text = mb_substr(html_entity_decode(strip_tags($event_text)), 0, 50);

echo '<div id="event_text'.$id.'"><span>'.$text.'</span><br>';
echo '<a class="thickbox-preview' . $many_sp_calendar . '"  id="see_more'.$id.'" style="text-decoration:none;"
href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $id,
                              'eventID' => $ev_id,
							  'widget' => $widget,
                              'date' => $year.'-'.$month.'-'.$day,
							  'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height
                              ), get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php') . '" >'.__('See more', 'sp_calendar').'</a></div>';

}
}


echo '<div style="padding-top:6px"><hr id="divider'.$id.'"/></div>';
	$j++;
echo'</div>';
}

$ev++;
}
	
	
	}
 }
 ?>

 
 <?php
 
 
 echo '</div>';
    // After widget //
    echo $after_widget;
  }

  // Update Settings //
  function update($new_instance, $old_instance) {
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['calendar'] = $new_instance['calendar'];
    $instance['view_type'] = $new_instance['view_type'];
    $instance['event_qauntity1'] = $new_instance['event_qauntity1'];
    $instance['starting'] = $new_instance['starting'];
    $instance['follow_quality1'] = $new_instance['follow_quality1'];
	$instance['follow_quality3'] = $new_instance['follow_quality3'];
    $instance['event_qauntity2'] = $new_instance['event_qauntity2'];
    $instance['ordering'] = $new_instance['ordering'];
	$instance['event_qauntity22'] = $new_instance['event_qauntity22'];
    $instance['ordering1'] = $new_instance['ordering1'];
	$instance['event_select'] = $new_instance['event_select'];
	$instance['start_date'] = $new_instance['start_date'];
	$instance['starting'] = $new_instance['starting'];
	$instance['follow_quality2'] = $new_instance['follow_quality2'];
	$instance['event_qauntity3'] = $new_instance['event_qauntity3'];
	$instance['theme'] = $new_instance['theme'];
	$instance['event_date'] = $new_instance['event_date'];
	$instance['repeat_rate'] = $new_instance['repeat_rate'];
	$instance['numbering'] = $new_instance['numbering'];
	$instance['ev_text'] = $new_instance['ev_text'];
	$instance['width'] = $new_instance['width'];	
	$instance['bg_color'] = $new_instance['bg_color'];
	$instance['title_color'] = $new_instance['title_color'];
	$instance['title_size'] = $new_instance['title_size'];
	$instance['title_font'] = $new_instance['title_font'];
	$instance['date_color'] = $new_instance['date_color'];
	$instance['date_format'] = $new_instance['date_format'];
	$instance['repeat_color'] = $new_instance['repeat_color'];
	$instance['text_color'] = $new_instance['text_color'];
	$instance['divider_color'] = $new_instance['divider_color'];
    return $instance;
  }

  // Widget Control Panel //
  function form($instance) {
    global $wpdb;
    $defaults = array(
      'title' => 'Upcoming events',
      'calendar' => '0',
	  'theme' => '0',
      'view_type' => '0',
      'event_qauntity1' => '1',
      'follow_quality1' => '10',
	  'follow_quality3' => '10',
      'event_qauntity2' => '1',
      'ordering' => '0',
	  'event_qauntity22' => '1',
      'ordering1' => '0',
	  'event_select' => '',
	  'start_date' => '',
	  'starting' => '0',
	  'follow_quality2' => '10',
	  'event_qauntity3' => '1',
	  'event_date' => '1',
	  'repeat_rate' => '1',
	  'numbering' => '1',
	  'ev_text' => '1',
	  'width' => '200',
	  'bg_color' => 'FFFFFF',
	  'title_color' => '000000',
	  'title_size' => '14',
	  'title_font' => 'Arial',
	  'date_color' => '000000',
	  'date_format' => 'd F Y',
	  'repeat_color' => '000000',
	  'text_color' => '000000',
	  'divider_color' => 'C2C2C2',
    );
    $instance = wp_parse_args((array)$instance, $defaults);
    $all_clendars = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_calendar');
    $all_themes = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme');
	
	
	$id = $this->get_field_id('title');
    ?>
	 <script>
	jQuery(document).ready(function() {
		jQuery('.color_input').wpColorPicker();
	 });
	function selectcal(x)
	{
		a=jQuery("#add_eventsup");	
		selectcalendarvalue=x.value;
		a.href=a.href+'&upcalendar_id='+selectcalendarvalue;
	} 
	 </script>
	 <style>
	 .wp-color-result:focus{
		outline: none;
	 }
	 .wp-picker-container:has(.wp-picker-open) { color: red; }
	 #wd_admin_form .calendar .wd_button{
		display: table-cell !important;
	 }
	 
	 #wd_admin_form div.calendar{
		margin-left: -101px;
	 }

	 .color_for_this .wp-picker-container{
		position: absolute;
		left: 5px;
		top: 0px;
	 }
	 .paramlist_value{
		position: relative;
	 }
	 .color_input.wp-color-picker{
		  height: 23px;
	 }
	 .wp-picker-holder{
		top: -11px;
		position: relative;
		z-index: 3;
	 }
	 .wp-color-result:after{
		  width: 73px;
	 }
	 .paramlist_value > .wp-picker-container > a{
		left: -1px;
	 }
	 .wp-picker-container .wp-picker-container > a{
		  left: -11px;
	 }
	 .wp-color-result{
		  background-color: transparent;
		  left: -6px;
	 }
	 .wp-color-result:hover{
		  background-color: transparent;
		}
	 .color_for_this{
		  height: 24px;
		  top: 0px;
		  position: relative;
		  width: 35px;
		  left: 2px;
	 }
	 #repeat_rate_col .wp-picker-container .wp-picker-container > a{
		  left: -6px;
	 }
	 
	 .show_or_hide{
		 display: none;
	 }
	 
	.paramlist.admintable.upcoming label{
		 font-size: 11px;
	 }
	 
	 body:not(.customize-support) div.calendar{
		 z-index: 999999 !important;
		 left: 100px !important;
		 top: 0 !important;
	 }
	 </style>
    <p>
	
      <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>"/>
    </p>
	<span id="list"></span>
	<form method="get" action="calendar.php">
    <table width="100%" class="paramlist admintable upcoming" cellpadding="3">
      <tbody>
        <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('calendar'); ?>" class="hasTip">Select Calendar:</label>
            </span>
          </td>
          <td class="paramlist_value">
            <select name="<?php echo $this->get_field_name('calendar'); ?>" id="<?php echo $this->get_field_id('calendar'); ?>" style="font-size: 11px;;width:120px;" class="inputbox" onchange="selectcal(this)">
              <option value="0">Select Calendar</option>
              <?php
              $sp_calendar = count($all_clendars);
              for ($i = 0; $i < $sp_calendar; $i++) {
                ?>
              <option value="<?php echo $all_clendars[$i]->id; ?>" <?php if ($instance['calendar'] == $all_clendars[$i]->id) echo  'selected="selected"'; ?>><?php echo $all_clendars[$i]->title ?></option>
              <?php
              }
              ?>
            </select>
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('theme'); ?>" class="hasTip">Select Theme:</label>
            </span>
          </td>
          <td class="paramlist_value">
            <select name="<?php echo $this->get_field_name('theme'); ?>" id="<?php echo $this->get_field_id('theme'); ?>" style="font-size: 11px;; width:120px;" class="inputbox">
              <option value="0">Select Theme</option>
              <?php
              $sp_theme = count($all_themes);
              for ($i = 0; $i < $sp_theme; $i++) {
                ?>
              <option value="<?php echo $all_themes[$i]->id; ?>" <?php if ($instance['theme'] == $all_themes[$i]->id) echo 'selected="selected"'; ?>><?php echo $all_themes[$i]->title; ?></option>
                <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="width:120px" class="paramlist_view">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('view_type'); ?>" class="hasTip">Events to display:</label>
            </span>
          </td>
          <td class="paramlist_value" id="<?php echo $this->get_field_id('view_type'); ?>">
		  	<input type="radio" name="<?php echo $this->get_field_name('view_type'); ?>" id="<?php echo $this->get_field_id( 'view_type' ); ?>0" value="0" onchange="show_(0)" <?php if ($instance['view_type'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'view_type' ); ?>0">Starting From Current Date</label><br>

			<input type="radio" name="<?php echo $this->get_field_name('view_type'); ?>" id="<?php echo $this->get_field_id( 'view_type' ); ?>1" value="1" onchange="show_(1)" <?php if ($instance['view_type'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'view_type' ); ?>1">Events In Date Interval</label><br>
			
			<input type="radio" name="<?php echo $this->get_field_name('view_type'); ?>" id="<?php echo $this->get_field_id( 'view_type' ); ?>2" value="2" onchange="show_(2)" <?php if ($instance['view_type'] == "2") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'view_type' ); ?>2">Selected Events</label><br>
          </td>
        </tr>
		<tr class="event_qauntity1 show_or_hide" <?php if($instance['view_type']==0) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('event_qauntity1'); ?>">Events Quantity:</label>
			</td>
			<td>
				<input class="widefat" id="<?php echo $this->get_field_id('event_qauntity1'); ?>" name="<?php echo $this->get_field_name('event_qauntity1'); ?>'" type="text" value="<?php echo $instance['event_qauntity1']; ?>"/>
			</td>
		</tr>
		
		<tr class="starting show_or_hide" id="<?php echo $this->get_field_id('starting'); ?>" <?php if($instance['view_type']==1) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('starting'); ?>">Starting From:</label>
			</td>
			<td>
			
				<input type="radio" name="<?php echo $this->get_field_name('starting'); ?>" id="<?php echo $this->get_field_id( 'starting' ); ?>0" value="0" onchange="showd_(0)" <?php if ($instance['starting'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'starting' ); ?>0">Current Date</label><br>

				<input type="radio" name="<?php echo $this->get_field_name('starting'); ?>" id="<?php echo $this->get_field_id( 'starting' ); ?>1" value="1" onchange="showd_(1)" <?php if ($instance['starting'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'starting' ); ?>1">Events In Start Date</label><br>
			</td>
		</tr>
		<tr class="start_date show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==1) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('start_date'); ?>">Select Start Date:</label>
			</td>
			<td>
				<input style="width:85px" class="inputbox" type="text" name="<?php echo $this->get_field_name('start_date'); ?>'" id="<?php echo $this->get_field_id('start_date'); ?>" size="10" maxlength="10" value="<?php echo $instance['start_date']; ?>"/>
				
                    <input type="reset" class="wd_button" value="..." onclick="return showCalendar('<?php echo $this->get_field_id('start_date'); ?>','%Y-%m-%d');" style="border: 1px solid #DDD; border-radius: 50px;"/>
			</td>
		</tr>
		
		<tr class="follow_quality1 show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==0) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('follow_quality1'); ?>">Following Days Quantity:</label>
			</td>
			<td>
				<input class="widefat" id="<?php echo $this->get_field_id('follow_quality1'); ?>" name="<?php echo $this->get_field_name('follow_quality1'); ?>'" type="text" value="<?php echo $instance['follow_quality1']; ?>"/>
			</td>
		</tr>
		
		<tr class="follow_quality3 show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==1) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('follow_quality3'); ?>">Following Days Quantity:</label>
			</td>
			<td>
				<input class="widefat" id="<?php echo $this->get_field_id('follow_quality3'); ?>" name="<?php echo $this->get_field_name('follow_quality3'); ?>'" type="text" value="<?php echo $instance['follow_quality3']; ?>"/>
			</td>
		</tr>
		
		<tr class="event_qauntity2 show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==0) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('event_qauntity2'); ?>">Events Quantity:</label>
			</td>
			<td>
				<input class="widefat" id="<?php echo $this->get_field_id('event_qauntity2'); ?>" name="<?php echo $this->get_field_name('event_qauntity2'); ?>'" type="text" value="<?php echo $instance['event_qauntity2']; ?>"/>
			</td>
		</tr>
		
		<tr class="event_qauntity22 show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==1) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('event_qauntity22'); ?>">Events Quantity:</label>
			</td>
			<td>
				<input class="widefat" id="<?php echo $this->get_field_id('event_qauntity22'); ?>" name="<?php echo $this->get_field_name('event_qauntity22'); ?>'" type="text" value="<?php echo $instance['event_qauntity22']; ?>"/>
			</td>
		</tr>
		
		<tr class="ordering show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==0) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('ordering'); ?>">Ordering:</label>
			</td>
			<td>				
				<input type="radio" name="<?php echo $this->get_field_name('ordering'); ?>" id="<?php echo $this->get_field_id( 'ordering' ); ?>0" value="0" <?php if ($instance['ordering'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ordering' ); ?>0">Ordering</label><br>

				<input type="radio" name="<?php echo $this->get_field_name('ordering'); ?>" id="<?php echo $this->get_field_id( 'ordering' ); ?>1" value="1" <?php if ($instance['ordering'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ordering' ); ?>1">Events In Random</label><br>
				
			</td>
		</tr>
		
		<tr class="ordering1 show_or_hide" <?php if($instance['view_type']==1 && $instance['starting']==1) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('ordering1'); ?>">Ordering:</label>
			</td>
			<td>			
				<input type="radio" name="<?php echo $this->get_field_name('ordering1'); ?>" id="<?php echo $this->get_field_id( 'ordering1' ); ?>0" value="0" <?php if ($instance['ordering1'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ordering1' ); ?>0">Ordering</label><br>

				<input type="radio" name="<?php echo $this->get_field_name('ordering1'); ?>" id="<?php echo $this->get_field_id( 'ordering1' ); ?>1" value="1" <?php if ($instance['ordering1'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ordering1' ); ?>1">Events In Random</label><br>
			</td>
		</tr>
		
		<tr class="follow_quality show_or_hide" <?php if($instance['view_type']==2) echo 'style="display: table-row;"'; ?>>
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('follow_quality'); ?>">Select Events From List:</label>
			</td>
			<td>
            <?php global $firtstime; ?>
				<a href="<?php echo get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php'; ?>?action=upcoming&id_input=<?php echo $this->get_field_id('event_select');?>&w_id=<?php echo $this->get_field_id('title');?>&TB_iframe=1&tbWidth=1024&tbHeight=768" class="thickbox-preview<?php echo $firtstime; ?>" id="<?php echo $id?>"  onclick="addcal(this,'<?php echo $this->get_field_id('calendar'); ?>','<?php echo $this->get_field_id('event_select');?>','<?php echo $this->get_field_id('title');?>')" rel="{handler: 'iframe', size: {x: 750, y: 450}}" id="add_eventsup">

				<img src="<?php echo plugins_url(); ?>/spider-event-calendar/front_end/images/add_but.png" class="hasTip" /> </a>
				
				 <input type="hidden" name="boxchecked" value="0" >

			</td>

		</tr>
		
		<tr class="event_qauntity3 show_or_hide">
			<td class="paramlist_quality">
				<label style="font-size: 11px;" for="<?php echo $this->get_field_id('event_qauntity3'); ?>">Events Quantity:</label>
			</td>
			<td>
				<table id="art_table_meta" width="100%">
					<tbody id="meta">
						<input class="widefat" id="<?php echo $this->get_field_id('event_qauntity3'); ?>" name="<?php echo $this->get_field_name('event_qauntity3'); ?>'" type="text" value="<?php echo $instance['event_qauntity3']; ?>" />
					</tbody>
				</table>
				
				
			</td>
		</tr>
		
		
		<tr id="event_select">
			<table width="100%">
				<tbody id="event<?php echo $id ?>">
				</tbody>
			</table>
		</tr>	
		
      </tbody>
    </table>
	<hr>
	 <script>
function addcal(x,y,z,f)
{
	var calendar=document.getElementById(y).value;
	jQuery(x).attr('href','<?php echo get_option( "home", get_site_url()).'/wp-admin/admin-ajax.php'; ?>?action=upcoming&id_input='+z+'&w_id='+f+'&upcalendar_id='+calendar+'&TB_iframe=1&tbWidth=1024&tbHeight=768');
}
</script> 
	<table width="100%" class="paramlist admintable upcoming" cellpadding="3">
      <tbody>
        <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('event_date'); ?>" class="hasTip">Show Event Date:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="radio" name="<?php echo $this->get_field_name('event_date'); ?>" id="<?php echo $this->get_field_id( 'event_date' ); ?>1" value="1" <?php if ($instance['event_date'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'event_date' ); ?>1">Yes</label>

				<input type="radio" name="<?php echo $this->get_field_name('event_date'); ?>" id="<?php echo $this->get_field_id( 'event_date' ); ?>0" value="0" <?php if ($instance['event_date'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'event_date' ); ?>0">No</label><br>
			</td>
          </td>
        </tr>
	
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('repeat_rate'); ?>" class="hasTip">Show Event Repeat Rate:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="radio" name="<?php echo $this->get_field_name('repeat_rate'); ?>" id="<?php echo $this->get_field_id( 'repeat_rate' ); ?>1" value="1" <?php if ($instance['repeat_rate'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'repeat_rate' ); ?>1">Yes</label>
				<input type="radio" name="<?php echo $this->get_field_name('repeat_rate'); ?>" id="<?php echo $this->get_field_id( 'repeat_rate' ); ?>0" value="0" <?php if ($instance['repeat_rate'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'repeat_rate' ); ?>0">No</label>
				<br>
          </td>
        </tr>
		
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('ev_text'); ?>" class="hasTip">Show Event Text:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="radio" name="<?php echo $this->get_field_name('ev_text'); ?>" id="<?php echo $this->get_field_id( 'ev_text' ); ?>1" value="1" <?php if ($instance['ev_text'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ev_text' ); ?>1">Yes</label>
				<input type="radio" name="<?php echo $this->get_field_name('ev_text'); ?>" id="<?php echo $this->get_field_id( 'ev_text' ); ?>0" value="0" <?php if ($instance['ev_text'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'ev_text' ); ?>0">No</label>
				<br>
          </td>
        </tr>
		
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('numbering'); ?>" class="hasTip">Show Numbering:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="radio" name="<?php echo $this->get_field_name('numbering'); ?>" id="<?php echo $this->get_field_id( 'numbering' ); ?>1" value="1" <?php if ($instance['numbering'] == "1") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'numbering' ); ?>1">Yes</label>
				<input type="radio" name="<?php echo $this->get_field_name('numbering'); ?>" id="<?php echo $this->get_field_id( 'numbering' ); ?>0" value="0" <?php if ($instance['numbering'] == "0") echo 'checked="checked"'; ?> /><label for="<?php echo $this->get_field_id( 'numbering' ); ?>0">No</label>
				<br>				
          </td>
		</tr>
		</tbody>
	</table>
	
	<hr>
	
	<table width="100%" class="paramlist admintable upcoming"  cellpadding="4">
      <tbody>
	  <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('width'); ?>" class="hasTip">Width:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width'];?>" />
          </td>
        </tr>
        <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('bg_color'); ?>" class="hasTip">Background Color:</label>
            </span>
          </td>
          <td class="paramlist_value">
			<div class="color_for_this" style="background-color: #<?php echo str_replace('#','',$instance['bg_color']);?>">
			<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('bg_color'); ?>" name="<?php echo $this->get_field_name('bg_color'); ?>" value="<?php echo $instance['bg_color'];?>" />
			</div>
          </td>
        </tr>
		 <tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('title_color'); ?>" class="hasTip">Event Title Color:</label>
            </span>
          </td>
          <td class="paramlist_value">
			<div class="color_for_this" style="background-color: #<?php echo str_replace('#','',$instance['title_color']);?>">
				<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('title_color'); ?>" name="<?php echo $this->get_field_name('title_color'); ?>" value="<?php echo $instance['title_color'];?>" />
			</div>
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('title_size'); ?>" class="hasTip">Event Title Font Size:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="text" id="<?php echo $this->get_field_id('title_size'); ?>" name="<?php echo $this->get_field_name('title_size'); ?>" value="<?php echo $instance['title_size'];?>"/>
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('title_font'); ?>" class="hasTip">Event Title Font:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<select name="<?php echo $this->get_field_name('title_font'); ?>" id="<?php echo $this->get_field_id('font'); ?>" style="font-size: 11px;; width:105px" class="inputbox">		 
                    <option value="0">Select Font</option>
                    <option value="Verdana" <?php if($instance['title_font']=='Verdana') echo 'selected="selected"'?>>Verdana</option>
                    <option value="Lucida" <?php if($instance['title_font']=='Lucida') echo 'selected="selected"'?>>Lucida</option>
                    <option value="Georgia" <?php if($instance['title_font']=='Georgia') echo 'selected="selected"'?>>Georgia</option>
                    <option value="Tahoma" <?php if($instance['title_font']=='Tahoma') echo 'selected="selected"'?>>Tahoma</option>
                    <option value="Arial" <?php if($instance['title_font']=='Arial') echo 'selected="selected"'?>>Arial</option>
             </select>
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('date_color'); ?>" class="hasTip">Event Date Color:</label>
            </span>
          </td>
          <td class="paramlist_value">
			<div class="color_for_this" style="background-color: #<?php echo str_replace('#','',$instance['date_color']);?>">
				<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('date_color'); ?>" name="<?php echo $this->get_field_name('date_color'); ?>" value="<?php echo $instance['date_color'];?>" />
			</div>
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('date_format'); ?>" class="hasTip">Event Date Format:</label>
            </span>
          </td>
          <td class="paramlist_value">
				<input type="text" id="<?php echo $this->get_field_id('date_format'); ?>" name="<?php echo $this->get_field_name('date_format'); ?>" value="<?php echo $instance['date_format'];?>" />
          </td>
        </tr>
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('repeat_color'); ?>" class="hasTip">Event Repeat Rate Color:</label>
            </span>
          </td>
          <td class="paramlist_value" id="repeat_rate_col">
				<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('repeat_color'); ?>" name="<?php echo $this->get_field_name('repeat_color'); ?>" value="<?php echo $instance['repeat_color'];?>" />
          </td>
        </tr>
		
		
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('text_color'); ?>" class="hasTip">Event Text Color:</label>
            </span>
          </td>
          <td class="paramlist_value">
			<div class="color_for_this" style="background-color: #<?php echo str_replace('#','',$instance['text_color']);?>">
				<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" value="<?php echo $instance['text_color'];?>" />
			</div>
          </td>
        </tr>
		
		<tr>
          <td style="width:120px" class="paramlist_key">
            <span class="editlinktip">
              <label style="font-size: 11px;" for="<?php echo $this->get_field_id('divider_color'); ?>" class="hasTip">Divider Color:</label>
            </span>
          </td>
          <td class="paramlist_value">
			<div class="color_for_this" style="background-color: #<?php echo str_replace('#','',$instance['divider_color']);?>">
				<input class="color_input wp-color-picker" id="<?php echo $this->get_field_id('divider_color'); ?>" name="<?php echo $this->get_field_name('divider_color'); ?>" value="<?php echo $instance['divider_color'];?>" />
			</div>
          </td>
        </tr>
	 </tbody>
	 </table>
	 <input id="<?php echo $this->get_field_id('event_select'); ?>" name="<?php echo $this->get_field_name('event_select'); ?>'" type="hidden" value="<?php echo $instance['event_select'];?>"/>
	 
	
	 
	<script type="text/javascript">
	<?php  if($firtstime==1) { ?>
	var next=0;
	var onfirsttimeload=0;
	function jSelectEvents(input_id,tbody_id,w_id,evid,title) {
		event_ids =document.getElementById(input_id).value;
		input = document.getElementById(input_id);
		input.setAttribute("value", "g");

		tbody = document.getElementById(tbody_id);
		var  str;
		str=document.getElementById(input_id).value;

		for(i=0; i<evid.length; i++)
		{
		var  var_serch=","+evid[i]+",";
		if(onfirsttimeload!=0) var do_this = event_ids.includes(var_serch);
		else var do_this = false;
		if(!do_this)
		if((!str)||str.indexOf(var_serch)==-1 || onfirsttimeload==0){
		
			tr = document.createElement('tr');
				tr.setAttribute('event_id'+w_id, evid[i]);
				
				tr.setAttribute('id', 'event_select'+w_id+'_'+next);
				
			var td_info = document.createElement('td');
				td_info.setAttribute('id','info'+w_id+'_'+next);
				//td_info.setAttribute('width','10px');
			
			
			b = document.createElement('b');
				b.innerHTML = title[i];
				b.style.width='100px';
				b.style.float='left';
				b.style.position="inherit";
			
			
			
			
			td_info.appendChild(b);
			
		
			
						//if(event_ids.indexOf(evid) = -1)
			//td.appendChild(p_url);
			
			var img_X = document.createElement("img");
					img_X.setAttribute("src", "<?php echo plugins_url()?>/spider-event-calendar/images/delete_el.png");
//					img_X.setAttribute("height", "17");
					img_X.style.cssText = "cursor:pointer; margin-left:60px";
					img_X.setAttribute("onclick", 'remove_row("event_select'+w_id+'_'+next+'","'+input_id+'","'+tbody_id+'","'+w_id+'")');
					
			var td_X = document.createElement("td");
					td_X.setAttribute("id", "X_"+next);
					td_X.setAttribute("valign", "middle");
//					td_X.setAttribute("align", "right");
					td_X.style.width='50px';
					td_X.appendChild(img_X);
					
			var img_UP = document.createElement("img");
					img_UP.setAttribute("src", "<?php echo plugins_url()?>/spider-event-calendar/images/up.png");
//					img_UP.setAttribute("height", "17");
					img_UP.style.cssText = "cursor:pointer";
					img_UP.setAttribute("onclick", 'up_row("event_select'+w_id+'_'+next+'","'+input_id+'","'+tbody_id+'","'+w_id+'")');
					
			var td_UP = document.createElement("td");
					td_UP.setAttribute("id", "up_"+next);
					td_UP.setAttribute("valign", "middle");
					td_UP.style.width='20px';
					td_UP.appendChild(img_UP);
					
			var img_DOWN = document.createElement("img");
					img_DOWN.setAttribute("src", "<?php echo plugins_url()?>/spider-event-calendar/images/down.png");
//					img_DOWN.setAttribute("height", "17");
					img_DOWN.style.cssText = "margin:2px;cursor:pointer";
					img_DOWN.setAttribute("onclick", 'down_row("event_select'+w_id+'_'+next+'","'+input_id+'","'+tbody_id+'","'+w_id+'")');
					
			var td_DOWN = document.createElement("td");
					td_DOWN.setAttribute("id", "down_"+next);
					td_DOWN.setAttribute("valign", "middle");
					td_DOWN.style.width='20px';
					td_DOWN.appendChild(img_DOWN);
				
			tr.appendChild(td_info);
			tr.appendChild(td_X);
			tr.appendChild(td_UP);
			tr.appendChild(td_DOWN);
			tbody.appendChild(tr);

			
			
//refresh
			next++;
			}
			
		}
	onfirsttimeload=onfirsttimeload+1;

	document.getElementById(input_id).value=event_ids;
	if(jQuery( "body" ).hasClass( "customize-support" )) tb_remove();
	if(!event_ids.includes(evid))
	refresh_(input_id,tbody_id,w_id);
		
	}
	
	
	function remove_row(id,input_id,tbody_id,w_id){	
	tr=document.getElementById(id);
	tr.parentNode.removeChild(tr);
	refresh_(input_id,tbody_id,w_id);
}
	
	
	function up_row(id,input_id,tbody_id,w_id){
	form=document.getElementById(id).parentNode;
	k=1;
	while(form.childNodes[k])
	{
	if(form.childNodes[k].getAttribute("id"))
	if(id==form.childNodes[k].getAttribute("id"))
		break;
	k++;
	}
	if(k!=0)
	{
		up=form.childNodes[k-1];
		down=form.childNodes[k];
		form.removeChild(down);
		form.insertBefore(down, up);
		refresh_(input_id,tbody_id,w_id);
	}
}

function down_row(id,input_id,tbody_id,w_id){
	form=document.getElementById(id).parentNode;
	l=form.childNodes.length;
	k=1;
	while(form.childNodes[k])
	{
	if(id==form.childNodes[k].id)
		break;
	k++;
	}

	if(k!=l-1)
	{
		up=form.childNodes[k];
		down=form.childNodes[k+2];
		form.removeChild(up);
if(!down)
down=null;
		form.insertBefore(up, down);
		refresh_(input_id,tbody_id,w_id);
	}
}
	
	function refresh_(input_id,tbody_id,w_id){
	
	GLOBAL_tbody=document.getElementById(tbody_id);

	tox=',';
	for (x=1; x < GLOBAL_tbody.childNodes.length; x++)
	{
	
		tr=GLOBAL_tbody.childNodes[x];
		
		if(tr.getAttribute('event_id'+w_id))
		tox=tox+tr.getAttribute('event_id'+w_id)+',';

	}
	

	document.getElementById(input_id).value=tox;

}
	
	
	<?php } ?>
	
	function show_(x){
		if(x==0){
			jQuery('.event_qauntity1').show();
			jQuery('.starting').hide();
			jQuery('.follow_quality1').hide();
			jQuery('.event_qauntity2').hide();
			jQuery('.ordering').hide();
			jQuery('.event_qauntity22').hide();
			jQuery('.ordering1').hide();
			jQuery('.event_select').hide();
			jQuery('.follow_quality2').hide();
			jQuery('.event_qauntity3').hide();
			jQuery('.follow_quality').hide();
			jQuery('.follow_quality3').hide();
			jQuery('.start_date').attr('style','display:none');
			jQuery('.paramlist.admintable').next().hide();
		 }
		 else if(x==1){
			jQuery('.event_qauntity1').hide();
			jQuery('.starting').show();
			jQuery('.follow_quality1').hide();
			jQuery('.event_qauntity2').show();
			jQuery('.ordering').show();
			jQuery('.follow_quality2').hide();
			jQuery('.event_qauntity3').hide();
			jQuery('.follow_quality').hide();
			jQuery('.follow_quality3').show();
			jQuery('.event_select').hide();
			jQuery('.paramlist.admintable').next().hide();			
		}
		else if(x==2){
			jQuery('.event_qauntity1').hide();
			jQuery('.starting').hide();
			jQuery('.follow_quality1').hide();
			jQuery('.event_qauntity2').hide();
			jQuery('.ordering').hide();
			jQuery('.event_qauntity22').hide();
			jQuery('.ordering1').hide();
			jQuery('.follow_quality2').hide();
			jQuery('.event_qauntity3').hide();
			jQuery('.follow_quality').show();
			jQuery('.follow_quality3').hide();
			jQuery('.event_select').show();
			jQuery('.paramlist.admintable').next().show();
			jQuery('.start_date').attr('style','display:none')
		  }	
		  else{
				jQuery('.start_date').attr('style','display:none')
			}
		}
	
	function showd_(y)
{
		if(y==0){
			jQuery('.follow_quality1').show();	
			jQuery('.follow_quality3').hide();
			jQuery('.event_qauntity2').show();
			jQuery('.ordering').show();
			jQuery('.event_qauntity22').hide();
			jQuery('.ordering1').hide();
			jQuery('.start_date').hide();
			jQuery('.paramlist.admintable').next().hide();
		}
		
		else if(y==1){
			jQuery('.follow_quality3').show();	
			jQuery('.follow_quality1').hide();
			jQuery('.event_qauntity2').hide();
			jQuery('.ordering').hide();
			jQuery('.event_qauntity22').show();
			jQuery('.ordering1').show();
			jQuery('.start_date').show();
			jQuery('.paramlist.admintable').next().hide();
		
	}
}

var thickDims, tbWidth, tbHeight;

jQuery(document).ready(function($) {
        thickDims = function() {
                var tbWindow = $('#TB_window'), H = $(window).height(), W = $(window).width(), w, h;
                w = (tbWidth && tbWidth < W - 90) ? tbWidth : W - 200;
                h = (tbHeight && tbHeight < H - 60) ? tbHeight : H - 200;
                if ( tbWindow.size() ) {
                        tbWindow.width(w).height(h);
                       $('#TB_iframeContent').width(w).height(h - 27);
                        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
                        if ( typeof document.body.style.maxWidth != 'undefined' )
                                tbWindow.css({'top':(H-h)/2,'margin-top':'0'});

                }

        };



        thickDims();
<?php global $firtstime;  ?>
        $(window).resize( function() { thickDims() } );



        $('a.thickbox-preview<?php echo $firtstime; ?>').click( function() {
calendar=jQuery(this).parent().parent().parent().children()[0].childNodes[3].childNodes[1].value;
		if(calendar!=0)
		{
			tb_click.call(this);
                var alink = $(this).parents('.available-theme').find('.activatelink'), link = '', href = $(this).attr('href'), url, text;
                if ( tbWidth = href.match(/&tbWidth=[0-9]+/) )
                        tbWidth = parseInt(tbWidth[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbWidth = $(window).width() - 90;
                if ( tbHeight = href.match(/&tbHeight=[0-9]+/) )
                        tbHeight = parseInt(tbHeight[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbHeight = $(window).height() - 60;
                if ( alink.length ) {
                        url = alink.attr('href') || '';
                        text = alink.attr('title') || '';
                        link = '&nbsp; <a href="' + url + '" target="_top" class="tb-theme-preview-link">' + text + '</a>';
                } else {
                        text = $(this).attr('title') || '';
                        link = '&nbsp; <span class="tb-theme-preview-link">' + text + '</span>';
                }
                $('#TB_title').css({'background-color':'#222','color':'#dfdfdf'});
                $('#TB_closeAjaxWindow').css({'float':'left'});
                $('#TB_ajaxWindowTitle').css({'float':'right'}).html(link);
                $('#TB_iframeContent').width('100%');
                thickDims();
}
else
{
alert('Please select calendar')
}
                return false;
				
        } );
        // Theme details
        $('.theme-detail').click(function () {
                $(this).siblings('.themedetaildiv').toggle();
                return false;
        });
});
	</script>
	
		 <?php
	 $events=array();
	$events_id=explode(',',$instance['event_select']);
	$events_id= array_slice($events_id,1, count($events_id)-2);  
	
	foreach($events_id as $event_id)
	{

		$query ="SELECT * FROM " . $wpdb->prefix . "spidercalendar_event  WHERE published='1' AND id=".$event_id;
		
		$is=$wpdb->get_row($query);
		if($is)
		$events[] = $wpdb->get_row($query);
		
		
	}

if($events)
{
	foreach($events as $event)
	{
	  $day = $event->date;
		$v_ids[]=$event->id;
	
		$v_titles[]=addslashes($event->title.' ('.date('d M Y',strtotime($day)).')');
	
		
	}
	

	$v_id='["'.implode('","',$v_ids).'"]';
	$v_title='["'.implode('","',$v_titles).'"]';
	
$tbody_id ="event".$id;
if($this->number!="__i__"){  
?>

<script type="text/javascript"> 

jSelectEvents('<?php echo $this->get_field_id('event_select'); ?>','<?php echo $tbody_id?>','<?php echo $id?>',<?php echo $v_id?>,<?php echo $v_title?>);

</script>
<?php

}
}
?>

	
	
    <?php
	$firtstime  = $firtstime+1;
  }
  
	
}
add_action('widgets_init', create_function('', 'return register_widget("upcoming_events");'));?>