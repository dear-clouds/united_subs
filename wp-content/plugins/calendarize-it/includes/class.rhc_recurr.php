<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_recurr {
	var $version = 1;
	var $timezone = false;
	function __construct( $args=array() ){
		//------------
		$defaults = array(
			'path'				=> ''
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		add_filter('generate_calendarize_meta', array(&$this,'generate_calendarize_meta'), 20, 2);
		add_action('admin_init', array( &$this, 'handle_update' ) );
	}
	
	function handle_update(){
		global $rhc_plugin;
		if( '1'==$rhc_plugin->get_option('force_recur_update','1',true) ){
			update_option('rhc_recurr_version', 0 );
		}
	
		if( $this->version > intval( get_option('rhc_recurr_version') ) ){
			global $wpdb;		
			//---
			$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}rhc_events'");
			if (!count($tables)){
				$charset_collate = '';  
				if ( ! empty($wpdb->charset) )$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				if ( ! empty($wpdb->collate) )$charset_collate .= " COLLATE $wpdb->collate";	
				$wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rhc_events` (
				  `event_start` datetime NOT NULL,
				  `event_end` datetime NOT NULL,
				  `post_id` bigint(20) NOT NULL,
				  `allday` tinyint(4) NOT NULL DEFAULT '0',
				  `number` int(11) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`event_start`,`post_id`),
				  KEY `event_end` (`event_end`,`post_id`),
				  KEY `event_start` (`event_start`,`event_end`)
				) $charset_collate;");				
			}
			
			$sql = "SELECT  DISTINCT( M.post_id ) FROM `{$wpdb->postmeta}` M LEFT JOIN `{$wpdb->prefix}rhc_events` E ON E.post_id=M.post_id WHERE M.meta_key='fc_start' AND E.post_id IS NULL;";
			$post_ids = $wpdb->get_col($sql,0);
			if(is_array($post_ids) && count($post_ids)>0){
				foreach($post_ids as $id){
					$this->generate_calendarize_meta($id, null);
				}
			}
			
			update_option('rhc_recurr_version',$this->version);
		}
	}
	
	function generate_calendarize_meta($post_id, $post){
//file_put_contents( ABSPATH.'api.log', "start log\n" );	
		
		global $wpdb;	
		$post_id = intval($post_id);
		$fc_allday = intval(get_post_meta($post_id,'fc_allday',true));	
		
		try {
			$ocurrences = $this->get_recurr_dates( $post_id );
		}catch( Exception $e ){
			$ocurrences = false;
		}
		
		if(false!==$ocurrences){
//error_log( print_r($ocurrences,true)."\n",3,ABSPATH.'api.log' );	
			$sql = '';
			$wpdb->query("DELETE FROM `{$wpdb->prefix}rhc_events` WHERE post_id=$post_id");
			$base_sql = "INSERT IGNORE INTO `{$wpdb->prefix}rhc_events` (`event_start`,`event_end`,`post_id`,`allday`,`number`)VALUES";
			$arr = array(); 
			$number = 0;
			foreach($ocurrences as $c){	
//error_log( "START: ". $c->getStart()->format( 'Y-m-d H:i:s' )." END:".$c->getEnd()->format( 'Y-m-d H:i:s' )."\n",3, ABSPATH.'api.log' );
				$str_start = $c->getStart()->format( 'Y-m-d H:i:s' );
				$str_end = null!==$c->getEnd() ? $c->getEnd()->format( 'Y-m-d H:i:s' ) : $c->getStart()->format( 'Y-m-d H:i:s' ) ;

				$arr[] = sprintf("('%s','%s',%s,%s,%s)",
					$str_start,
					$str_end,
					$post_id,
					$fc_allday,
					($number++)
				);
				
				if(count($arr)>50){
					$sql = $base_sql.implode(',',$arr);
					//error_log( "$sql\n",3,ABSPATH.'api.log' );
					$wpdb->query( $sql );
					$arr = array();
				}
			}	
			
			if(!empty($arr)){
				$sql = $base_sql.implode(',',$arr);
				//error_log( "$sql\n",3,ABSPATH.'api.log' );
				$wpdb->query( $sql );
				$arr = array();				
			}	
		}

		return $post_id;
	}
	
	function get_recurr_dates( $post_id ){	
	
		if(!class_exists('Recurrence')){
			//--Doctrine
			require_once $this->path.'recurr/Doctrine/Common/Collections/Collection.php';
			require_once $this->path.'recurr/Doctrine/Common/Collections/Selectable.php';
			require_once $this->path.'recurr/Doctrine/Common/Collections/ArrayCollection.php';
			
			//--Rule
			require_once $this->path.'recurr/Exception.php';
			require_once $this->path.'recurr/Exception/InvalidRRule.php';
			require_once $this->path.'recurr/Exception/InvalidWeekday.php';
			require_once $this->path.'recurr/Exception/MissingData.php';
			require_once $this->path.'recurr/Exception/InvalidArgument.php';
			
			require_once $this->path.'recurr/Rule.php';
			require_once $this->path.'recurr/Transformer/ArrayTransformer.php';
			require_once $this->path.'recurr/Transformer/ArrayTransformerConfig.php';
			require_once $this->path.'recurr/DateUtil.php';
			require_once $this->path.'recurr/Frequency.php';
			require_once $this->path.'recurr/Weekday.php';
			require_once $this->path.'recurr/DateInfo.php';
			require_once $this->path.'recurr/DaySet.php';
			require_once $this->path.'recurr/Time.php';
			require_once $this->path.'recurr/Recurrence.php';
			require_once $this->path.'recurr/RecurrenceCollection.php';
			require_once $this->path.'recurr/DateExclusion.php';
			require_once $this->path.'recurr/Exception.php';
			require_once $this->path.'recurr/Transformer/ConstraintInterface.php';
			require_once $this->path.'recurr/Transformer/Constraint.php';
			require_once $this->path.'recurr/Transformer/Constraint/BeforeConstraint.php';			
		}

		$rrule = $this->get_rrule( $post_id );
		$start = get_post_meta($post_id,'fc_start_datetime',true);
		$end = get_post_meta($post_id,'fc_end_datetime',true);	
		$fc_allday = intval(get_post_meta($post_id,'fc_allday',true));	
		if(empty($start)){
			return false;
		}

		
		//--
		$timezone = $this->get_timezone();
		$DateTimeZone = new \DateTimeZone($timezone);
		$ts = strtotime($start);
		$end_seconds = $ts + intval(apply_filters('rhc_recurr_limit_seconds',157784760)); // hard limit of 5 years.
		$recurr_end_date = date("Y-m-d H:i:s", $end_seconds);
		try {
			$startDate   = new \DateTime($start, $DateTimeZone );
		}catch( Exception $e ){
			return false;
		}		
		//---
		if($fc_allday){
			$startDate->setTime(0,0,0);
		}
		if(empty($end)){
			$endDate = null;
		}else{
			try {
				$endDate = new \DateTime( $end, $DateTimeZone );
			}catch( Exception $e ){
				return false;
			}			
			if($fc_allday){
				$endDate->setTime(0,0,0);
			}			
			$ts_end = strtotime($start);
			if( $endDate->format('U') < $startDate->format('U') ){
				$endDate = clone $startDate;
			}
		}	
		

		if(empty($rrule)){
			if( null==$endDate ){
				$constraint_endDate = clone $startDate;
			}else{
				$constraint_endDate = clone $endDate;
				//bug: dates like april 30, 2016 do not show in calendar.
				$constraint_endDate->add(DateInterval::createFromDateString('1 day'));
			}
			//$constraint_endDate = new \DateTime($start, $DateTimeZone );
		}else{
			$constraint_endDate = new \DateTime( $recurr_end_date, $DateTimeZone );
		}
		
		if( $endDate!=null && $constraint_endDate->format('U') < $endDate->format('U') ){
			$constraint_endDate = clone $endDate;
		}
		//--		
		if(empty($rrule)){
			$rrule="FREQ=DAILY;INTERVAL=1;COUNT=1";
		}	
//error_log("RRULE $rrule \n",3,ABSPATH.'api.log');	
/*
			
error_log( "startDate:".print_r($startDate,true)."\n",3,ABSPATH.'api.log');
error_log( "endDate:".print_r($endDate,true)."\n",3,ABSPATH.'api.log');	
error_log( "constraint endDate:".print_r($constraint_endDate,true)."\n",3,ABSPATH.'api.log');	
*/			
		$rrule = str_replace("RRULE:","",$rrule);
		try {
			$rule        = new \Recurr\Rule($rrule, $startDate, $endDate, $timezone );
		}catch( Exception $error ){
			$rule		= new \Recurr\Rule("FREQ=DAILY;INTERVAL=1;COUNT=1", $startDate, $endDate, $timezone );
		}
				

		$constraint = new \Recurr\Transformer\Constraint\BeforeConstraint( $constraint_endDate, true );
		$transformer = new \Recurr\Transformer\ArrayTransformer();

		$dates = $transformer->transform( $rule, null, $constraint );		
		//--- add repeat dates
		$duration = false;
		if( $endDate ){
			$duration = $startDate->diff( $endDate );		
		}	
		
		$rdate = get_post_meta($post_id, 'fc_rdate', true);
		$rdate_arr = array();
		if(''!=trim($rdate)){
			$rdate_arr = explode(',',$rdate);
			if(count($rdate_arr)>0){
				foreach($rdate_arr as $date_str){
					$tmp_date_start = new \DateTime($date_str, new \DateTimeZone($timezone));
					$tmp_date_end = null;
					if( false!==$duration ){
						$tmp_date_end = new \DateTime($date_str, new \DateTimeZone($timezone));
						$tmp_date_end->add( $duration );	
					}
					$new_recur = new \Recurr\Recurrence( $tmp_date_start, $tmp_date_end );
					$dates->add($new_recur);
				}
				//---
				$iterator = $dates->getIterator();
				$iterator->uasort(function ($a, $b) {
				    return ($a->getStart() < $b->getStart()) ? -1 : 1;
				});
				$dates = new \Recurr\RecurrenceCollection(iterator_to_array($iterator));
			}
		}
		
	
		//--- exclude
		$exdate = get_post_meta($post_id, 'fc_exdate', true);

		$exdate_arr = array();	
		if( !$dates->isEmpty() && ''!=trim($exdate) ){			
			$exdate_arr = explode(',', $exdate );			
			if(count($exdate_arr)>0){
				$exclude_date_objects = array();
				foreach($exdate_arr as $date_str){
					$tmp_date = new \DateTime($date_str, new \DateTimeZone($timezone));
					if(is_object($tmp_date)){
						$exclude_date_objects[]=$tmp_date;
					}
				}			
				
				foreach( $dates as $date ){
					if( in_array( $date->getStart() , $exclude_date_objects ) ){
						$dates->removeElement( $date );
					}
				}
			}
		}
			
		return $dates;
	}
	
	function get_rrule( $post_id ){
		$rrule = get_post_meta($post_id, 'fc_rrule', true);		
		if(!empty($rrule)){
			$arr = explode(';',$rrule);
			if(is_array($arr)&&count($arr)>0){
				foreach($arr as $pair){
					$brr = explode('=',$pair);
					if( 'UNTIL'==strtoupper($brr[0])){
						if(strlen($brr[1])==8){
							$new_pair = $brr[0].'='.$brr[1].'T235959';
							$rrule = str_replace($pair,$new_pair,$rrule);
						}				
					}
				}
			}
		}


		return $rrule;
	}
	
	function get_timezone(){
		if(false!==$this->timezone)return $this->timezone;
		//---
		$timezone = get_option('timezone_string');
		if(empty($timezone)){
			$gmt_offset = get_option('gmt_offset');
			if(!empty($gmt_offset)){
				$timezone = timezone_name_from_abbr("", ($gmt_offset*3600), 0);	
			}
		}
		$timezone = empty($timezone) || false===$timezone? 'America/New_York' :$timezone;
		$this->timezone = $timezone;
		//---
		return $timezone;
	}	
}

?>