<?php
	// Exit if accessed directly
	if (! defined('DUPLICATOR_INIT')) {
		$_baseURL = "http://" . strlen($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $_baseURL");
		exit; 
	}
	//DETECT ARCHIVE FILES
	$zip_files = DUPX_Util::get_zip_files();
	$zip_count = count($zip_files);
	
	if ($zip_count > 1) {
		$zip_name = "Too many zip files in directory";
	} else if ($zip_count == 1) {
		$zip_name = $zip_files[0];
	} else {
		$zip_name  = "No package file found";
	}
	
	$req01a = @is_writeable($GLOBALS["CURRENT_ROOT_PATH"]) 	? 'Pass' : 'Fail';
	if (is_dir($GLOBALS["CURRENT_ROOT_PATH"])) {
		if ($dh = @opendir($GLOBALS["CURRENT_ROOT_PATH"])) {
			closedir($dh);
		} else {
			$req01a = 'Fail';
		}
	}
	$req01b   = ($zip_count == 1) ? 'Pass' : 'Fail';
	$req01    = ($req01a == 'Pass' && $req01b == 'Pass') ? 'Pass' : 'Fail';
	$safe_ini = strtolower(@ini_get('safe_mode'));
	$req02    =  $safe_ini  != 'on' || $safe_ini != 'yes' || $safe_ini != 'true' || ini_get("safe_mode") != 1 ? 'Pass' : 'Fail';
	$req03    = function_exists('mysqli_connect') ? 'Pass' : 'Fail';
	$php_compare  = version_compare(phpversion(), '5.2.9');
	$req04 = $php_compare >= 0 ? 'Pass' : 'Fail';
	$total_req = ($req01 == 'Pass' && $req02 == 'Pass' && $req03 == 'Pass' && $req04 == 'Pass') ? 'Pass' : 'Fail';
?>


<!-- =========================================
VIEW: STEP 1- INPUT -->
<form id='dup-step1-input-form' method="post" class="content-form"  data-parsley-validate="true" data-parsley-excluded="input[type=hidden], [disabled], :hidden">
	<input type="hidden" name="action_ajax" value="1" />
	<input type="hidden" name="action_step" value="1" />
	<input type="hidden" name="package_name"  value="<?php echo $zip_name ?>" />
	
	<div class="hdr-main">
		Step 1: Deploy Files &amp; Database
	</div>
	
	<!-- CHECKS: FAIL -->
	<?php if ( $total_req == 'Fail')  :	?>
	
		<div class="dup-box">
			<div class="dup-box-title">
				<div id="system-circle" class="circle-fail"></div> &nbsp; Requirements: Fail
				<div class="dup-box-arrow"></div>
			</div>
			<div class="dup-box-panel" style="display:none">	
				<div id="dup-s1-result-container"></div>
			</div> 
		</div><br/>
	
    	<i id="s1-sys-req-msg">
			This installation will not be able to proceed until the system requirements pass. Please validate your system requirements by clicking on the button above. 
			In order to get these values to pass please contact your server administrator, hosting provider or visit the online FAQ.
		</i><br/>
    		    
    	<div style="line-height:28px; font-size:14px; padding:0px 0px 0px 30px; font-weight:normal">
    	    <b>Helpful Resources:</b><br/>
    	    &raquo; <a href="https://snapcreek.com/duplicator/docs/faqs-tech/" target="_blank">Common FAQs</a> <br/>
    	    &raquo; <a href="https://snapcreek.com/duplicator/docs/guide/" target="_blank">User Guide</a> <br/>
    	    &raquo; <a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-resource-040-q" target="_blank">Approved Hosts</a> <br/>
    	</div><br/>
	
	<!-- CHECKS: PASS -->
	<?php else : ?>	
	
		<div class="dup-box">
			<div class="dup-box-title">
				<div id="system-circle" class="circle-pass"></div> &nbsp; Requirements: Pass
				<div class="dup-box-arrow"></div>
			</div>
			<div class="dup-box-panel" style="display:none">	
				<div id="dup-s1-result-container"></div>
			</div> 
		</div><br/>
	
    	<div class="hdr-sub">
    	    MySQL Database
    	</div>
    	<table class="s1-opts">
			<tr>
				<td>Action</td>
				<td>
					<div class="s1-modes">
						<input type="radio" name="dbaction" id="dbaction-create" value="create" checked="checked" />
						<label for="dbaction-create">Create New Database</label>
					</div>
					<div class="s1-modes">
						<input type="radio" name="dbaction" id="dbaction-empty" value="empty" />
						<label for="dbaction-empty">Connect and Remove All Data</label>						
					</div>
				</td>
			</tr>			
    	    <tr>
				<td>Host</td>
				<td>
					<table class="s1-opts-dbhost">
						<tr>
							<td><input type="text" name="dbhost" id="dbhost" required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBHOST']); ?>" placeholder="localhost" style="width:410px" /></td>
							<td style="vertical-align:top">
								<input id="s1-dbport-btn" type="button" onclick="Duplicator.togglePort()" class="s1-small-btn" value="Port: <?php echo htmlspecialchars($GLOBALS['FW_DBPORT']); ?>" />
								<input name="dbport" id="dbport" type="text" style="width:80px; display:none" value="<?php echo htmlspecialchars($GLOBALS['FW_DBPORT']); ?>" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>Database</td>
				<td><input type="text" name="dbname" id="dbname"  required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBNAME']); ?>"  placeholder="new or existing database name"  /></td>
			</tr>
			<tr>
				<td>User</td>
				<td><input type="text" name="dbuser" id="dbuser" required="true" value="<?php echo htmlspecialchars($GLOBALS['FW_DBUSER']); ?>" placeholder="valid database username" /></td>
			</tr>
    	    <tr>
				<td>Password</td>
				<td><input type="text" name="dbpass" id="dbpass" value="<?php echo htmlspecialchars($GLOBALS['FW_DBPASS']); ?>"  placeholder="valid database user password"   /></td>
			</tr>
    	</table>
		
		
		<!-- =========================================
		DIALOG: DB CONNECTION CHECK  -->
		<div id="s1-dbconn">
			<input type="button" onclick="Duplicator.dlgTestDB()" class="s1-small-btn" value="Test Connection" />
			<div id="s1-dbconn-status" style="display:none">
				<div style="padding: 0px 10px 10px 10px;">		
					<div id="dbconn-test-msg" style="min-height:80px"></div>
				</div>
				<small><input type="button" onclick="$('#s1-dbconn-status').hide(500)" class="s1-small-btn" value="Hide Message" /></small>
			</div>
		</div>
		
		<div class="dup-s1-gopro">
			Create the database and users <b>from the installer</b> <br/> with <a target="_blank" href="https://snapcreek.com/duplicator/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=free_install_step1&utm_campaign=duplicator_pro">Duplicator Pro!</a> - Requires cPanel.
		</div>
		<br/>
		
		<!-- ADVANCED OPTIONS -->
    	<a href="javascript:void(0)" onclick="$('#dup-step1-adv-opts').toggle(250)"><b style="font-size:14px">Advanced Options...</b></a>
    	<div id='dup-step1-adv-opts' style="display:none">

			<!-- GENERAL -->
			<div class="s1-advopts-section">
				<div class="hdr-sub">General</div>
				<table class="s1-opts s1-advopts">
					<tr>
						<td>Extraction</td>
						<td colspan="2">
							<input type="checkbox" name="zip_manual" id="zip_manual" value="1" /> <label for="zip_manual">Manual package extraction</label><br/>
						</td>
					</tr>
					<tr>
						<td>File Timestamp</td>
						<td colspan="2">
							<input type="radio" name="zip_filetime" id="zip_filetime_now" value="current" checked="checked" /> <label class="radio" for="zip_filetime_now" title='Set the files current date time to now'>Current</label>
							<input type="radio" name="zip_filetime" id="zip_filetime_orginal" value="original" /> <label class="radio" for="zip_filetime_orginal" title="Keep the files date time the same">Original</label>
						</td>
					</tr>					
					<tr>
						<td>Logging</td>
						<td colspan="2">
							<input type="radio" name="logging" id="logging-light" value="1" checked="true"> <label class="radio" for="logging-light">Light</label>
							<input type="radio" name="logging" id="logging-detailed" value="2"> <label class="radio" for="logging-detailed">Detailed</label>
							<input type="radio" name="logging" id="logging-debug" value="3"> <label class="radio" for="logging-debug">Debug</label>
						</td>
					</tr>	
					<tr>
						<td>WP-Config Cache</td>
						<td style="width:125px"><input type="checkbox" name="cache_wp" id="cache_wp" <?php echo ($GLOBALS['FW_CACHE_WP']) ? "checked='checked'" : ""; ?> /> <label for="cache_wp">Keep Enabled</label></td>
						<td><input type="checkbox" name="cache_path" id="cache_path" <?php echo ($GLOBALS['FW_CACHE_PATH']) ? "checked='checked'" : ""; ?> /> <label for="cache_path">Keep Home Path</label></td>
					</tr>	
					<tr>
						<td>WP-Config SSL</td>
						<td><input type="checkbox" name="ssl_admin" id="ssl_admin" <?php echo ($GLOBALS['FW_SSL_ADMIN']) ? "checked='checked'" : ""; ?> /> <label for="ssl_admin">Enforce on Admin</label></td>
						<td><input type="checkbox" name="ssl_login" id="ssl_login" <?php echo ($GLOBALS['FW_SSL_LOGIN']) ? "checked='checked'" : ""; ?> /> <label for="ssl_login">Enforce on Login</label></td>
					</tr>
				</table>
			</div>				
			
			<!-- MYSQL -->
			<div class="s1-advopts-section">
				<div class="hdr-sub">MySQL</div>			
				<table class="s1-opts s1-advopts">
					<tr>
						<td>Spacing</td>
						<td colspan="2">
							<input type="checkbox" name="dbnbsp" id="dbnbsp" value="1" /> <label for="dbnbsp">Fix non-breaking space characters</label>
						</td>
					</tr>				
					<tr>
						<td style="vertical-align:top">Mode</td>
						<td colspan="2">
							<input type="radio" name="dbmysqlmode" id="dbmysqlmode_1" checked="true" value="DEFAULT"/> <label for="dbmysqlmode_1">Default</label> &nbsp;
							<input type="radio" name="dbmysqlmode" id="dbmysqlmode_2" value="DISABLE"/> <label for="dbmysqlmode_2">Disable</label> &nbsp;
							<input type="radio" name="dbmysqlmode" id="dbmysqlmode_3" value="CUSTOM"/> <label for="dbmysqlmode_3">Custom</label> &nbsp;
							<div id="dbmysqlmode_3_view" style="display:none; padding:5px">
								<input type="text" name="dbmysqlmode_opts" value="" /><br/>
								<small>Separate additional <a href="?help#help-mysql-mode" target="_blank">sql modes</a> with commas &amp; no spaces.<br/>
									Example: <i>NO_ENGINE_SUBSTITUTION,NO_ZERO_IN_DATE,...</i>.</small>
							</div>
						</td>
					</tr>				
					<tr><td style="width:130px">Charset</td><td><input type="text" name="dbcharset" id="dbcharset" value="<?php echo $_POST['dbcharset'] ?>" /> </td></tr>
					<tr><td>Collation </td><td><input type="text" name="dbcollate" id="dbcollate" value="<?php echo $_POST['dbcollate'] ?>" /> </tr>
				</table>
			</div>
			
			<div class="s1-advopts-help">
				<small><i>For an overview of these settings see the <a href="?help=1" target="_blank">help page</a></i></small>
			</div>
    	</div>
		<br/><br/>
		
	    <!-- SETUP HELP	-->
    	<a href="javascript:void(0)" onclick="$('#dup-step1-cpanel').toggle(250)"><b style="font-size: 14px">Need Setup Help...</b></a>
    	<div id='dup-step1-cpanel' style="display:none">
    	    <div style="padding:10px 0px 0px 10px;line-height:22px">
    		&raquo; View the <a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-resource-070-q" target="_blank">video tutorials</a> <br/>
    		&raquo; Read helpful <a href="https://snapcreek.com/duplicator/docs/faqs-tech/" target="_blank">articles</a> <br/>
			&raquo; Visit the <a href="https://snapcreek.com/duplicator/docs/quick-start/" target="_blank">quick start guides</a>
    	    </div>
    	</div>
		<br/><br/>

		<!-- NOTICES  -->
		<a href="javascript:void(0)" onclick="$('#dup-s1-warning').toggle(250)"><b style="font-size:14px">Warnings &amp; Notices...</b></a>
    	<div id="dup-s1-warning" style="display: none"><pre>Duplicator
Copyright (c) 2017 Snapcreek LLC

*** WARNINGS &amp; NOTICES *** 

DISCLAIMER:
This plugin require above average technical knowledge. Please use it at your own risk and always back up your database and files beforehand using another backup 
system besides the Duplicator. If you're not sure about how to use this tool then please enlist the guidance of a technical professional.  Always test this installer
in a sandbox environment before trying to deploy into a production setting.

DATABASE:
Do not connect to an existing database unless you are 100% sure you want to remove all of it's data.  Connecting to a database that already exists will permanently 
DELETE all data in that database. This tool is designed to populate and fill a database with NEW data from a duplicated database using the SQL script in the package name above.

SETUP:
Only the archive and installer.php file should be in the install directory, unless you have manually extracted the package and checked the 'Manual Package Extraction' checkbox. 
All other files will be OVERWRITTEN during install.  Make sure you have full backups of all your databases and files before continuing with an installation.

MANUAL EXTRACTION:
Manual extraction requires that all contents in the package are extracted to the same directory as the installer.php file.  Manual extraction is only needed when your server 
does not support the ZipArchive extension.  Please see the online help for more details.

AFTER INSTALL:
When you are done with the installation remove the installer.php, installer-data.sql and the installer-log.txt files from your directory.  These files contain sensitive information
 and should not remain on a production system.


*** END USER LICENSE AGREEMENT ***

IMPORTANT: PLEASE READ THIS LICENSE CAREFULLY BEFORE USING THIS SOFTWARE.

1. LICENSE

By receiving, opening the file package, and/or using Duplicator("Software") containing this software, you agree that this End User User License Agreement(EULA) is 
a legally binding and valid contract and agree to be bound by it. You agree to abide by the intellectual property laws and all of the terms and conditions of this Agreement.

Unless you have a different license agreement signed by Snapcreek LLC your use of Duplicator indicates your acceptance of this license agreement and warranty.

Subject to the terms of this Agreement, Snapcreek LLC grants to you a limited, non-exclusive, non-transferable free license, without right to sub-license, to use Duplicator 
in accordance with this Agreement and any other written agreement with Snapcreek LLC. Snapcreek LLC does not transfer the title of Duplicator to you; the license granted 
to you is not a sale the plugin is given free and as is. This agreement is a binding legal agreement between Snapcreek LLC and the purchasers or users of Duplicator.

If you do not agree to be bound by this agreement, remove Duplicator from your computer now and, if applicable, promptly all related documentation and files relating to 
Duplicator in your possession.


2. DISTRIBUTION

Duplicator and the license herein granted shall not be sold, offered for re-sale, transferred or sub-licensed in whole. For information about redistribution of Duplicator 
contact Snapcreek LLC.


3. USER AGREEMENT

3.1 Use

Duplicator is a free plugin offered for download at https://wordpress.org/plugins/duplicator and https://github.com/lifeinthegrid/duplicator

3.2 USE RESTRICTIONS

You shall use Duplicator in compliance with all applicable laws and not for any unlawful purpose. 


3.3 LIMITATION OF RESPONSIBILITY

You will indemnify, hold harmless, and defend Snapcreek LLC , its employees, agents and distributors against any and all claims, proceedings, demand and costs resulting from or in 
any way connected with your use of Snapcreek LLC's Software.

In no event (including, without limitation, in the event of negligence) will Snapcreek LLC , its employees, agents or distributors be liable for any consequential, incidental, 
indirect, special or punitive damages whatsoever (including, without limitation, damages for loss of profits, loss of use, business interruption, loss of information or data, 
or pecuniary loss), in connection with or arising out of or related to this Agreement, Duplicator or the use or inability to use Duplicator or the furnishing, performance or use
of any other matters hereunder whether based upon contract, tort or any other theory including negligence.

Snapcreek LLC's entire liability, without exception, is limited to no monetary or financial costs

3.4 WARRANTIES

Except as expressly stated in writing, Snapcreek LLC makes no representation or warranties in respect of this Software and expressly excludes all other warranties, expressed or implied,
oral or written, including, without limitation, any implied warranties of merchantable quality or fitness for a particular purpose.

3.5 GOVERNING LAW

This Agreement shall be governed by the law of the United States applicable therein. You hereby irrevocably attorn and submit to the non-exclusive jurisdiction of the courts of
United States therefrom. If any provision shall be considered unlawful, void or otherwise unenforceable, then that provision shall be deemed severable from this License and not 
affect the validity and enforceability of any other provisions.

3.6 TERMINATION

Any failure to comply with the terms and conditions of this Agreement will result in automatic and immediate termination of this license. Upon termination of this license granted 
herein for any reason, you agree to immediately cease use of Duplicator and destroy all copies of Duplicator supplied under this Agreement. The financial obligations incurred by you
shall survive the expiration or termination of this license.

4. DISCLAIMER OF WARRANTY

THIS SOFTWARE AND THE ACCOMPANYING FILES ARE FREE AND OFFERED "AS IS" AND WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED. 
THIS DISCLAIMER CONCERNS ALL FILES GENERATED AND EDITED BY Duplicator AS WELL.
</pre>	
    	</div>
    		    
    	<div id="dup-s1-warning-check">
    	    <input id="accept-warnings" name="accpet-warnings" type="checkbox" onclick="Duplicator.acceptWarning()" style='vertical-align: bottom' /> 
			<label for="accept-warnings">I have read and accept all warnings &amp; notices <small>(required to run deployment)</small></label><br/>
			<div id="dup-s1-warning-emptydb">
				<label for="accept-warnings">The 'Connect and Remove All Data' action will delete <u>all</u> tables and data from the database!</label>
			</div>
    	</div><br/><br/>
    		    
    	<div class="dup-footer-buttons">
    	    <input id="dup-step1-deploy-btn" type="button" value=" Run Deployment " onclick="Duplicator.confirmDeployment()" />
    	</div>		

	<?php endif; ?>	
</form>


<!-- =========================================
VIEW: STEP 1 - AJAX RESULT
Auto Posts to view.step2.php  -->
<form id='dup-step1-result-form' method="post" class="content-form" style="display:none">
	<input type="hidden" name="action_step" value="2" />
	<input type="hidden" name="package_name" value="<?php echo $zip_name ?>" />
	<input type="hidden" name="logging" id="ajax-logging"  />	
	<input type="hidden" name="dbhost" id="ajax-dbhost" />
	<input type="hidden" name="dbport" id="ajax-dbport" />
	<input type="hidden" name="dbuser" id="ajax-dbuser" />
	<input type="hidden" name="dbpass" id="ajax-dbpass" />
	<input type="hidden" name="dbname" id="ajax-dbname" />
	<input type="hidden" name="json"   id="ajax-json" />
	<input type="hidden" name="dbcharset" id="ajax-dbcharset" />
	<input type="hidden" name="dbcollate" id="ajax-dbcollate" />
	
    <div class="dup-logfile-link"><a href="installer-log.txt" target="_blank">installer-log.txt</a></div>
	<div class="hdr-main">
		Step 1: Deploy Files &amp; Database
	</div>
	    
	<!--  PROGRESS BAR -->
	<div id="progress-area">
	    <div style="width:500px; margin:auto">
		<h3>Processing Files &amp; Database Please Wait...</h3>
		<div id="progress-bar"></div>
		<i>This may take several minutes</i>
	    </div>
	</div>
	    
	<!--  AJAX SYSTEM ERROR -->
	<div id="ajaxerr-area" style="display:none">
	    <p>Please try again an issue has occurred.</p>
	    <div style="padding: 0px 10px 10px 0px;">
			<div id="ajaxerr-data">An unknown issue has occurred with the file and database setup process.  Please see the installer-log.txt file for more details.</div>
			<div style="text-align:center; margin:10px auto 0px auto">
				<input type="button" onclick='Duplicator.hideErrorResult()' value="&laquo; Try Again" /><br/><br/>
				<i style='font-size:11px'>See online help for more details at <a href='https://snapcreek.com/ticket' target='_blank'>snapcreek.com</a></i>
			</div>
	    </div>
	</div>
</form>


<!-- =========================================
PANEL: SERVER CHECKS  -->
<div id="dup-s1-dialog" title="System Status" style="display:none">
<div id="dup-s1-dialog-data" style="padding: 0px 10px 10px 10px;">
	
	<div style="font-size:12px">
		<b>Archive Name:</b> <?php echo $zip_name; ?> <br/>
		<b>Package Notes:</b> <?php echo empty($GLOBALS['FW_PACKAGE_NOTES']) ? 'No notes provided for this pakcage.' : $GLOBALS['FW_PACKAGE_NOTES']; ?>
	</div>
	<br/>
	
	<!-- SYSTEM REQUIREMENTS -->
	<b>REQUIREMENTS</b> &nbsp; <i style='font-size:11px'>click links for details</i>
	<hr size="1"/>
	
	<table style="width:100%">
	<tr>
		<td style="width:300px"><a href="javascript:void(0)" onclick="$('#dup-req-rootdir').toggle(200)">Root Directory</a></td>
		<td class="<?php echo ($req01 == 'Pass') ? 'dup-pass' : 'dup-fail' ?>"><?php echo $req01; ?></td>
	</tr>
	<tr>
		<td colspan="2" id="dup-req-rootdir" class='dup-s1-dialog-data-details'>
		<?php
		echo "<i>Path: {$GLOBALS['CURRENT_ROOT_PATH']} </i><br/>";
		printf("<b>[%s]</b> %s <br/>", $req01a, "Is Writable by PHP");
		printf("<b>[%s]</b> %s ", $req01b, "Contains only one zip file<div style='padding-left:70px'>Result = {$zip_name} <br/> <i>Note: Manual extraction still requires the archive.zip file</i> </div> ");
		?>
		</td>
	</tr>
	<tr>
		<td><a href="javascript:void(0)" onclick="$('#dup-req-mysqli').toggle(200)">MySQLi Support</a></td>
		<td class="<?php echo ($req03 == 'Pass') ? 'dup-pass' : 'dup-fail' ?>"><?php echo $req03; ?></td>
	</tr>	
	<tr>
		<td colspan="2" id="dup-req-mysqli" class='dup-s1-dialog-data-details'>
			The Duplicator needs the PHP mysqli extension installed to run properly.  This is a very common extension and can be easily installed by your
			host or server administrator.  For more details see the <a href="http://us2.php.net/manual/en/mysqli.installation.php" target="_blank" >online overview</a>.
		</td>
	</tr>
	<tr>
		<td><a href="javascript:void(0)" onclick="$('#dup-req-safemode').toggle(200)">Safe Mode Off</a></td>
		<td class="<?php echo ($req02 == 'Pass') ? 'dup-pass' : 'dup-fail' ?>"><?php echo $req02; ?></td>
	</tr>
	<tr>
		<td colspan="2" id="dup-req-safemode" class='dup-s1-dialog-data-details'>
			The Duplicator requires that PHP safe mode be turned off.  Safe mode is a very uncommon setting and can be easily turned off by your
			host or server administrator.  For more details see the <a href="http://php.net/manual/en/features.safe-mode.php" target="_blank" >online overview</a>.
		</td>
	</tr>	
	<tr>
		<td valign="top"><a href="javascript:void(0)" onclick="$('#dup-req-phpver').toggle(200)">PHP Version</a> </td>
		<td class="<?php echo ($req04 == 'Pass') ? 'dup-pass' : 'dup-fail' ?>"><?php echo $req04; ?> </td>
	</tr>
	<tr>
		<td colspan="2" id="dup-req-phpver" class='dup-s1-dialog-data-details'>
			This server is currently running PHP version: <b><?php echo phpversion(); ?></b>. The Duplicator requires a version of 5.2.9+ or better. 
			To upgrade your PHP version contact your host or server administrator.  
		</td>
	</tr>		
	</table>
	<br/>

	<!-- SYSTEM CHECKS -->
	<b>CHECKS</b><hr  size="1"/>
	<table style="width:100%">
	<tr>
		<td style="width:300px"></td>
		<td></td>
	</tr>
	<tr>
		<?php if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false): ?>
			<td><b>Web Server:</b> Apache</td>
			<td><div class='dup-pass'>Good</div></td>
		<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false): ?> 
			<td><b>Web Server:</b> LiteSpeed</td>
			<td><div class='dup-ok'>OK</div></td>
		<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false): ?> 
			<td><b>Web Server:</b> Nginx</td>
			<td><div class='dup-ok'>OK</div></td>
		<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'lighttpd') !== false): ?> 
			<td><b>Web Server:</b> Lighthttpd</td>
			<td><div class='dup-ok'>OK</div></td>
		<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'iis') !== false): ?> 
			<td><b>Web Server:</b> Microsoft IIS</td>
			<td><div class='dup-ok'>OK</div></td>
		<?php else: ?>
			<td><b>Web Server:</b> Not detected</td>
			<td><div class='dup-fail'>Caution</div></td>
		<?php endif; ?>				
	</tr>
	<tr>
		<?php
			$open_basedir_set = ini_get("open_basedir");
			if (empty($open_basedir_set)):
		?>
			<td><b>Open Base Dir:</b> Off
			<td><div class='dup-pass'>Good</div>
		<?php else: ?>
			<td><b>Open Base Dir:</b> On</td>
			<td><div class='dup-fail'>Caution</div></td>
		<?php endif; ?>
	</tr>
	</table>

	<hr class='dup-dots' />
	<!-- SAPI -->
	<b>PHP MAX MEMORY:</b> <?php echo $GLOBALS['PHP_MEMORY_LIMIT'] ?><br/>
	<b>PHP SAPI:</b>  <?php echo php_sapi_name(); ?><br/>
	<b>PHP ZIP Archive:</b> <?php echo class_exists('ZipArchive') ? 'Is Installed' : 'Not Installed'; ?> <br/>
	<b>CDN Accessible:</b> <?php echo ( DUPX_Util::is_url_active("ajax.aspnetcdn.com", 443) && DUPX_Util::is_url_active("ajax.googleapis.com", 443)) ? 'Yes' : 'No'; ?> 
	<br/><br/>
	Need an <a href='https://snapcreek.com/duplicator/docs/faqs-tech/#faq-resource-040-q' target='_blank'>approved</a> Duplicator hosting provider?

</div>
</div>


<!-- CONFIRM DIALOG -->
<div id="dialog-confirm-content" style="display:none">
	<div style="padding:0 0 25px 0">
		<b>Run installer with these settings?</b>
	</div>
	
	<b>Database Settings:</b><br/>
	<table style="margin-left:20px">
		<tr>
			<td><b>Server:</b></td>
			<td><i id="dlg-dbhost"></i></td>
		</tr>
		<tr>
			<td><b>Name:</b></td>
			<td><i id="dlg-dbname"></i></td>
		</tr>
		<tr>
			<td><b>User:</b></td>
			<td><i id="dlg-dbuser"></i></td>
		</tr>			
	</table>
	<br/><br/>

	<small> WARNING: Be sure these database parameters are correct! Entering the wrong information WILL overwrite an existing database.
	Make sure to have backups of all your data before proceeding.</small><br/>
</div>


<script type="text/javascript">
	
	/* Confirm Dialog to validate run */
	Duplicator.confirmDeployment = function() 
	{
		var $form = $('#dup-step1-input-form');
        $form.parsley().validate();
        if (!$form.parsley().isValid()) {
            return;
        }

		$('#dlg-dbhost').html($("#dbhost").val());
		$('#dlg-dbname').html($("#dbname").val());
		$('#dlg-dbuser').html($("#dbuser").val());

		modal({
			type: 'confirm',
			title: 'Install Confirmation',
			text: $('#dialog-confirm-content').html(),
			callback: function(result) 
			{
				if (result == true) {
					Duplicator.runDeployment();
				}
			}
		});
	}
	
	/* Performs Ajax post to extract files and create db
	 * Timeout (10000000 = 166 minutes) */
	Duplicator.runDeployment = function() 
	{
		var $form = $('#dup-step1-input-form');
		var dbhost = $("#dbhost").val();
        var dbname = $("#dbname").val();
		var dbuser = $("#dbuser").val();
		
		$.ajax({
			type: "POST",
			timeout: 10000000,
			dataType: "json",
			url: window.location.href,
			data: $form.serialize(),
			beforeSend: function() {
				Duplicator.showProgressBar();
				$form.hide();
				$('#dup-step1-result-form').show();
			},			
			success: function(data, textStatus, xhr){ 
				if (typeof(data) != 'undefined' && data.pass == 1) {
					$("#ajax-dbhost").val($("#dbhost").val());
					$("#ajax-dbport").val($("#dbport").val());
					$("#ajax-dbuser").val($("#dbuser").val());
					$("#ajax-dbpass").val($("#dbpass").val());
					$("#ajax-dbname").val($("#dbname").val());
					$("#ajax-dbcharset").val($("#dbcharset").val());
					$("#ajax-dbcollate").val($("#dbcollate").val());
					$("#ajax-logging").val($("input:radio[name=logging]:checked").val());
					$("#ajax-json").val(escape(JSON.stringify(data)));
					setTimeout(function() {$('#dup-step1-result-form').submit();}, 1000);
					$('#progress-area').fadeOut(700);
				} else {
					Duplicator.hideProgressBar();
				}
			},
			error: function(xhr) { 
				var status = "<b>server code:</b> " + xhr.status + "<br/><b>status:</b> " + xhr.statusText + "<br/><b>response:</b> " +  xhr.responseText;
				$('#ajaxerr-data').html(status);
				Duplicator.hideProgressBar();
			}
		});	
		
	};

	/** **********************************************
	* METHOD: Accetps Useage Warning */
	Duplicator.acceptWarning = function() {
		if ($("#accept-warnings").is(':checked')) {
			$("#dup-step1-deploy-btn").removeAttr("disabled");
		} else {
			$("#dup-step1-deploy-btn").attr("disabled", "true");
		}
	};

	/** **********************************************
	* METHOD: Go back on AJAX result view */
	Duplicator.hideErrorResult = function() {
		$('#dup-step1-result-form').hide();			
		$('#dup-step1-input-form').show(200);
	};
	
	/** **********************************************
	* METHOD: Shows results of database connection 
	* Timeout (45000 = 45 secs) */
	Duplicator.dlgTestDB = function () {		
		$.ajax({
			type: "POST",
			timeout: 45000,
			url: window.location.href + '?' + 'dbtest=1',
			data: $('#dup-step1-input-form').serialize(),
			success: function(data){ $('#dbconn-test-msg').html(data); },
			error:   function(data){ alert('An error occurred while testing the database connection!  Contact your server admin to make sure the connection inputs are correct!'); }
		});
		
		$('#dbconn-test-msg').html("Attempting Connection.  Please wait...");
		$("#s1-dbconn-status").show(500);
		
	};
	
	Duplicator.showDeleteWarning = function () {
		($('#dbaction-empty').prop('checked')) 
			? $('#dup-s1-warning-emptydb').show(300)
			: $('#dup-s1-warning-emptydb').hide(300);
	};
	
	Duplicator.togglePort = function () {
		
		$('#s1-dbport-btn').hide();
		$('#dbport').show();
	}
	
	
	//DOCUMENT LOAD
	$(document).ready(function() {
		$('#dup-s1-dialog-data').appendTo('#dup-s1-result-container');
		$( "input[name='dbaction']").click(Duplicator.showDeleteWarning);
		Duplicator.acceptWarning();
		Duplicator.showDeleteWarning();		
		
		//MySQL Mode
		$("input[name=dbmysqlmode]").click(function() {
			if ($(this).val() == 'CUSTOM') {
				$('#dbmysqlmode_3_view').show();
			} else {
				$('#dbmysqlmode_3_view').hide();
			}
		});
		
		if ($("input[name=dbmysqlmode]:checked").val() == 'CUSTOM') {
			$('#dbmysqlmode_3_view').show();
		}
		
		
	});
</script>
