<?php
	// Exit if accessed directly 
	if (! defined('DUPLICATOR_INIT')) {
		$_baseURL = "http://" . strlen($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location:$_baseURL");
		exit; 
	}
?>
<style>
	body {font-family:"Open Sans",sans-serif;}
	body,td,th {font-size:13px;color:#000;}
	fieldset {border:1px solid silver; border-radius:5px; padding:10px}
	h3 {margin:1px; padding:1px; font-size:14px;}
	a {color:#222}
	a:hover{color:gray}
	input[type=text] { width:500px; border-radius:3px; height:17px; font-size:12px; border:1px solid silver;}
	input.readonly {background-color:#efefef;}
	i.small {font-size:11px}

	/* ============================
	COMMON VIEW ELEMENTS*/
	div#content {border:1px solid #CDCDCD;  width:750px; min-height:550px; margin:auto; margin-top:18px; border-radius:5px;  box-shadow:0 8px 6px -6px #333;}
	div#content-inner {padding:10px 30px; min-height:550px}
	form.content-form {min-height:550px; position:relative; line-height:17px}	
	div.dup-logfile-link {float:right; font-weight:normal; font-size:12px}
	
	/* WIZARD STEPS */
	table.header-wizard {border-top-left-radius:5px; border-top-right-radius:5px; width:100%; box-shadow:0 6px 4px -4px #777;	background-color:#F1F1F1}
	div#dup-wiz {padding:0px; margin:7px 0 10px 20px; height:20px }
	div#dup-wiz-steps {margin:0px 0 0 10px; padding:0px;  clear:both; font-weight:bold;font-size:12px; min-width:250px }
	#dup-wiz span {display:block;float:left; text-align:center; width:15px; margin:3px 4px 0 0px; line-height:15px; color:#ccc; border:1px solid #CCCCCC; border-radius:4px;}
	/* WIZ-DEFAULT*/
	#dup-wiz a { position:relative; display:block; width:auto; height:24px; margin-right:18px; padding:0px 10px 0 3px; float:left;  line-height:24px; color:#000; background:#E4E4E4; }
	#dup-wiz a:before { width:0px; height:0px; border-top:12px solid #E4E4E4; border-bottom:12px solid #E4E4E4; border-left:12px solid transparent; position:absolute; content:""; top:0px; left:-12px; }
	#dup-wiz a:after { width:0; height:0; border-top:12px solid transparent; border-bottom:12px solid transparent; border-left:12px solid #E4E4E4; position:absolute; content:""; top:0px; right:-12px; }
	/* WIZ-COMPLETED */
	#dup-wiz .completed-step a {color:#ccc; background:#999;}
	#dup-wiz .completed-step a:before {border-top:12px solid #999; border-bottom:12px solid #999;}
	#dup-wiz .completed-step a:after {border-left:12px solid #999;}
	#dup-wiz .completed-step span {color:#ccc;}
	/* WIZ-ACTIVE */
	#dup-wiz .active-step a {color:#fff; background:#999;}
	#dup-wiz .active-step a:before {border-top:12px solid #999; border-bottom:12px solid #999;}
	#dup-wiz .active-step a:after {border-left:12px solid #999;}
	#dup-wiz .active-step span {color:#fff;}
	
	/*Help */
	select#dup-hlp-lnk {border-radius:3px; font-size:11px; margin:3px 5px 0 0px; background-color:#efefef; border:1px solid silver}
	div.dup-help-page {padding:5px 0 0 5px}
	div.dup-help-page fieldset {margin-bottom:25px}
	div#dup-main-help {line-height:18px}
	div#dup-main-help h3 {background-color:#dfdfdf; border:1px solid silver; border-radius:5px; padding:3px; margin-bottom:8px;}

	div#progress-area {padding:5px; margin:150px 0 0 0px; text-align:center;}
	div#ajaxerr-data {padding:5px; height:350px; width:99%; border:1px solid silver; border-radius:5px; background-color:#efefef; font-size:14px; overflow-y:scroll}
	div.hdr-main {font-size:18px; padding:0 0 5px 0; border-bottom:1px solid #999; font-weight:bold; margin:5px 0 10px 0;}
	div.hdr-sub {font-size:15px; padding:2px 2px 2px 0; border-bottom:1px solid #dfdfdf; font-weight:bold; margin-bottom:5px;}
	
	/*BOXES:Expandable sections */
	div.dup-box {padding:0px; display:block; background-color:#fff; border:1px solid #e5e5e5; box-shadow:0 1px 1px rgba(0,0,0,.04);}
	div.dup-box-title {font-size:14px; padding:5px 0 0 10px; font-weight:bold; cursor:pointer; height:23px; margin:0px; background-color:#F9F9F9}
	div.dup-box-title:hover {background-color:#efefef;}
	div.dup-box-arrow {text-decoration:none!important; float:right; width:27px; height:30px; font-size:16px; cursor:pointer; padding:1px 0 0 0px; white-space:nowrap}
	div.dup-box-panel {padding:10px 15px 10px 15px;  border-top:1px solid #EEEEEE; margin:-1px 0 0 0px; background-color:#F9F9F9;   box-shadow:0 8px 6px -6px #999;}

	/* ============================
	STEP 1 VIEW */
	div#dup-s1-warning-check label {cursor: pointer}
	table.s1-opts {width:100%; border:0px;}
	table.s1-opts td{white-space:nowrap; padding:3px;}
	table.s1-opts td:first-child{width:125px;}
	table.s1-opts-dbhost td {padding:0; margin:0}
	table.s1-advopts td:first-child{width:125px; font-weight:bold}
	
	i#s1-sys-req-msg {font-weight:normal; display:block; padding:0px 0 0 20px;}
	div.circle-pass, div.circle-fail {display:block;width:13px;height:13px;border-radius:50px;font-size:20px;color:#fff;line-height:100px;text-align:center;text-decoration:none;box-shadow:1px 1px 2px #000;background:#207D1D;opacity:0.95; display:inline-block;}
	div.circle-fail {background:#9A0D1D !important;}
	select#logging {font-size:11px}
	div.s1-modes {padding:0px 15px 0 0px;}
	div#s1-dbconn {margin:auto; text-align:center; margin:15px 0 10px 0px}
	
	input.s1-small-btn {font-size:11px; height:20px; border:1px solid gray; border-radius:3px; cursor:pointer}
	input#s1-dbport-btn { width:80px}
	div.dup-db-test small{display:block; font-style:italic; color:#333; padding:3px 2px 5px 2px; border-bottom:1px dashed silver; margin-bottom:10px; text-align: center }
	table.dup-db-test-dtls {text-align: left; margin: auto}
	table.dup-db-test-dtls td:first-child {font-weight: bold}
	div#dbconn-test-msg {font-size:12px}
	div#s1-dbconn-status {border:1px solid silver; border-radius:3px; background-color:#f9f9f9; padding:2px 5px; margin-top:10px; height:165px; overflow-y: scroll}
	div#s1-dbconn-status div.warn-msg {text-align: left; padding:5px; margin:10px 0 10px 0}
	div#s1-dbconn-status div.warn-msg b{color:maroon}
	
	/*Advanced Options & Warning Area*/
	div.s1-advopts-section {margin:15px 0 25px 0}
	div.s1-advopts-section label {cursor: pointer}
	div.s1-advopts-help {text-align: center; margin:10px}
	div.dup-s1-gopro {color: black;font-style: italic;margin-top: 11px; text-align:center;margin-top:20px; padding:5px}
	div#dup-s1-warning {padding:5px;font-size:12px; color:gray; line-height:12px;font-style:italic; overflow-y:scroll; height:150px; border:1px solid #dfdfdf; background-color:#fff; border-radius:3px}
	div#dup-s1-warning-check {padding:5px; font-size:12px; font-weight:normal; font-style:italic;}
	div#dup-s1-warning-emptydb {display:none; color:#AF2222; margin:0px 0 0 20px}
	table.s1-advopts label.radio {width:50px; display:inline-block}

	/*Dialog*/
	div#dup-s1-dialog-data {height:90%; font-size:11px; padding:5px; line-height:16px; }
	td.dup-s1-dialog-data-details {padding:1px 0 10px 30px; border-radius:4px; line-height:14px; font-size:11px; display:none}
	td.dup-s1-dialog-data-details b {width:50px;display:inline-block}
	.dup-pass {display:inline-block; color:green;}
	.dup-ok {display:inline-block; color:#5860C7;}
	.dup-fail {display:inline-block; color:#AF0000;}
	.dup-notice {display:inline-block; color:#000;}
	hr.dup-dots { border:none; border-top:1px dotted silver; height:1px; width:100%;}
	div.dup-ui-error {padding-top:2px; font-size:14px; line-height: 20px}
	div.help {color:#555; font-style:italic; font-size:11px}

	/* ============================
	STEP 2 VIEW */
	table.table-inputs-s2{width:100%; border:0px;}
	table.table-inputs-s2 td{white-space:nowrap; padding:2px;}
	div#dup-s2-adv-opts {margin-top:5px; }
	div.dup-s2-allnonelinks {font-size:11px; float:right;}

	/* ============================
	STEP 3 VIEW */
	div.s3-final-title {color:#BE2323;}
	div.s3-connect {font-size:12px; text-align:center; font-style:italic; position:absolute; bottom:10px; padding:10px; width:100%; margin-top:20px}
	table.s3-report-results,
	table.s3-report-errs {border-collapse:collapse; border:1px solid #dfdfdf; }
	table.s3-report-errs  td {text-align:center; width:33%}
	table.s3-report-results th, table.s3-report-errs th {background-color:#efefef; padding:0px; font-size:14px; padding:0px}
	table.s3-report-results td, table.s3-report-errs td {padding:0px; white-space:nowrap; border:1px solid #dfdfdf; text-align:center; font-size:12px}
	table.s3-report-results td:first-child {text-align:left; font-weight:bold; padding-left:3px}
	div.dup-step3-err-title {width:100%; background-color: #dfdfdf; font-weight: bold; margin:-5px 0 15px 0; padding:3px 0 1px 3px; border-radius: 4px; font-size:14px}

	div.s3-err-msg {padding:8px;  display:none; border:1px dashed #999; margin:10px 0 20px 0px; border-radius:5px;}
	div.s3-err-msg div.content{padding:5px; font-size:11px; line-height:17px; max-height:125px; overflow-y:scroll; border:1px solid silver; margin:3px;  }
	div.s3-err-msg div.info-error{padding:7px; background-color:#EAA9AA; border:1px solid silver; border-radius:5px; font-size:12px; line-height:16px }
	div.s3-err-msg div.info-notice{padding:7px; background-color:#FCFEC5; border:1px solid silver; border-radius:5px; font-size:12px; line-height:16px;}
	table.s3-final-step {width:100%;}
	table.s3-final-step td {padding:5px 15px 5px 5px}
	table.s3-final-step td:first-child {white-space:nowrap; font-weight:bold}
	div.s3-go-back {border-bottom:1px dotted #dfdfdf; border-top:1px dotted #dfdfdf; margin:auto; text-align:center; font-size: 12px}
	div.s3-btns-msg {text-align: center; font-size:10px; color:#777; margin:5px 0 15px 0}
	a.s3-final-btns {display: block; width:135; padding:5px; line-height: 1.4; background-color:#F1F1F1; border:1px solid silver;
		color: #000; box-shadow: 5px 5px 5px -5px #949494; text-decoration: none; text-align: center; border-radius: 4px;
	}
	a.s3-final-btns:hover {background-color: #dfdfdf;}
	div.s3-gopro-btn {text-align:center; font-size:14px; margin:auto; width:200px; font-style: italic}

	/* ============================
	BUTTONS */	
	div.dup-footer-buttons {padding:10px; width:100%; text-align:right;}
	div.dup-footer-buttons  input, button {
		color:#000; font-size:12px; border-radius:5px;	padding:6px 8px 4px 8px; border:1px solid #999;
		background-color:#F1F1F1;
		background-image:-ms-linear-gradient(top, #F9F9F9, #ECECEC);
		background-image:-moz-linear-gradient(top, #F9F9F9, #ECECEC);
		background-image:linear-gradient(top, #F9F9F9, #ECECEC);
	}
	div.dup-footer-buttons input[disabled=disabled]{background-color:#F4F4F4; color:silver; border:1px solid silver;}
	div.dup-footer-buttons  input, button {cursor:pointer; border:1px solid #000; }

	/*!
	 * password indicator
	 */
	.top_testresult{font-weight:bold;	font-size:11px; color:#222;	padding:1px 1px 1px 4px; margin:4px 0 0 0px; width:495px; dislay:inline-block}
	.top_testresult span{margin:0;}
	.top_shortPass{background:#edabab; border:1px solid #bc0000;display:block;}
	.top_badPass{background:#edabab;border:1px solid #bc0000;display:block;}
	.top_goodPass{background:#ffffe0; border:1px solid #e6db55;	display:block;}
	.top_strongPass{background:#d3edab;	border:1px solid #73bc00; display:block;}

	/*================================================
	PARSLEY:Overrides*/
	input.parsley-error, textarea.parsley-error, select.parsley-error {
	  color:#B94A48 !important;
	  background-color:#F2DEDE !important;
	  border:1px solid #EED3D7 !important;
	}
	ul.parsley-errors-list {margin:1px 0 0 -40px; list-style-type:none; font-size:10px}
</style>