<?php global $cssPath, $jsPath, $themePath, $theLayout, $theHeader;

// Login popup window 
// - Call with link: <a href="#LoginPopup" class="inlinePopup">Login</a>  ?>

<div class="hidden">
	<div id="LoginPopup">
		<form class="loginForm" id="popupLoginForm" method="post" action="<?php echo wp_login_url(); // optional redirect: wp_login_url('/redirect/url/'); ?>">
			<div id="loginBg"><div id="loginBgGraphic"></div></div>
			<div class="loginContainer">
				<h3><?php _e( 'Sign in to your account', THEME_NAME ); ?></h3>
				<fieldset class="formContent">
					<legend><?php _e( 'Account Login', THEME_NAME ); ?></legend>
					<div class="fieldContainer">
						<label for="ModalUsername"><?php _e( 'Username', THEME_NAME ); ?></label>
						<input id="ModalUsername" name="log" type="text" class="textInput" />
					</div>
					<div class="fieldContainer">
						<label for="ModalPassword"><?php _e( 'Password', THEME_NAME ); ?></label>
						<input id="ModalPassword" name="pwd" type="password" class="textInput" />
					</div>
				</fieldset>
			</div>
			<div class="formContent">
				<button type="submit" class="btn signInButton"><span><?php _e( 'Sign in', THEME_NAME ); ?></span></button>
			</div>
			<div class="hr"></div>
			<div class="formContent">
				<a href="<?php bloginfo('wpurl') ?>/wp-login.php?action=lostpassword" id="popupLoginForgotPswd"><?php _e( 'Forgot your password?', THEME_NAME ); ?></a>
			</div>
		</form>
	</div>
</div>
<?php

// BuddyPress footer action
do_action( 'bp_footer' );

// WordPress Footer Includes
wp_footer();

?>

<script type="text/javascript">
</script>

<?php
// Cufon fonts for headings
if ($theLayout['heading_font']['cufon']) : ?>
<script src="<?php echo $theLayout['heading_font']['cufon']; ?>"></script>
<script type="text/javascript">
	Cufon.replace
		('h1:not(.cta-title,.nocufon),h2:not(.cta-title,.nocufon),h3:not(.cta-title,.nocufon),h4:not(.cta-title,.nocufon),h5:not(.cta-title,.nocufon),h6:not(.cta-title,.nocufon)', {hover: true})
		('.widget .item-list .item-title', {hover: true });
	Cufon.now();
</script>
<?php endif; ?>

<script type="text/javascript">

	jQuery(document).ready(function($) {

		<?php // Main menu dropdowns  ?>

		if ( jQuery('#MM ul').length ) { ddsmoothmenu.init({ mainmenuid: "MM", orientation: "h", classname: "slideMenu", contentsource: "markup"}); }

	});



	<?php
	if (bp_plugin_is_active()) :
		
		// Fix for BP pagination (related to use of #content and error after changing sort method) ?>
		jq('div#content').click( function(event) {
			var target = jq(event.target);
	
			if ( target.hasClass('button') )
				return true;
	
			if ( target.parents('.bp-pagination').hasClass('bp-pagination') && !target.parents('.bp-pagination').hasClass('no-ajax') ) {
			//if ( target.parent().parent().hasClass('pagination') && !target.parent().parent().hasClass('no-ajax') ) {
				if ( target.hasClass('dots') || target.hasClass('current') )
					return false;
	
				if ( jq('div.item-list-tabs li.selected').length )
					var el = jq('div.item-list-tabs li.selected');
				else
					var el = jq('li.filter select');
	
				var page_number = 1;
				var css_id = el.attr('id').split( '-' );
				var object = css_id[0];
				var search_terms = false;
	
				if ( jq('div.dir-search input').length )
					search_terms = jq('div.dir-search input').val();
	
				if ( jq(target).hasClass('next') )
					var page_number = Number( jq('div.pagination span.current').html() ) + 1;
				else if ( jq(target).hasClass('prev') )
					var page_number = Number( jq('div.pagination span.current').html() ) - 1;
				else
					var page_number = Number( jq(target).html() );
	
				bp_filter_request( object, jq.cookie('bp-' + object + '-filter'), jq.cookie('bp-' + object + '-scope'), 'div.' + object, search_terms, page_number, jq.cookie('bp-' + object + '-extras') );
	
				return false;
			}
	
		});

		<?php // fix for bp plugin titles with buttons ?>
		$bpPluginTitle = jQuery('#content .padder h3:first-child').addClass('entry-title');
		$titleBtnLink = $bpPluginTitle.children('a');

		if ($titleBtnLink.hasClass('button')) {
			$titleButtons = jQuery('<div class="titleButtons"/>').html('&nbsp; <span class="sep">|</span> &nbsp;');
			$bpPluginTitle.after($titleButtons).addClass('titleHasButtons');
			$titleButtons.append($titleBtnLink.addClass('boxLink'));
		}

		<?php // BP helper for header formatting ?>
		jQuery('.dir-form').addClass('clearfix');

		<?php 
	endif; ?>
</script>
<script src="<?php echo $jsPath; ?>onLoad.js"></script><?php // Functions to call after page load ?>

<?php 
// Google analytics (asynchronous method from http://mathiasbynens.be/notes/async-analytics-snippet)
if (get_theme_var('options,google_analytics')) : ?>
	<script type="text/javascript">
	var _gaq = [['_setAccount', '<?php theme_var('options,google_analytics'); ?>'], ['_trackPageview']];
	(function(d, t) {
	var g = d.createElement(t),
		s = d.getElementsByTagName(t)[0];
	g.async = true;
	g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g, s);
	})(document, 'script');
	</script>
<?php endif; ?>

<?php do_action( 'bp_after_footer' ); ?>