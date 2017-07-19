<?php
/*
Plugin Name: MembershipWorks Membership, Event & Directory System
Plugin URI: https://membershipworks.com
Description: Membership Works plugin
Version: 5.6
Author: MembershipWorks
Author URI: https://membershipworks.com
License: GPL2
*/

/*  Copyright 2013-2016  SOURCEFOUND INC.  (email : info@sourcefound.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$SF_widgetid=0;
$SF_dat=false;
$SF_css=false;

function sf_api($act,$fn,$param) {
	if ($act!='GET')
		return array('error'=>'Not supported');
	$args=array('headers'=>array('from'=>isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']),'user-agent'=>$_SERVER['HTTP_USER_AGENT']);
	for($try=0;$try<3;$try++) {
		//$ctx=stream_context_create(array('http'=>array('method'=>'GET')));
		//$rsp=file_get_contents('https://api.membershipworks.com/'.$fn.'?'.implode('&',$q),false,$ctx);
		//if(empty($rsp)) usleep(100000); else break;
		$q=array();
		foreach($param as $k=>$v) {
			if (is_array($v)) {
				foreach($v as $i=>$x) $v[$i]=urlencode($x);
				$q[]=$k.'='.implode(',',$v);
			} else {
				$q[]=$k.'='.urlencode($v);
			}
		}
		$rsp=wp_remote_get('https://api.membershipworks.com/'.$fn.'?'.implode('&',$q),$args);
		if (is_wp_error($rsp)) usleep(100000); else break;
	}
	if (is_wp_error($rsp))
		return array('error'=>$rsp->get_error_message());
	else if (empty($rsp['body']))
		return array('error'=>'No response');
	else
		return json_decode($rsp['body'],true);
}

function sf_admin_menu() {
	add_menu_page('MembershipWorks Admin','Membership Works','add_users','sf_admin_page','sf_admin_page','data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB2aWV3Qm94PSIwIDAgNDY2IDQ2NiI+CjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDAwMDAwLDQ2Ni4wMDAwMDApIHNjYWxlKDAuMTAwMDAwLC0wLjEwMDAwMCkiCmZpbGw9IiNGRkZGRkYiIHN0cm9rZT0ibm9uZSI+CjxwYXRoIGQ9Ik0xNzU1IDQxMjQgYy0yNyAtMiAtOTAgLTkgLTE0MCAtMTUgLTU3OSAtNzEgLTEwMDggLTQ2MyAtMTEyMSAtMTAyNAotMjEgLTEwNyAtMjkgLTM1OCAtMTUgLTQ3OCBsMTEgLTk2IC0yNDYgLTUxMSBjLTEzNSAtMjgxIC0yNDQgLTUxMyAtMjQxIC01MTYKMyAtMyAyOSAyNyA1OSA2OCAzMCA0MCAzMDMgNDEzIDYwOCA4MjggMzA0IDQxNSA1NTggNzYxIDU2NSA3NjggOSAxMCAzMCAtNzcKOTUgLTQwNSA0NiAtMjMwIDg2IC00MjEgODkgLTQyNSA0IC00IDE0NSAxODEgMzE1IDQxMiAxNjkgMjMxIDMxMSA0MjAgMzE1CjQyMCA2IDAgMzMzIC0xNjMwIDMzMSAtMTY1MyAwIC00IC04NCAtNiAtMTg3IC01IGwtMTg3IDMgLTg0IDQyOCBjLTQ3IDIzNQotODcgNDI3IC05MSA0MjcgLTMgMCAtMTQ1IC0xOTEgLTMxNiAtNDI0IC0xNzAgLTIzMyAtMzEyIC00MjIgLTMxNCAtNDIwIC0yIDIKLTQxIDE5MSAtODYgNDE5IC00NSAyMjggLTg0IDQxNyAtODcgNDIxIC01IDUgLTM4OCAtMzExIC0zODggLTMyMCAwIC0xMSA2OQotMTUzIDEwMyAtMjExIDM1MCAtNjA5IDk1NSAtMTA3MCAxNjA4IC0xMjI1IDIxMSAtNTAgNTEzIC02NSA3MDQgLTM2IDYwMCA5MgoxMDEzIDQ4OSAxMTA5IDEwNjUgMTggMTA3IDIxIDM1OCA2IDQ2MyBsLTEwIDY2IDI1MCA1MTggYzEzNyAyODUgMjQ3IDUyMCAyNDUKNTIzIC02IDUgOTIgMTM4IC02MzEgLTg0OCBsLTYxOSAtODQ0IC04NSA0MjcgYy00NiAyMzQgLTg4IDQyNSAtOTIgNDI0IC0zIC0yCi0xNDYgLTE5MyAtMzE2IC00MjYgLTIyMCAtMjk4IC0zMTIgLTQxNyAtMzE2IC00MDUgLTggMjcgLTMyNiAxNjM3IC0zMjYgMTY1MQowIDkgNDUgMTIgMTg3IDEwIGwxODggLTMgODQgLTQzMiBjNDcgLTIzOCA4OCAtNDMzIDkxIC00MzMgMyAwIDE0NSAxOTEgMzE1CjQyNCAxNzEgMjMzIDMxMyA0MjEgMzE2IDQxNyA0IC0zIDQzIC0xOTIgODcgLTQyMCA0NSAtMjI3IDgzIC00MTYgODYgLTQxOCA2Ci02IDM4NiAzMTYgMzg2IDMyOCAwIDMxIC0xMzQgMjcwIC0yMjQgMzk5IC0xMzAgMTg4IC0zMzQgNDA2IC01MDYgNTQ0IC0zNDYKMjc2IC03NzAgNDY3IC0xMTU2IDUyMCAtMTE2IDE2IC0yODcgMjUgLTM2OSAyMHoiLz4KPC9nPgo8L3N2Zz4K','2.99');
	add_submenu_page('sf_admin_page','Members','Members','add_users','sf_admin_members','sf_admin_page');
	add_submenu_page('sf_admin_page','Folders','Folders','add_users','sf_admin_folders','sf_admin_page');
	add_submenu_page('sf_admin_page','Labels','Labels &amp; Membership','add_users','sf_admin_labels','sf_admin_page');
	add_submenu_page('sf_admin_page','Event List','Event List','add_users','sf_admin_event-list','sf_admin_page');
	add_submenu_page('sf_admin_page','Event Calendar','Event Calendar','add_users','sf_admin_calendar','sf_admin_page');
	add_submenu_page('sf_admin_page','Forms Carts Donations','Forms Carts Donations','add_users','sf_admin_forms','sf_admin_page');
	add_submenu_page('sf_admin_page','Customization','Customization','add_users','sf_admin_custom','sf_admin_page');
	add_submenu_page('sf_admin_page','Help','Help','add_users','sf_admin_help','sf_admin_page');
	add_submenu_page('sf_admin_page','Organization Settings','Organization Settings','add_users','sf_admin_account','sf_admin_page');
	add_submenu_page('sf_admin_page','Plugin Settings','Plugin Settings','manage_options','sf_admin_options','sf_admin_options');
}

function sf_admin_init() {
	register_setting('sf_admin_group','sf_set','sf_admin_validate');
}

if (is_admin()) {
	add_action('admin_init','sf_admin_init');
	add_action('admin_menu','sf_admin_menu');
}

function sf_admin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	echo '<div class="wrap"><h2>MembershipWorks Plugin Settings</h2>'
		.'<form action="options.php" method="post">';
	settings_fields("sf_admin_group");
	$set=get_option('sf_set');
	echo '<table class="form-table">'
		.'<tr valign="top"><th scope="row">Organization ID</th><td><input type="text" name="sf_set[org]" value="'.(isset($set['org'])?$set['org']:'').'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Facebook API key (optional)</th><td><input type="text" name="sf_set[fbk]" value="'.(isset($set['fbk'])?$set['fbk']:'').'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Google Maps API key (optional)</th><td><input type="text" name="sf_set[map]" value="'.(isset($set['map'])?$set['map']:'').'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Display contact name on cards in directory</th><td><input type="checkbox" name="sf_set[ctc]"'.(empty($set['ctc'])?'':' checked="1"').' /></td></tr>'
		.'<tr valign="top"><th scope="row">Customize text for directory search button</th><td><input type="text" name="sf_set[fnd]" value="'.(empty($set['fnd'])?'Search':$set['fnd']).'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Customize text for directory group email button</th><td><input type="text" name="sf_set[rsp]" placeholder="disabled" value="'.(isset($set['rsp'])?$set['rsp']:'').'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Disable social share buttons</th><td><input type="checkbox" name="sf_set[scl]"'.(empty($set['scl'])?'':' checked="1"').' /></td></tr>'
		.'<tr valign="top"><th scope="row">Load js/css inline</th><td><input type="checkbox" name="sf_set[htm]"'.(empty($set['htm'])?'':' checked="1"').' /></td></tr>'
		.'<tr valign="top"><th scope="row">URL redirect upon signing out</th><td><input type="text" name="sf_set[out]" value="'.(empty($set['out'])?'':$set['out']).'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Page top offset (pixels)</th><td><input type="text" name="sf_set[top]" value="'.(empty($set['top'])?'':$set['top']).'" /></td></tr>'
		.'<tr valign="top"><th scope="row">Member only content login required message</th><td><textarea name="sf_set[mol]" style="width:500px">'.(empty($set['mol'])?'The following content is accessible for members only, please sign in.':$set['mol']).'</textarea></td></tr>'
		.'<tr valign="top"><th scope="row">Member only content membership past due message</th><td><textarea name="sf_set[moe]" style="width:500px">'.(empty($set['moe'])?'The following content is not accessible because your membership has expired.':$set['moe']).'</textarea></td></tr>'
		.'<tr valign="top"><th scope="row">Member only content account no access message</th><td><textarea name="sf_set[mon]" style="width:500px">'.(empty($set['mon'])?'The following content is not accessible for your account.':$set['mon']).'</textarea></td></tr>'
		.'<tr valign="top"><th scope="row">Member only content session expired message</th><td><textarea name="sf_set[moi]" style="width:500px">'.(empty($set['moi'])?'Your session has expired, please sign in again.':$set['moi']).'</textarea></td></tr>'
		.'</table>'
		//.(empty($set['wpl'])?'':('<input type="hidden" name="sf_set[wpl]" value="'.$set['wpl'].'" />'))
		.'<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"></p>'
		.'</form></div>';
}

function sf_admin_validate($in) {
	$in['org']=intval($in['org']);
	$in['org']=($in['org']?strval($in['org']):'');
	if (!empty($in['fbk'])) $in['fbk']=trim($in['fbk']);
	if (!empty($in['map'])) $in['map']=empty($in['map'])?'':trim($in['map']);
	if (!empty($in['fnd'])) $in['fnd']=trim($in['fnd']);
	if (isset($in['adv'])) $in['adv']=trim($in['adv']);
	if (!empty($in['rsp'])) $in['rsp']=trim($in['rsp']);
	if (!empty($in['scl'])) $in['scl']='1'; else unset($in['scl']);
	if (!empty($in['htm'])) $in['htm']='1'; else unset($in['htm']);
	if (!empty($in['ctc'])) $in['ctc']='1'; else unset($in['ctc']);
	return $in; // preserve other fields for $in including wpl
}

function sf_admin_page() {
	global $plugin_page;
	$set=get_option('sf_set');
	switch (substr($plugin_page,9)) {
		case 'members':		$ini='folder/Members'; $hme='folder/Members'; break;
		case 'labels':		$ini='labels'; $hme='labels'; break;
		case 'folders':		$ini='folders'; $hme='folders'; break;
		case 'event-list':	$ini='!event-list'; $hme='!event-list'; break;
		case 'calendar':	$ini='!calendar'; $hme='!calendar'; break;
		case 'forms':		$ini='forms'; $hme='forms'; break;
		case 'custom':		$ini='custom'; $hme='custom'; break;
		case 'help':		$ini='!help'; $hme='!help'; break;
		case 'account': 	$ini='account/manage'; $hme='account'; break;
		default:			$ini='dashboard'; $hme='dashboard'; break;
	}
	echo '<div id="SFctr" class="SF" data-org="10000" data-hme="'.$hme.'" data-ini="'.$ini.'"'.(empty($set)||empty($set['map'])?'':(' data-map="'.$set['map'].'"')).' data-typ="org" data-wpo="options.php" style="position:relative;padding:30px 20px 20px;"></div>'
		.'<script>function sf_admin(){'
			.'var t=document.getElementById("toplevel_page_sf_admin_page");'
			.'if (!t) return;'
			.'var a=t.querySelectorAll(".wp-submenu a"),i,x,n;'
			.'for(i=0;n=a[i];i++){'
				.'x=n.href.split("sf_admin_")[1];'
				.'n.parentNode.className="";'
				.'if (x=="options") continue;'
				.'else if (x=="page"){n.innerHTML="Dashboard";n.parentNode.id="SFhdrdbd";n.href="#dashboard";}'
				.'else if (x=="members"){n.parentNode.id="SFhdrdem";n.href="#folder/Members";}'
				.'else if (x=="labels"){n.parentNode.id="SFhdrlbl";n.href="#labels";}'
				.'else if (x=="folders"){n.parentNode.id="SFhdrdek";n.href="#folders";}'
				.'else if (x=="event-list"){n.parentNode.id="SFhdrevl";n.href="#!event-list";}'
				.'else if (x=="calendar"){n.parentNode.id="SFhdrevc";n.href="#!calendar";}'
				.'else if (x=="forms"){n.parentNode.id="SFhdrfrm";n.href="#forms";}'
				.'else if (x=="help"){n.parentNode.id="SFhdrhlp";n.href="#help";}'
				.'else if (x=="custom"){n.parentNode.id="SFhdrtpl";n.href="#custom";}'
				.'else if (x=="account"){n.parentNode.id="SFhdracc";n.href="#account";}'
			.'}'
		.'}sf_admin();</script>'
		.'<script type="text/javascript" src="//cdn.membershipworks.com/all.js"></script>'
		.'<script>SF.init();</script>';
	if ($set===false||empty($set['org'])) {
		echo '<form id="SFwpo" style="display:none" action="options.php" method="post">';
		settings_fields("sf_admin_group");
		echo '</form>';
	}
}

function sf_enqueue_mfm_script() {
	global $SF_css;
	wp_register_script('sf-mfm','//cdn.membershipworks.com/mfm.js',array(),null);
	if (!empty($SF_css)||!empty($SF_dat)) {
		wp_register_style('sf-css','//cdn.membershipworks.com/all.css');
		wp_enqueue_style('sf-css');
	}
}
add_action('wp_enqueue_scripts','sf_enqueue_mfm_script');

function sf_mfm_init() {
	global $post,$SF_dat,$SF_css;
	if (empty($post)||!is_object($post)) return;
	$arg=func_get_args();
	$set=get_option('sf_set');
	if (empty($set['org'])) return;
	for ($x=false,$i=0,$l=strlen($post->post_content),$mat=array();$i<$l&&(($x=strpos($post->post_content,'[memberfindme open=',$i))!==false||($x=strpos($post->post_content,'[mw open=',$i))!==false);$i=$x+1) {
		$y=strpos($post->post_content,']',$x);
		if ((!$x||substr($post->post_content,$x-1,1)!='[')&&$y!==false) break; // not escaped shortcode and shortcode is closed
	}
	if ($x!==false&&empty($set['htm']))
		$SF_css=true;
	if ($x!==false&&(isset($_GET['_escaped_fragment_'])||preg_match("/googlebot|slurp|msnbot|facebook/i",$_SERVER['HTTP_USER_AGENT'])>0)) {
		$str=substr($post->post_content,$x+1,$y-$x-1);
		$mat=array();
		$opt=array();
		if (preg_match_all('/\s([a-z\-]*)(=("|“|”|&[^;]*;)+.*?("|“|”|&[^;]*;))?/',$str,$mat,PREG_PATTERN_ORDER)&&!empty($mat)&&!empty($mat[1])) 
			foreach ($mat[1] as $key=>$val) $opt[$val]=empty($mat[2][$key])?'':trim(preg_replace('/^=("|“|”|&[^;]*;)*|("|“|”|&[^;]*;)*$/','',$mat[2][$key]));
		if (isset($_GET['_escaped_fragment_'])) {
			$pne=$_GET['_escaped_fragment_'];
			remove_action('wp_head','jetpack_og_tags');
			if (defined('WPSEO_VERSION')) { // Yoast SEO
				global $wpseo_front;
				if (!empty($wpseo_front))
					$tmp=$wpseo_front;
				else if (class_exists('WPSEO_Frontend')&&method_exists(WPSEO_Frontend,'get_instance'))
					$tmp=WPSEO_Frontend::get_instance();
				else
					$tmp=false;
				if (!empty($tmp)) {
					remove_action('wp_head',array($tmp,'head'),1);
					if (method_exists($tmp,'flush_cache')&&remove_action('wp_footer',array($tmp,'flush_cache'),-1))
						ob_end_flush();
				}
			} else if (defined('AIOSEOP_VERSION')) { // All in One SEO
				global $aiosp;
				if (!empty($aiosp))
					remove_action('wp_head',array($aiosp,'wp_head'),apply_filters('aioseop_wp_head_priority',1));
			}
			remove_action('wp_head','rel_canonical');
			remove_action('wp_head','index_rel_link');
			remove_action('wp_head','start_post_rel_link');
			remove_action('wp_head','adjacent_posts_rel_link_wp_head');
			add_action('wp_head','sf_head',0);
		} else if (!empty($opt['open'])) {
			$pne=$opt['open'];
		} else {
			return;
		}
		$qry=array('org'=>$set['org'],'hdr'=>'','dtl'=>'','url'=>get_permalink(),'pne'=>$pne);
		if (!empty($set['ctc'])) $qry['ctc']=1;
		if (!empty($opt['lbl'])) $qry['lbl']=$opt['lbl']; else if (!empty($opt['labels'])) $qry['lbl']=$opt['labels'];
		if (!empty($opt['folder'])) $qry['dek']=$opt['folder'];
		if (isset($opt['evg'])) $qry['evg']=$opt['evg'];
		$SF_dat=sf_api('GET','api',$qry);
		if (empty($SF_dat)||!empty($SF_dat['error']))
			$SF_dat=false;
		else
			$SF_dat['set']=$set;
	}
}
add_filter('wp','sf_mfm_init');

function sf_title() {
	global $SF_dat;
	$arg=func_get_args();
	if (empty($SF_dat)||empty($SF_dat['ttl']))
		return empty($arg)?'':$arg[0];
	if (!empty($arg)&&!empty($arg[2]))
		return ($arg[2]=='left'?($arg[0].' '.(empty($arg[1])?'':($arg[1].' '))):'').$SF_dat['ttl'].($arg[2]=='right'?((empty($arg[1])?'':(' '.$arg[1])).' '.$arg[0]):'');
	return $SF_dat['ttl'];
}
add_filter('wp_title','sf_title',20,3);

function sf_head() {
	global $SF_dat;
	if (!empty($SF_dat)) {
		$out=array();
		if (isset($SF_dat['sum'])) 
			$out[]='<meta name="description" content="'.str_replace('"','&quot;',$SF_dat['sum']).'" />';
		if (isset($SF_dat['ttl'])) {
			$out[]='<meta property="og:site_name" content="'.str_replace('"','&quot;',get_bloginfo('name')).'" />';
			$out[]='<meta property="og:title" content="'.str_replace('"','&quot;',$SF_dat['ttl']).'" />';
		}
		if (isset($SF_dat['img'])) {
			$out[]='<meta property="og:image" content="'.$SF_dat['img'].'" />';
			$out[]='<meta property="og:image:secure_url" content="'.str_replace('http://','https://',$SF_dat['img']).'" />';
		}
		if (isset($SF_dat['sum'])) {
			$out[]='<meta property="og:description" content="'.str_replace('"','&quot;',$SF_dat['sum']).'" />';
		}
		if (isset($_GET['_escaped_fragment_'])&&isset($SF_dat['rel'])) {
			$out[]='<meta property="og:url" content="'.$SF_dat['rel'].'" />';
			$out[]='<link rel="canonical" href="'.$SF_dat['rel'].'" />';
		}
		if (isset($SF_dat['nxt'])) 
			$out[]='<link rel="next" href="'.$SF_dat['nxt'].'" />';
		if (isset($SF_dat['prv'])) 
			$out[]='<link rel="prev" href="'.$SF_dat['prv'].'" />';
		echo implode("\r\n",$out).(count($out)?"\r\n":'');
	}
}

//function sf_header() {
//	global $post;
//	if (empty($post)||!is_object($post)) return;
//	if(strpos($post->post_content,'[memberonly')!==false) {
//		if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE',true);
//		nocache_headers();
//	}
//}
//add_action('get_header','sf_header');

function sf_shortcode($content) {
	global $SF_dat;
	$opn=false;
	$set=get_option('sf_set');
	$wpl=defined('SF_WPL')?preg_replace('/^http[s]?:\\/\\/[^\\/]*/','',SF_WPL>=3?admin_url('admin-ajax.php'):site_url('wp-login.php','login_post')):(empty($set['wpl'])?'':$set['wpl']);
	$lbl=array();
	$dek=array();
	// process memberonly shortcodes - first pass - eliminate admins, obtain labels to test for
	if (!defined('SF_WPL')||SF_WPL>=5) for ($i=0;$i<strlen($content)&&($x=strpos($content,'[memberonly',$i))!==false;) {
		$y=strpos($content,']',$x);
		if (($x>0&&substr($content,$x-1,1)=='[')||$y===false) { $i=$x+1; continue; } // escaped shortcode or shortcode not closed
		if (!defined('DONOTCACHEPAGE'))
			define('DONOTCACHEPAGE',true);
		if (($z=strpos($content,'[/memberonly]',$y))===false) { $z=strlen($content); $l=$z-$y-1; } else { $l=$z-$y-1; $z+=13; }
		$str=substr($content,$x+1,$y-$x-1);
		$mat=array();
		$opt=array();
		if (preg_match_all('/\s([a-z\-]*)(=("|“|”|&[^;]*;)+.*?("|“|”|&[^;]*;))?/',$str,$mat,PREG_PATTERN_ORDER)&&!empty($mat)&&!empty($mat[1])) foreach($mat[1] as $key=>$val)
			$opt[$val]=empty($mat[2][$key])?'':trim(preg_replace('/^=("|“|”|&[^;]*;)*|("|“|”|&[^;]*;)*$/','',$mat[2][$key]));
		if (empty($set)||empty($set['org'])) {
			$out='Organization key not setup. Please update settings.';
		} else if (current_user_can('edit_post',get_the_ID())) {
			$tmp=array();
			foreach ($opt as $key=>$val) $tmp[]=$key.'="'.$val.'"';
			$out='[administrator notice: content below memberonly '.implode(' ',$tmp).']'
				.substr($content,$y+1,$l);
		} else {
			if (!empty($opt['label'])||!empty($opt['level'])) {
				$arr=explode(',',empty($opt['label'])?$opt['level']:$opt['label']);
				foreach ($arr as $val) if (trim(urldecode($val))) $lbl[]=strtolower(trim(urldecode($val)));
			} else if (!empty($opt['folder'])||!empty($opt['folders'])) {
				$arr=explode(',',empty($opt['folder'])?$opt['folders']:$opt['folder']);
				foreach ($arr as $val) if (trim(urldecode($val))) $dek[]=strtolower(trim(urldecode($val)));
			} else {
				$dek[]='members';
			}
			$i=$z+1;
			continue;
		}
		$content=substr_replace($content,$out,$x,$z-$x);
		$i=$x+strlen($out);
	}
	// check if user has required labels
	if (!empty($_SERVER)&&!empty($_SERVER['HTTP_COOKIE'])&&preg_match('/^SFSF=[^;]*|\\sSFSF=[^;]*/',$_SERVER['HTTP_COOKIE'],$_sf))
		$_sf=preg_replace('/\\s|\\+/','',substr($_sf[0],strpos($_sf[0],'=')+1));
	else if (!empty($_COOKIE['SFSF']))
		$_sf=strlen($_COOKIE['SFSF'])<2?'':$_COOKIE['SFSF'];
	else
		$_sf='';
	if (!$_sf||(empty($lbl)&&empty($dek))) {
		$usr=false;
	} else {
		$tmp=array('org'=>$set['org'],'sfsf'=>$_sf);
		if (!empty($lbl)) $tmp['lbl']=array_values(array_unique($lbl));
		if (!empty($dek)) $tmp['dek']=array_values(array_unique($dek));
		$usr=sf_api('GET','v1/lbl',$tmp);
		if (empty($usr))
			$usr=array('error'=>true);
		else if (!empty($usr['lbl'])) {
			foreach($usr['lbl'] as $i=>$x) {
				if ($x['typ']==1)
					$usr['_dek'][]=strtolower($x['lbl']);
				else
					$usr['_lbl'][]=strtolower($x['lbl']);
			}
		}
	}
	// process memberonly shortcodes - second pass				
	if (!empty($lbl)||!empty($dek)) for ($i=0;$i<strlen($content)&&($x=strpos($content,'[memberonly',$i))!==false;) {
		$y=strpos($content,']',$x);
		if (($x>0&&substr($content,$x-1,1)=='[')||$y===false) { $i=$x+1; continue; } // escaped shortcode or shortcode not closed
		if (($z=strpos($content,'[/memberonly]',$y))===false) { $z=strlen($content); $l=$z-$y-1; } else { $l=$z-$y-1; $z+=13; }
		$str=substr($content,$x+1,$y-$x-1);
		$mat=array();
		$opt=array();
		if (preg_match_all('/\s([a-z\-]*)(=("|“|”|&[^;]*;)+.*?("|“|”|&[^;]*;))?/',$str,$mat,PREG_PATTERN_ORDER)&&!empty($mat)&&!empty($mat[1])) foreach($mat[1] as $key=>$val)
			$opt[$val]=empty($mat[2][$key])?'':trim(preg_replace('/^=("|“|”|&[^;]*;)*|("|“|”|&[^;]*;)*$/','',$mat[2][$key]));
		if (!empty($usr)&&!empty($usr['error'])&&$usr['error']!='No response') {
			$out=$usr['error'];
		} else {
			if (empty($usr)) {
				$msg=isset($opt['message'])?$opt['message']:(empty($set['mol'])?'The following content is accessible for members only, please sign in.':$set['mol']);
			} else if (!empty($usr['error'])) {
				$msg=isset($opt['message'])?$opt['message']:(empty($set['moi'])?'Your session has expired, please sign in again.':$set['moi']);
			} else if (!empty($usr['end'])) {
				$msg=isset($opt['message'])?$opt['message']:(empty($set['moe'])?'The following content is not accessible because your membership has expired.':$set['moe']);
			} else {
				$msg=isset($opt['message'])?$opt['message']:(empty($set['mon'])?'The following content is not accessible for your account.':$set['mon']);
				if (!empty($opt['label'])||!empty($opt['level'])) {
					$arr=explode(',',empty($opt['label'])?$opt['level']:$opt['label']);
					foreach ($arr as $key=>$val) $arr[$key]=strtolower(trim(urldecode($val)));
					if (!empty($usr['_lbl'])&&count(array_intersect($usr['_lbl'],$arr))) $msg=false;
				} else if (!empty($opt['folder'])||!empty($opt['folders'])) {
					$arr=explode(',',empty($opt['folder'])?$opt['folders']:$opt['folder']);
					foreach ($arr as $key=>$val) $arr[$key]=strtolower(trim(urldecode($val)));
					if (!empty($usr['_dek'])&&count(array_intersect($usr['_dek'],$arr))) $msg=false;
				} else {
					if (!empty($usr['_dek'])&&in_array('members',$usr['_dek'])) $msg=false;
				}
			}
			if ($msg===false&&isset($opt['false'])) {
				$out='';
			} else if ($msg===false||isset($opt['false'])) {
				$out=trim(preg_replace('/^<br(\\s\\/)?>|<br(\\s\\/)?>$/','',substr($content,$y+1,$l)));
			} else if (is_singular()&&!empty($opt['nonmember-redirect'])) {
				$out=(isset($opt['nomessage'])?'':('<span class="memberonly">'.__($msg).'</span>'))
					.'<script>setTimeout(\'window.location="'.esc_url($opt['nonmember-redirect']).'"\',2000);</script>';
				$opn=true;
			} else if (is_singular()&&!$opn&&!empty($opt['nonmember'])) {
				$out=(isset($opt['nomessage'])?'':('<div class="memberonly" style="margin-bottom:20px">'.__($msg).'</div>'))
					.'[mw open="'.$opt['nonmember'].'"]';
			} else if (is_singular()&&!$opn&&empty($usr)&&!isset($opt['nologin'])) {
				$out='<div class="memberonlywrapper" style="padding:40px 0 0;margin:40px 0;border-top:1px solid #ddd;border-bottom:1px solid #ddd">'
					.(isset($opt['nomessage'])?'':('<div class="memberonly" style="margin-bottom:20px">'.__($msg).'</div>'))
					.'<div id="SFctr" class="SF" data-sfi="1" data-org="'.$set['org'].'" data-ini="myaccount" data-zzz="'.esc_url(get_permalink()).'"'
					.(empty($wpl)?'':' data-wpl="'.esc_url($wpl).'"')
					.' style="position:relative;height:auto;margin-bottom:40px">'
					.'<div id="SFpne" style="position:relative"><div class="SFpne">Loading...</div></div>'
					.'<div style="clear:both"></div>'
					.(empty($set['htm'])?'':'<script type="text/javascript" src="//cdn.membershipworks.com/mfm.js" defer="defer"></script>')
					.'</div></div>';
				if (empty($set['htm']))
					wp_enqueue_script('sf-mfm');
				$opn=true;
			} else {
				$out=(isset($opt['nomessage'])?'':('<span class="memberonly">'.__($msg).'</span>'));
			}
		}
		$content=substr_replace($content,$out,$x,$z-$x);
		$i=$x+strlen($out);
	}
	// process mw shortcodes
	for ($i=0;$i<strlen($content)&&(($x=strpos($content,'[memberfindme ',$i))!==false||($x=strpos($content,'[mw ',$i))!==false);) {
		$y=strpos($content,']',$x);
		if (($x>0&&substr($content,$x-1,1)=='[')||$y===false) { $i=$x+1; continue; } // escaped shortcode or shortcode not closed
		$str=substr($content,$x+1,$y-$x-1);
		$mat=array();
		$opt=array();
		if (!preg_match_all('/\s([a-z\-]*)(=("|“|”|&[^;]*;)+.*?("|“|”|&[^;]*;))?/',$str,$mat,PREG_PATTERN_ORDER)||empty($mat)||empty($mat[1])) { $i=$x+1; continue; }
		foreach ($mat[1] as $key=>$val) $opt[$val]=empty($mat[2][$key])?'':trim(preg_replace('/^=("|“|”|&[^;]*;)*|("|“|”|&[^;]*;)*$/','',$mat[2][$key]));
		// create output
		if (empty($set)||empty($set['org'])) {
			$out='Organization key not setup. Please update settings';
		} else if (!$opn&&isset($opt['open'])) {
			if (!empty($SF_dat)) {
				$out='<div id="SFctr" class="SF" style="'.(isset($opt['style'])?$opt['style']:'position:relative;height:auto').'">'
					.'<div id="SFpne" style="position:relative">'.$SF_dat['dtl'].'</div><div style="clear:both"></div></div>';
			} else {
				$out=(empty($set['htm'])?'':'<div style="display:none"><script>if(typeof(SF)=="object"&&SF.close)SF.close();</script></div>')
					.'<div id="SFctr" class="SF" data-org="'.$set['org'].'" data-ini="'.$opt['open'].'"'
					.(empty($set['pay'])?'':(' data-pay="'.$set['pay'].'"'))
					.(empty($set['map'])?'':(' data-map="'.$set['map'].'"'))
					.(empty($set['fbk'])?'':(' data-fbk="'.$set['fbk'].'"'))
					.(empty($set['fnd'])?'':(' data-fnd="'.$set['fnd'].'"'))
					.(empty($set['rsp'])?'':(' data-rsp="'.$set['rsp'].'"'))
					.(empty($set['ctc'])?'':(' data-ctc="1"'))
					.(empty($set['scl'])&&empty($opt['noshare'])?'':(' data-scl="0"'))
					.(empty($set['out'])?'':(' data-out="'.$set['out'].'"'))
					.(empty($set['top'])?'':(' data-top="'.$set['top'].'"'))
					.(empty($wpl)?'':' data-wpl="'.esc_url($wpl).'"')
					.(empty($opt['lbl'])&&empty($opt['labels'])?'':(' data-lbl="'.esc_attr(empty($opt['lbl'])?$opt['labels']:$opt['lbl']).'"'))
					.(empty($opt['folder'])?'':(' data-dek="'.esc_attr($opt['folder']).'"'))
					.(empty($opt['levels'])?'':(' data-lvl="'.esc_attr($opt['levels']).'"'))
					.(isset($opt['evg'])?(' data-evg="'.esc_attr($opt['evg']).'"'):'')
					.(isset($opt['viewport'])&&$opt['viewport']=='fixed'?(' data-ofy="1"'):'')
					.(isset($opt['redirect'])?(' data-zzz="'.$opt['redirect'].'"'):'')
					.(isset($opt['checkout'])?(' data-zgo="'.$opt['checkout'].'"'):'')
					.(isset($opt['ini'])&&$opt['ini']=='0'?'':' data-sfi="1"')
					.' style="'.(isset($opt['style'])?$opt['style']:'position:relative;height:auto').'">'
					.'<div id="SFpne" style="position:relative">'.(isset($opt['ini'])&&$opt['ini']=='0'?'':'<div class="SFpne">Loading...</div>').'</div>'
					.'<div style="clear:both"></div>'
					.(empty($set['htm'])?'':'<script type="text/javascript" src="//cdn.membershipworks.com/mfm.js" defer="defer"></script>')
					.'</div>';
				if (empty($set['htm']))
					wp_enqueue_script('sf-mfm');
			}
			if (!defined('DONOTCACHEPAGE'))
				define('DONOTCACHEPAGE',true);
			$opn=true;
		} else if (isset($opt['button'])) { 
			$out=(isset($opt['type'])?('<'.$opt['type']):'<button')
				.(isset($opt['type'])&&$opt['type']=='img'&&isset($opt['src'])?(' src="'.$opt['src'].'"'):'')
				.(isset($opt['class'])?(' class="'.$opt['class'].'"'):'')
				.(isset($opt['style'])?(' style="'.$opt['style'].'"'):' style="cursor:pointer;"')
				.($opt['button']=='account'?(' onmouseout="if(typeof(SF)!=\'undefined\')SF.usr.account(event,this);" onmouseover="if(typeof(SF)!=\'undefined\')SF.usr.account(event,this);" onclick="if(typeof(SF)!=\'undefined\')SF.usr.account(event,this);">'.(isset($opt['text'])?$opt['text']:'My Account')):'')
				.($opt['button']=='join'?(' onclick="if(typeof(SF)!=\'undefined\')SF.open(\'account/join\');">'.(isset($opt['text'])?$opt['text']:'Join')):'')
				.(isset($opt['type'])?($opt['type']=='img'?'':('</'.$opt['type'].'>')):'</button>');
		} else if (isset($opt['join'])) {
			$out=(isset($opt['type'])?('<'.$opt['type']):'<a')
				.(isset($opt['type'])&&$opt['type']=='img'&&isset($opt['src'])?(' src="'.$opt['src'].'"'):'')
				.(isset($opt['class'])?(' class="'.$opt['class'].'"'):'')
				.(isset($opt['style'])?(' style="'.$opt['style'].'"'):' style="cursor:pointer;"')
				.(isset($opt['type'])&&$opt['type']!='a'?(' onclick="window.location.hash=\'account/join/'.$opt['join'].'\';if(typeof(SF)!=\'undefined\')setTimeout(\'SF.init()\',50);">'):(' onclick="if(typeof(SF)!=\'undefined\')setTimeout(\'SF.init()\',50)" href="#account/join/'.$opt['join'].'">'))
				.(isset($opt['text'])?$opt['text']:'Join')
				.(isset($opt['type'])?($opt['type']=='img'?'':('</'.$opt['type'].'>')):'</a>');
		} else if (isset($opt['name'])||isset($opt['check'])) {
			if (!isset($usl))
				$usl=!empty($wpl)&&is_user_logged_in()&&get_user_meta(get_current_user_id(),'SF_ID',true)?wp_get_current_user():false;
			$out=(isset($opt['name'])?'<span class="SFnam">'.(empty($usl)?'':$usl->display_name).'</span>':'')
				.($opn||(isset($opt['name'])&&!empty($usl))?'':'<script>(function(){var i,j,a,x;try{x=localStorage.getItem("SF_nam");}catch(e){x="";}try{for(a=document.querySelectorAll(".SFnam"),i=a.length-1;i>=0;i--)a[i].innerHTML=x?x:"";}catch(e){}try{for(a=document.querySelectorAll(".SF_li"),i=a.length-1;i>=0;i--)a[i].style.display=x?"":"none";}catch(e){}try{for(a=document.querySelectorAll(".SF_lo"),i=a.length-1;i>=0;i--)a[i].style.display=x?"none":"";}catch(e){}})();</script>');
			if (!defined('DONOTCACHEPAGE'))
				define('DONOTCACHEPAGE',true);
		} else if (isset($opt['listlabel'])||isset($opt['listfolder'])) {
			$dat=sf_api('GET','v1/dek',array('org'=>$set['org'],'wem'=>1,'typ'=>isset($opt['listlabel'])?3:1,'lbl'=>isset($opt['listlabel'])?$opt['listlabel']:$opt['listfolder']));
			if (!empty($dat)&&!empty($dat['error']))
				$out=$dat['error'];
			else {
				$out=array();
				if (!empty($dat)) foreach($dat as $usr)
					$out[]='<li><a href="'.$usr['url'].'">'.$usr['nam'].'</a></li>';
				$out='<ul class="sf_list">'.implode('',$out).'</ul>';
			}
		} else if (isset($opt['listevents'])) {
			$dat=sf_api('GET','v1/evt',array('org'=>$set['org'],'wee'=>1,'grp'=>$opt['listevents'],'cnt'=>isset($opt['count'])?$opt['count']:'5','sdp'=>time()));
			if (!empty($dat)&&!empty($dat['error']))
				$out=$dat['error'];
			else {
				$out=array();
				if (!empty($dat)) foreach ($dat as $evt) {
					$te=explode(',',$evt['ezp']);
					$ts=explode(',',$evt['szp']);
					if (!empty($evt['ezp'])&&$te[0]==$ts[0]) $evt['ezp']=trim($te[1]);
					$out[]='<li><a href="'.$evt['url'].'">'.$evt['ttl'].'</a><div class="event-when"><span class="event-start">'.$evt['szp'].'</span>'.(isset($evt['ezp'])&&$evt['ezp']?('<span class="event-sep"> - </span><span class="event-end">'.$evt['ezp'].'</span>'):'').'</div></li>';
				}
				$out='<ul class="sf_list">'.implode('',$out).'</ul>';
			}
		} else if (isset($opt['eventwidget'])) {
			$out=sf_widget_event_do(array_merge($opt,array('org'=>$set['org'])));
		} else if (isset($opt['folderwidget'])) {
			$out=sf_widget_folder_do(array_merge($opt,array('org'=>$set['org'])));
		} else
			$out='';
		$content=substr_replace($content,$out,$x,$y-$x+1);
		$i=$x+strlen($out);
	}
	return $content;
}
add_filter('the_content','sf_shortcode',10);
add_filter('the_content','sf_shortcode',99);
add_filter('widget_text','sf_shortcode',1); 

function sf_widget_event_do($instance) {
	if (empty($instance['org']))
		return '<div>No organization ID</div>';
	$instance=wp_parse_args($instance,array('grp'=>'','cnt'=>'3'));
	$dat=sf_api('GET','v1/evt',array('org'=>$instance['org'],'wee'=>1,'grp'=>$instance['grp'],'cnt'=>$instance['cnt'],'sdp'=>time()));
	if (empty($dat))
		return '<div>No current events</div>';
	if (!empty($dat)&&!empty($dat['error']))
		return '<div>'.$dat['error'].'</div>';
	$out=array();
	foreach ($dat as $x) {
		$ts=explode(',',$x['szp']);
		if (empty($instance['szp'])&&!empty($x['ezp'])) {
			$te=explode(',',$x['ezp']);
			if ($te[0]==$ts[0]) $x['ezp']=trim($te[1]);
		}
		$out[]='<li class="event-item">'
			.'<a class="event-link" href="'.$x['url'].'">'
				.(empty($x['lgo'])||empty($instance['lgo'])?'':('<img class="event-thumb" src="//d1tif55lvfk8gc.cloudfront.net/'.$x['_id'].'s.jpg?'.$x['lgo'].'" style="max-width:100%"/>'))
				.$x['ttl']
			.'</a>'
			.(empty($instance['szp'])||(empty($instance['exp'])&&!empty($x['ezp']))?('<div class="event-when">'
				.(empty($instance['szp'])?('<span class="event-start">'.$x['szp'].'</span>'):'')
				.(empty($instance['szp'])&&empty($instance['ezp'])&&!empty($x['ezp'])?'<span class="event-sep"> - </span>':'')
				.(empty($instance['ezp'])&&!empty($x['ezp'])?('<span class="event-end">'.$x['ezp'].'</span>'):'')
			.'</div>'):'')
			.(empty($instance['adn'])||empty($x['adn'])?'':('<div class="event-where">'.$x['adn'].'</div>'))
			.'</li>';
	}
	return '<ul class="sf_widget_event_list" style="display:block;position:relative">'.implode($out).'</ul>';
}

class sf_widget_event extends WP_Widget {
	public function __construct() {
		parent::__construct('sf_widget_event','Upcoming Events',array('description'=>'Upcoming events from your MembershipWorks calendar'));
	}
	public function widget($args,$instance ) {
		extract($args);
		$set=get_option('sf_set');
		$title=apply_filters('widget_title',$instance['title']);
		if (empty($title))
			echo str_replace('widget_sf_widget_event','widget_sf_widget_event widget_no_title',$before_widget);
		else
			echo $before_widget.$before_title.$title.$after_title;
		echo sf_widget_event_do(array_merge($instance,array('org'=>$set['org'])));
		echo $after_widget;
	}
	public function update($new_instance,$old_instance ) {
		$instance=$old_instance;
		$instance['title']=strip_tags($new_instance['title']);
		$instance['grp']=isset($new_instance['grp'])?$new_instance['grp']:'';
		$instance['cnt']=$new_instance['cnt']?strval(intval($new_instance['cnt'])):'0';
		if (empty($new_instance['lgo'])) unset($instance['lgo']); else $instance['lgo']=1;
		if (empty($new_instance['adn'])) unset($instance['adn']); else $instance['adn']=1;
		if (empty($new_instance['szp'])) $instance['szp']=1; else unset($instance['szp']);
		if (empty($new_instance['ezp'])) $instance['ezp']=1; else unset($instance['ezp']);
		return $instance;
	}
	public function form($instance) {
		$instance=wp_parse_args($instance,array('title'=>'','grp'=>'','cnt'=>'3'));
		$title=strip_tags($instance['title']);
		$grp=$instance['grp'];
		$cnt=intval($instance['cnt']);
		echo '<p><label for="'.$this->get_field_id('title').'">Title:</label> <input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'" /></p>'
			.'<p><label for="'.$this->get_field_id('grp').'">Group number (blank=all):</label> <input id="'.$this->get_field_id('grp').'" name="'.$this->get_field_name('grp').'" type="text" value="'.$grp.'" size="3"/></p>'
			.'<p><label for="'.$this->get_field_id('cnt').'">Number of events to show:</label> <input id="'.$this->get_field_id('cnt').'" name="'.$this->get_field_name('cnt').'" type="text" value="'.$cnt.'" size="3"/></p>'
			.'<p><label for="'.$this->get_field_id('lgo').'">Display images:</label> <input id="'.$this->get_field_id('lgo').'" name="'.$this->get_field_name('lgo').'" type="checkbox" value="1"'.(empty($instance['lgo'])?'':' checked').'/></p>'
			.'<p><label for="'.$this->get_field_id('adn').'">Display location:</label> <input id="'.$this->get_field_id('adn').'" name="'.$this->get_field_name('adn').'" type="checkbox" value="1"'.(empty($instance['adn'])?'':' checked').'/></p>'
			.'<p><label for="'.$this->get_field_id('szp').'">Display start date/time:</label> <input id="'.$this->get_field_id('szp').'" name="'.$this->get_field_name('szp').'" type="checkbox" value="1"'.(empty($instance['szp'])?' checked':'').'/></p>'
			.'<p><label for="'.$this->get_field_id('ezp').'">Display end date/time:</label> <input id="'.$this->get_field_id('ezp').'" name="'.$this->get_field_name('ezp').'" type="checkbox" value="1"'.(empty($instance['ezp'])?' checked':'').'/></p>';
	}
}

function sf_widget_folder_do($instance) {
	global $SF_widgetid;
	if (empty($instance['org']))
		return '<div>No organization ID</div>';
	$instance=wp_parse_args($instance,array('typ'=>'1','lbl'=>'Members','act'=>'0','delay'=>'10','nam'=>''));
	$dat=sf_api('GET','v1/dek',array('org'=>$instance['org'],'wem'=>1,'typ'=>empty($instance['typ'])?'1':$instance['typ'],'lbl'=>$instance['lbl']));
	if (!empty($dat)&&!empty($dat['error']))
		return '<div>'.$dat['error'].'</div>';
	$out=array();
	if (!empty($dat)) foreach($dat as $x) {
		if ($instance['act']=='1')
			$out[]='<li style="display:none;background-color:white;text-align:center;height:148px;padding:0;margin:0;table-layout:fixed;width:100%;"><a href="'.esc_attr($x['url']).'" style="display:table-cell;vertical-align:middle;padding:10px;text-decoration:none;">'
				.($x['lgo']?('<div class="member-image"><img src="//cdn.membershipworks.com/u/'.$x['_id'].'_lgl.jpg?'.$x['lgo'].'" alt="'.esc_attr($x['nam']).'" onerror="this.parentNode.innerHTML=this.alt;" style="display:block;margin:0 auto;max-width:100%;max-height:75px;"></div>'):'')
				.($x['lgo']&&empty($instance['nam'])?'':('<div class="member-name" style="display:block;width:100%;font-size:'.($x['lgo']?'1.1em':'1.5em').'">'.esc_html(html_entity_decode($x['nam'],ENT_HTML5|ENT_QUOTES)).'</div>'))
				.'<small class="member-tagline" style="display:block;padding:10px;">'.esc_html(html_entity_decode($x['cnm'],ENT_HTML5|ENT_QUOTES)).'</small></a></li>';
		else
			$out[]='<li><a href="'.esc_attr($x['url']).'">'.esc_html(html_entity_decode($x['nam'],ENT_HTML5|ENT_QUOTES)).'</a><small class="cnm" style="display:block;">'.esc_html(html_entity_decode($x['cnm'],ENT_HTML5|ENT_QUOTES)).'</small></li>';
	}
	$id=empty($instance['wid'])?('sf-widget-'.($SF_widgetid++)):$instance['wid'];
	if ($instance['act']=='1') {
		$delay=intval($instance['delay'])*1000;
		$fn=str_replace('-','_',$id);
		return '<ul id="'.$id.'" class="sf_widget_folder_logos" style="list-style:none;margin:0;padding:5px">'.implode($out).'</ul>'
			.(empty($out)?'':('<script>'.$fn.'_animate=function(){var r=document.getElementById("'.$id.'"),x=r.querySelector(\'li[style*="table;"]\');if(x){x.style.display="none";x=(x.nextSibling?x.nextSibling:r.firstChild);}else x=r.childNodes[Math.round(Math.random()*(r.childNodes.length-1))];if(x)x.style.display="table";setTimeout('.$fn.'_animate,'.($delay?$delay:10000).');};'.$fn.'_animate();</script>'));
	} else {
		return '<ul id="'.$id.'" class="sf_widget_folder_list">'.implode($out).'</ul>';
	}
}

class sf_widget_folder extends WP_Widget {
	public function __construct() {
		parent::__construct('sf_widget_folder','Members/Folder Widget',array('description'=>'Display contacts from your MembershipWorks folder or label'));
	}
	public function widget($args,$instance ) {
		extract($args);
		$set=get_option('sf_set');
		$title=apply_filters('widget_title',$instance['title']);
		if (empty($title))
			echo str_replace('widget_sf_widget_folder','widget_sf_widget_folder widget_no_title',$before_widget);
		else
			echo $before_widget.$before_title.$title.$after_title;
		echo sf_widget_folder_do(array_merge($instance,array('org'=>$set['org'],'wid'=>($this->id).'-list')));
		echo $after_widget;
	}
	public function update($new_instance,$old_instance ) {
		$instance=$old_instance;
		$instance['title']=strip_tags($new_instance['title']);
		$instance['lbl']=trim($new_instance['lbl']);
		$instance['typ']=strval(intval($new_instance['typ']));
		$instance['act']=strval(intval($new_instance['act']));
		$instance['delay']=strval(intval($new_instance['delay']));
		if (empty($new_instance['nam']))
			unset($instance['nam']);
		else
			$instance['nam']=1;
		return $instance;
	}
	public function form($instance) {
		$instance=wp_parse_args($instance,array('title'=>'','typ'=>'1','lbl'=>'Members','act'=>'0','delay'=>'10','nam'=>''));
		$title=strip_tags($instance['title']);
		echo '<p><label for="'.$this->get_field_id('title').'">Title:</label> <input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'" /></p>'
			.'<p><label for="'.$this->get_field_id('lbl').'">Folder/label name:</label> <input class="widefat" id="'.$this->get_field_id('lbl').'" name="'.$this->get_field_name('lbl').'" type="text" value="'.esc_attr($instance['lbl']).'" /></p>'
			.'<p><label for="'.$this->get_field_id('typ').'">Type:</label> <select id="'.$this->get_field_id('typ').'" name="'.$this->get_field_name('typ').'">'
				.'<option value="1"'.($instance['typ']=='1'?' selected="selected"':'').'>Public folder</option>'
				.'<option value="3"'.($instance['typ']=='3'?' selected="selected"':'').'>Publicly searchable label</option>'
			.'</select></p>'
			.'<p><label for="'.$this->get_field_id('act').'">Display:</label> <select id="'.$this->get_field_id('act').'" name="'.$this->get_field_name('act').'" onchange="this.parentNode.nextSibling.style.display=(this.value==\'1\'?\'\':\'none\');">'
				.'<option value="0"'.($instance['act']=='0'?' selected="selected"':'').'>List</option>'
				.'<option value="1"'.($instance['act']=='1'?' selected="selected"':'').'>Slideshow</option>'
			.'</select></p>'
			.'<div'.($instance['act']=='1'?'>':' style="display:none;">')
				.'<p><label for="'.$this->get_field_id('delay').'">Seconds between slides:</label> <input id="'.$this->get_field_id('delay').'" name="'.$this->get_field_name('delay').'" type="text" value="'.$instance['delay'].'" size="3"/></p>'
				.'<p><label for="'.$this->get_field_id('nam').'">Always display name:</label> <input id="'.$this->get_field_id('nam').'" name="'.$this->get_field_name('nam').'" type="checkbox" value="1"'.(empty($instance['nam'])?'':' checked').'/></p>'
			.'</div>';
	}
}

function sf_widgets_init() {
	register_widget('sf_widget_event');
	register_widget('sf_widget_folder');
}
add_action('widgets_init','sf_widgets_init');

?>