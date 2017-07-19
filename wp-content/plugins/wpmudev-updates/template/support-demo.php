<?php
/**
 * Dashboard template: Demo of UI elements
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

// Render the page header section.
$page_title = __( 'UI Demo', 'wpmudev' );
$this->render_header( $page_title );
?>

<div class="row">

<div class="col-third">
<section class="dev-box">
	<div class="box-title">
		<h3>Button styles</h3>
	</div>
	<div class="box-content">
		<p><a href="#" class="block button">.button</a></p>
		<p><a href="#" class="block button button-secondary">.button.button-secondary</a></p>
		<p><a href="#" class="block button button-green">.button.button-green</a></p>
		<p><a href="#" class="block button button-grey">.button.button-grey</a></p>
		<p><a href="#" class="block button button-light">.button.button-light</a></p>
		<p><a href="#" class="block button button-yellow">.button.button-yellow</a></p>
		<p><a href="#" class="block button button-red">.button.button-red</a></p>
		<p>CTA button:<br>
		<a href="#" class="block button button-cta">.button.button-cta</a></p>
	</div>
</section>
</div>

<div class="col-third">
<section class="dev-box">
	<div class="box-title">
		<h3>Button styles (small)</h3>
	</div>
	<div class="box-content">
		<p><a href="#" class="block button-small button">.button</a></p>
		<p><a href="#" class="block button-small button button-secondary">.button.button-secondary</a></p>
		<p><a href="#" class="block button-small button button-green">.button.button-green</a></p>
		<p><a href="#" class="block button-small button button-grey">.button.button-grey</a></p>
		<p><a href="#" class="block button-small button button-light">.button.button-light</a></p>
		<p><a href="#" class="block button-small button button-yellow">.button.button-yellow</a></p>
		<p><a href="#" class="block button-small button button-red">.button.button-red</a></p>
		<p>CTA button:<br>
		<a href="#" class="block button-small button button-cta">.button.button-cta</a></p>
		<p><em>Simply add class "button-small" to any button to make it small</em></p>
	</div>
</section>

<section class="dev-box can-close">
	<div class="box-title">
		<span class="close">X</span>
		<h3>You can close this</h3>
	</div>
	<div class="box-content inside">
		Some demo stuff here...
	</div>
</section>
</div>

<div class="col-third">
<section class="dev-box">
	<div class="box-title">
		<h3>WPMUDEV Icons</h3>
	</div>
	<div class="box-content">
		<span tooltip="dev-icon dev-icon-comment"><i class="dev-icon dev-icon-comment"></i></span>
		<span tooltip="dev-icon dev-icon-speach"><i class="dev-icon dev-icon-speach"></i></span>
		<span tooltip="dev-icon dev-icon-speach_alt"><i class="dev-icon dev-icon-speach_alt"></i></span>
		<span tooltip="dev-icon dev-icon-download"><i class="dev-icon dev-icon-download"></i></span>
		<span tooltip="dev-icon dev-icon-download_alt"><i class="dev-icon dev-icon-download_alt"></i></span>
		<span tooltip="dev-icon dev-icon-upload"><i class="dev-icon dev-icon-upload"></i></span>
		<span tooltip="dev-icon dev-icon-error"><i class="dev-icon dev-icon-error"></i></span>
		<span tooltip="dev-icon dev-icon-archive"><i class="dev-icon dev-icon-archive"></i></span>
		<span tooltip="dev-icon dev-icon-logo"><i class="dev-icon dev-icon-logo"></i></span>
		<span tooltip="dev-icon dev-icon-logo_alt"><i class="dev-icon dev-icon-logo_alt"></i></span>
		<span tooltip="dev-icon dev-icon-wordpress"><i class="dev-icon dev-icon-wordpress"></i></span>
		<span tooltip="dev-icon dev-icon-facebook"><i class="dev-icon dev-icon-facebook"></i></span>
		<span tooltip="dev-icon dev-icon-twitter"><i class="dev-icon dev-icon-twitter"></i></span>
		<span tooltip="dev-icon dev-icon-github"><i class="dev-icon dev-icon-github"></i></span>
		<span tooltip="dev-icon dev-icon-stackoverflow"><i class="dev-icon dev-icon-stackoverflow"></i></span>
		<span tooltip="dev-icon dev-icon-linkedin"><i class="dev-icon dev-icon-linkedin"></i></span>
		<span tooltip="dev-icon dev-icon-medium"><i class="dev-icon dev-icon-medium"></i></span>
		<span tooltip="dev-icon dev-icon-quora"><i class="dev-icon dev-icon-quora"></i></span>
		<span tooltip="dev-icon dev-icon-seo"><i class="dev-icon dev-icon-seo"></i></span>
		<span tooltip="dev-icon dev-icon-minify"><i class="dev-icon dev-icon-minify"></i></span>
		<span tooltip="dev-icon dev-icon-uptime"><i class="dev-icon dev-icon-uptime"></i></span>
		<span tooltip="dev-icon dev-icon-world"><i class="dev-icon dev-icon-world"></i></span>
		<span tooltip="dev-icon dev-icon-pos_footer"><i class="dev-icon dev-icon-pos_footer"></i></span>
		<span tooltip="dev-icon dev-icon-pos_middle"><i class="dev-icon dev-icon-pos_middle"></i></span>
		<span tooltip="dev-icon dev-icon-pos_header"><i class="dev-icon dev-icon-pos_header"></i></span>
		<span tooltip="dev-icon dev-icon-book"><i class="dev-icon dev-icon-book"></i></span>
		<span tooltip="dev-icon dev-icon-support"><i class="dev-icon dev-icon-support"></i></span>
		<span tooltip="dev-icon dev-icon-rocket"><i class="dev-icon dev-icon-rocket"></i></span>
		<span tooltip="dev-icon dev-icon-rocket_alt"><i class="dev-icon dev-icon-rocket_alt"></i></span>
		<span tooltip="dev-icon dev-icon-lock"><i class="dev-icon dev-icon-lock"></i></span>
		<span tooltip="dev-icon dev-icon-unlock"><i class="dev-icon dev-icon-unlock"></i></span>
		<span tooltip="dev-icon dev-icon-plugin"><i class="dev-icon dev-icon-plugin"></i></span>
		<span tooltip="dev-icon dev-icon-caret_up"><i class="dev-icon dev-icon-caret_up"></i></span>
		<span tooltip="dev-icon dev-icon-caret_right"><i class="dev-icon dev-icon-caret_right"></i></span>
		<span tooltip="dev-icon dev-icon-caret_down"><i class="dev-icon dev-icon-caret_down"></i></span>
		<span tooltip="dev-icon dev-icon-caret_left"><i class="dev-icon dev-icon-caret_left"></i></span>
		<span tooltip="dev-icon dev-icon-power"><i class="dev-icon dev-icon-power"></i></span>
		<span tooltip="dev-icon dev-icon-radio_default"><i class="dev-icon dev-icon-radio_default"></i></span>
		<span tooltip="dev-icon dev-icon-radio"><i class="dev-icon dev-icon-radio"></i></span>
		<span tooltip="dev-icon dev-icon-radio_checked"><i class="dev-icon dev-icon-radio_checked"></i></span>
		<span tooltip="dev-icon dev-icon-cross"><i class="dev-icon dev-icon-cross"></i></span>
		<span tooltip="dev-icon dev-icon-tick"><i class="dev-icon dev-icon-tick"></i></span>
		<span tooltip="dev-icon dev-icon-search"><i class="dev-icon dev-icon-search"></i></span>
		<span tooltip="dev-icon dev-icon-info"><i class="dev-icon dev-icon-info"></i></span>
		<span tooltip="dev-icon dev-icon-devman"><i class="dev-icon dev-icon-devman"></i></span>
		<span tooltip="dev-icon dev-icon-upfront"><i class="dev-icon dev-icon-upfront"></i></span>
		<span tooltip="dev-icon dev-icon-hummingbird"><i class="dev-icon dev-icon-hummingbird"></i></span>
		<span tooltip="dev-icon dev-icon-defender"><i class="dev-icon dev-icon-defender"></i></span>
		<span tooltip="dev-icon dev-icon-theme"><i class="dev-icon dev-icon-theme"></i></span>
		<span tooltip="dev-icon dev-icon-pencil"><i class="dev-icon dev-icon-pencil"></i></span>
		<span tooltip="dev-icon dev-icon-star"><i class="dev-icon dev-icon-star"></i></span>
		<span tooltip="dev-icon dev-icon-trash"><i class="dev-icon dev-icon-trash"></i></span>
		<span tooltip="dev-icon dev-icon-recycle"><i class="dev-icon dev-icon-recycle"></i></span>
		<span tooltip="dev-icon dev-icon-fix"><i class="dev-icon dev-icon-fix"></i></span>
		<span tooltip="dev-icon dev-icon-edit"><i class="dev-icon dev-icon-edit"></i></span>
		<span tooltip="dev-icon dev-icon-options"><i class="dev-icon dev-icon-options"></i></span>
		<span tooltip="dev-icon dev-icon-cog"><i class="dev-icon dev-icon-cog"></i></span>
		<span tooltip="dev-icon dev-icon-badge"><i class="dev-icon dev-icon-badge"></i></span>
		<span tooltip="dev-icon dev-icon-cylinder"><i class="dev-icon dev-icon-cylinder"></i></span>
		<span tooltip="dev-icon dev-icon-trophy"><i class="dev-icon dev-icon-trophy"></i></span>
		<span tooltip="dev-icon dev-icon-bell"><i class="dev-icon dev-icon-bell"></i></span>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Fontawesome Icons</h3>
	</div>
	<div class="box-content">
		<span tooltip="wdv-icon wdv-icon-glass"><i class="wdv-icon wdv-icon-fw wdv-icon-glass"></i></span>
		<span tooltip="wdv-icon wdv-icon-music"><i class="wdv-icon wdv-icon-fw wdv-icon-music"></i></span>
		<span tooltip="wdv-icon wdv-icon-search"><i class="wdv-icon wdv-icon-fw wdv-icon-search"></i></span>
		<span tooltip="wdv-icon wdv-icon-envelope"><i class="wdv-icon wdv-icon-fw wdv-icon-envelope"></i></span>
		<span tooltip="wdv-icon wdv-icon-heart"><i class="wdv-icon wdv-icon-fw wdv-icon-heart"></i></span>
		<span tooltip="wdv-icon wdv-icon-star"><i class="wdv-icon wdv-icon-fw wdv-icon-star"></i></span>
		<span tooltip="wdv-icon wdv-icon-star-empty"><i class="wdv-icon wdv-icon-fw wdv-icon-star-empty"></i></span>
		<span tooltip="wdv-icon wdv-icon-user"><i class="wdv-icon wdv-icon-fw wdv-icon-user"></i></span>
		<span tooltip="wdv-icon wdv-icon-film"><i class="wdv-icon wdv-icon-fw wdv-icon-film"></i></span>
		<span tooltip="wdv-icon wdv-icon-th-large"><i class="wdv-icon wdv-icon-fw wdv-icon-th-large"></i></span>
		<span tooltip="wdv-icon wdv-icon-th"><i class="wdv-icon wdv-icon-fw wdv-icon-th"></i></span>
		<span tooltip="wdv-icon wdv-icon-th-list"><i class="wdv-icon wdv-icon-fw wdv-icon-th-list"></i></span>
		<span tooltip="wdv-icon wdv-icon-ok"><i class="wdv-icon wdv-icon-fw wdv-icon-ok"></i></span>
		<span tooltip="wdv-icon wdv-icon-remove"><i class="wdv-icon wdv-icon-fw wdv-icon-remove"></i></span>
		<span tooltip="wdv-icon wdv-icon-zoom-in"><i class="wdv-icon wdv-icon-fw wdv-icon-zoom-in"></i></span>
		<span tooltip="wdv-icon wdv-icon-zoom-out"><i class="wdv-icon wdv-icon-fw wdv-icon-zoom-out"></i></span>
		<span tooltip="wdv-icon wdv-icon-off"><i class="wdv-icon wdv-icon-fw wdv-icon-off"></i></span>
		<span tooltip="wdv-icon wdv-icon-signal"><i class="wdv-icon wdv-icon-fw wdv-icon-signal"></i></span>
		<span tooltip="wdv-icon wdv-icon-cog"><i class="wdv-icon wdv-icon-fw wdv-icon-cog"></i></span>
		<span tooltip="wdv-icon wdv-icon-trash"><i class="wdv-icon wdv-icon-fw wdv-icon-trash"></i></span>
		<span tooltip="wdv-icon wdv-icon-home"><i class="wdv-icon wdv-icon-fw wdv-icon-home"></i></span>
		<span tooltip="wdv-icon wdv-icon-file"><i class="wdv-icon wdv-icon-fw wdv-icon-file"></i></span>
		<span tooltip="wdv-icon wdv-icon-time"><i class="wdv-icon wdv-icon-fw wdv-icon-time"></i></span>
		<span tooltip="wdv-icon wdv-icon-road"><i class="wdv-icon wdv-icon-fw wdv-icon-road"></i></span>
		<span tooltip="wdv-icon wdv-icon-download-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-download-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-download"><i class="wdv-icon wdv-icon-fw wdv-icon-download"></i></span>
		<span tooltip="wdv-icon wdv-icon-upload"><i class="wdv-icon wdv-icon-fw wdv-icon-upload"></i></span>
		<span tooltip="wdv-icon wdv-icon-inbox"><i class="wdv-icon wdv-icon-fw wdv-icon-inbox"></i></span>
		<span tooltip="wdv-icon wdv-icon-play-circle"><i class="wdv-icon wdv-icon-fw wdv-icon-play-circle"></i></span>
		<span tooltip="wdv-icon wdv-icon-repeat"><i class="wdv-icon wdv-icon-fw wdv-icon-repeat"></i></span>
		<span tooltip="wdv-icon wdv-icon-refresh"><i class="wdv-icon wdv-icon-fw wdv-icon-refresh"></i></span>
		<span tooltip="wdv-icon wdv-icon-list-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-list-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-lock"><i class="wdv-icon wdv-icon-fw wdv-icon-lock"></i></span>
		<span tooltip="wdv-icon wdv-icon-flag"><i class="wdv-icon wdv-icon-fw wdv-icon-flag"></i></span>
		<span tooltip="wdv-icon wdv-icon-headphones"><i class="wdv-icon wdv-icon-fw wdv-icon-headphones"></i></span>
		<span tooltip="wdv-icon wdv-icon-volume-off"><i class="wdv-icon wdv-icon-fw wdv-icon-volume-off"></i></span>
		<span tooltip="wdv-icon wdv-icon-volume-down"><i class="wdv-icon wdv-icon-fw wdv-icon-volume-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-volume-up"><i class="wdv-icon wdv-icon-fw wdv-icon-volume-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-qrcode"><i class="wdv-icon wdv-icon-fw wdv-icon-qrcode"></i></span>
		<span tooltip="wdv-icon wdv-icon-barcode"><i class="wdv-icon wdv-icon-fw wdv-icon-barcode"></i></span>
		<span tooltip="wdv-icon wdv-icon-tag"><i class="wdv-icon wdv-icon-fw wdv-icon-tag"></i></span>
		<span tooltip="wdv-icon wdv-icon-tags"><i class="wdv-icon wdv-icon-fw wdv-icon-tags"></i></span>
		<span tooltip="wdv-icon wdv-icon-book"><i class="wdv-icon wdv-icon-fw wdv-icon-book"></i></span>
		<span tooltip="wdv-icon wdv-icon-bookmark"><i class="wdv-icon wdv-icon-fw wdv-icon-bookmark"></i></span>
		<span tooltip="wdv-icon wdv-icon-print"><i class="wdv-icon wdv-icon-fw wdv-icon-print"></i></span>
		<span tooltip="wdv-icon wdv-icon-camera"><i class="wdv-icon wdv-icon-fw wdv-icon-camera"></i></span>
		<span tooltip="wdv-icon wdv-icon-font"><i class="wdv-icon wdv-icon-fw wdv-icon-font"></i></span>
		<span tooltip="wdv-icon wdv-icon-bold"><i class="wdv-icon wdv-icon-fw wdv-icon-bold"></i></span>
		<span tooltip="wdv-icon wdv-icon-italic"><i class="wdv-icon wdv-icon-fw wdv-icon-italic"></i></span>
		<span tooltip="wdv-icon wdv-icon-text-height"><i class="wdv-icon wdv-icon-fw wdv-icon-text-height"></i></span>
		<span tooltip="wdv-icon wdv-icon-text-width"><i class="wdv-icon wdv-icon-fw wdv-icon-text-width"></i></span>
		<span tooltip="wdv-icon wdv-icon-align-left"><i class="wdv-icon wdv-icon-fw wdv-icon-align-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-align-center"><i class="wdv-icon wdv-icon-fw wdv-icon-align-center"></i></span>
		<span tooltip="wdv-icon wdv-icon-align-right"><i class="wdv-icon wdv-icon-fw wdv-icon-align-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-align-justify"><i class="wdv-icon wdv-icon-fw wdv-icon-align-justify"></i></span>
		<span tooltip="wdv-icon wdv-icon-list"><i class="wdv-icon wdv-icon-fw wdv-icon-list"></i></span>
		<span tooltip="wdv-icon wdv-icon-indent-left"><i class="wdv-icon wdv-icon-fw wdv-icon-indent-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-indent-right"><i class="wdv-icon wdv-icon-fw wdv-icon-indent-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-facetime-video"><i class="wdv-icon wdv-icon-fw wdv-icon-facetime-video"></i></span>
		<span tooltip="wdv-icon wdv-icon-picture"><i class="wdv-icon wdv-icon-fw wdv-icon-picture"></i></span>
		<span tooltip="wdv-icon wdv-icon-pencil"><i class="wdv-icon wdv-icon-fw wdv-icon-pencil"></i></span>
		<span tooltip="wdv-icon wdv-icon-map-marker"><i class="wdv-icon wdv-icon-fw wdv-icon-map-marker"></i></span>
		<span tooltip="wdv-icon wdv-icon-adjust"><i class="wdv-icon wdv-icon-fw wdv-icon-adjust"></i></span>
		<span tooltip="wdv-icon wdv-icon-tint"><i class="wdv-icon wdv-icon-fw wdv-icon-tint"></i></span>
		<span tooltip="wdv-icon wdv-icon-edit"><i class="wdv-icon wdv-icon-fw wdv-icon-edit"></i></span>
		<span tooltip="wdv-icon wdv-icon-share"><i class="wdv-icon wdv-icon-fw wdv-icon-share"></i></span>
		<span tooltip="wdv-icon wdv-icon-check"><i class="wdv-icon wdv-icon-fw wdv-icon-check"></i></span>
		<span tooltip="wdv-icon wdv-icon-move"><i class="wdv-icon wdv-icon-fw wdv-icon-move"></i></span>
		<span tooltip="wdv-icon wdv-icon-step-backward"><i class="wdv-icon wdv-icon-fw wdv-icon-step-backward"></i></span>
		<span tooltip="wdv-icon wdv-icon-fast-backward"><i class="wdv-icon wdv-icon-fw wdv-icon-fast-backward"></i></span>
		<span tooltip="wdv-icon wdv-icon-backward"><i class="wdv-icon wdv-icon-fw wdv-icon-backward"></i></span>
		<span tooltip="wdv-icon wdv-icon-play"><i class="wdv-icon wdv-icon-fw wdv-icon-play"></i></span>
		<span tooltip="wdv-icon wdv-icon-pause"><i class="wdv-icon wdv-icon-fw wdv-icon-pause"></i></span>
		<span tooltip="wdv-icon wdv-icon-stop"><i class="wdv-icon wdv-icon-fw wdv-icon-stop"></i></span>
		<span tooltip="wdv-icon wdv-icon-forward"><i class="wdv-icon wdv-icon-fw wdv-icon-forward"></i></span>
		<span tooltip="wdv-icon wdv-icon-fast-forward"><i class="wdv-icon wdv-icon-fw wdv-icon-fast-forward"></i></span>
		<span tooltip="wdv-icon wdv-icon-step-forward"><i class="wdv-icon wdv-icon-fw wdv-icon-step-forward"></i></span>
		<span tooltip="wdv-icon wdv-icon-eject"><i class="wdv-icon wdv-icon-fw wdv-icon-eject"></i></span>
		<span tooltip="wdv-icon wdv-icon-chevron-left"><i class="wdv-icon wdv-icon-fw wdv-icon-chevron-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-chevron-right"><i class="wdv-icon wdv-icon-fw wdv-icon-chevron-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-plus-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-plus-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-minus-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-minus-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-remove-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-remove-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-ok-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-ok-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-question-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-question-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-info-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-info-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-screenshot"><i class="wdv-icon wdv-icon-fw wdv-icon-screenshot"></i></span>
		<span tooltip="wdv-icon wdv-icon-remove-circle"><i class="wdv-icon wdv-icon-fw wdv-icon-remove-circle"></i></span>
		<span tooltip="wdv-icon wdv-icon-ok-circle"><i class="wdv-icon wdv-icon-fw wdv-icon-ok-circle"></i></span>
		<span tooltip="wdv-icon wdv-icon-ban-circle"><i class="wdv-icon wdv-icon-fw wdv-icon-ban-circle"></i></span>
		<span tooltip="wdv-icon wdv-icon-arrow-left"><i class="wdv-icon wdv-icon-fw wdv-icon-arrow-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-arrow-right"><i class="wdv-icon wdv-icon-fw wdv-icon-arrow-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-arrow-up"><i class="wdv-icon wdv-icon-fw wdv-icon-arrow-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-arrow-down"><i class="wdv-icon wdv-icon-fw wdv-icon-arrow-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-share-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-share-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-resize-full"><i class="wdv-icon wdv-icon-fw wdv-icon-resize-full"></i></span>
		<span tooltip="wdv-icon wdv-icon-resize-small"><i class="wdv-icon wdv-icon-fw wdv-icon-resize-small"></i></span>
		<span tooltip="wdv-icon wdv-icon-plus"><i class="wdv-icon wdv-icon-fw wdv-icon-plus"></i></span>
		<span tooltip="wdv-icon wdv-icon-minus"><i class="wdv-icon wdv-icon-fw wdv-icon-minus"></i></span>
		<span tooltip="wdv-icon wdv-icon-asterisk"><i class="wdv-icon wdv-icon-fw wdv-icon-asterisk"></i></span>
		<span tooltip="wdv-icon wdv-icon-exclamation-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-exclamation-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-gift"><i class="wdv-icon wdv-icon-fw wdv-icon-gift"></i></span>
		<span tooltip="wdv-icon wdv-icon-leaf"><i class="wdv-icon wdv-icon-fw wdv-icon-leaf"></i></span>
		<span tooltip="wdv-icon wdv-icon-fire"><i class="wdv-icon wdv-icon-fw wdv-icon-fire"></i></span>
		<span tooltip="wdv-icon wdv-icon-eye-open"><i class="wdv-icon wdv-icon-fw wdv-icon-eye-open"></i></span>
		<span tooltip="wdv-icon wdv-icon-eye-close"><i class="wdv-icon wdv-icon-fw wdv-icon-eye-close"></i></span>
		<span tooltip="wdv-icon wdv-icon-warning-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-plane"><i class="wdv-icon wdv-icon-fw wdv-icon-plane"></i></span>
		<span tooltip="wdv-icon wdv-icon-calendar"><i class="wdv-icon wdv-icon-fw wdv-icon-calendar"></i></span>
		<span tooltip="wdv-icon wdv-icon-random"><i class="wdv-icon wdv-icon-fw wdv-icon-random"></i></span>
		<span tooltip="wdv-icon wdv-icon-comment"><i class="wdv-icon wdv-icon-fw wdv-icon-comment"></i></span>
		<span tooltip="wdv-icon wdv-icon-magnet"><i class="wdv-icon wdv-icon-fw wdv-icon-magnet"></i></span>
		<span tooltip="wdv-icon wdv-icon-chevron-up"><i class="wdv-icon wdv-icon-fw wdv-icon-chevron-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-chevron-down"><i class="wdv-icon wdv-icon-fw wdv-icon-chevron-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-retweet"><i class="wdv-icon wdv-icon-fw wdv-icon-retweet"></i></span>
		<span tooltip="wdv-icon wdv-icon-shopping-cart"><i class="wdv-icon wdv-icon-fw wdv-icon-shopping-cart"></i></span>
		<span tooltip="wdv-icon wdv-icon-folder-close"><i class="wdv-icon wdv-icon-fw wdv-icon-folder-close"></i></span>
		<span tooltip="wdv-icon wdv-icon-folder-open"><i class="wdv-icon wdv-icon-fw wdv-icon-folder-open"></i></span>
		<span tooltip="wdv-icon wdv-icon-resize-vertical"><i class="wdv-icon wdv-icon-fw wdv-icon-resize-vertical"></i></span>
		<span tooltip="wdv-icon wdv-icon-resize-horizontal"><i class="wdv-icon wdv-icon-fw wdv-icon-resize-horizontal"></i></span>
		<span tooltip="wdv-icon wdv-icon-bar-chart"><i class="wdv-icon wdv-icon-fw wdv-icon-bar-chart"></i></span>
		<span tooltip="wdv-icon wdv-icon-twitter-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-twitter-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-facebook-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-facebook-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-camera-retro"><i class="wdv-icon wdv-icon-fw wdv-icon-camera-retro"></i></span>
		<span tooltip="wdv-icon wdv-icon-key"><i class="wdv-icon wdv-icon-fw wdv-icon-key"></i></span>
		<span tooltip="wdv-icon wdv-icon-cogs"><i class="wdv-icon wdv-icon-fw wdv-icon-cogs"></i></span>
		<span tooltip="wdv-icon wdv-icon-comments"><i class="wdv-icon wdv-icon-fw wdv-icon-comments"></i></span>
		<span tooltip="wdv-icon wdv-icon-thumbs-up"><i class="wdv-icon wdv-icon-fw wdv-icon-thumbs-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-thumbs-down"><i class="wdv-icon wdv-icon-fw wdv-icon-thumbs-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-star-half"><i class="wdv-icon wdv-icon-fw wdv-icon-star-half"></i></span>
		<span tooltip="wdv-icon wdv-icon-heart-empty"><i class="wdv-icon wdv-icon-fw wdv-icon-heart-empty"></i></span>
		<span tooltip="wdv-icon wdv-icon-signout"><i class="wdv-icon wdv-icon-fw wdv-icon-signout"></i></span>
		<span tooltip="wdv-icon wdv-icon-linkedin-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-linkedin-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-pushpin"><i class="wdv-icon wdv-icon-fw wdv-icon-pushpin"></i></span>
		<span tooltip="wdv-icon wdv-icon-external-link"><i class="wdv-icon wdv-icon-fw wdv-icon-external-link"></i></span>
		<span tooltip="wdv-icon wdv-icon-signin"><i class="wdv-icon wdv-icon-fw wdv-icon-signin"></i></span>
		<span tooltip="wdv-icon wdv-icon-trophy"><i class="wdv-icon wdv-icon-fw wdv-icon-trophy"></i></span>
		<span tooltip="wdv-icon wdv-icon-github-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-github-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-upload-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-upload-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-lemon"><i class="wdv-icon wdv-icon-fw wdv-icon-lemon"></i></span>
		<span tooltip="wdv-icon wdv-icon-phone"><i class="wdv-icon wdv-icon-fw wdv-icon-phone"></i></span>
		<span tooltip="wdv-icon wdv-icon-check-empty"><i class="wdv-icon wdv-icon-fw wdv-icon-check-empty"></i></span>
		<span tooltip="wdv-icon wdv-icon-bookmark-empty"><i class="wdv-icon wdv-icon-fw wdv-icon-bookmark-empty"></i></span>
		<span tooltip="wdv-icon wdv-icon-phone-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-phone-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-twitter"><i class="wdv-icon wdv-icon-fw wdv-icon-twitter"></i></span>
		<span tooltip="wdv-icon wdv-icon-facebook"><i class="wdv-icon wdv-icon-fw wdv-icon-facebook"></i></span>
		<span tooltip="wdv-icon wdv-icon-github"><i class="wdv-icon wdv-icon-fw wdv-icon-github"></i></span>
		<span tooltip="wdv-icon wdv-icon-unlock"><i class="wdv-icon wdv-icon-fw wdv-icon-unlock"></i></span>
		<span tooltip="wdv-icon wdv-icon-credit-card"><i class="wdv-icon wdv-icon-fw wdv-icon-credit-card"></i></span>
		<span tooltip="wdv-icon wdv-icon-rss"><i class="wdv-icon wdv-icon-fw wdv-icon-rss"></i></span>
		<span tooltip="wdv-icon wdv-icon-hdd"><i class="wdv-icon wdv-icon-fw wdv-icon-hdd"></i></span>
		<span tooltip="wdv-icon wdv-icon-bullhorn"><i class="wdv-icon wdv-icon-fw wdv-icon-bullhorn"></i></span>
		<span tooltip="wdv-icon wdv-icon-bell"><i class="wdv-icon wdv-icon-fw wdv-icon-bell"></i></span>
		<span tooltip="wdv-icon wdv-icon-certificate"><i class="wdv-icon wdv-icon-fw wdv-icon-certificate"></i></span>
		<span tooltip="wdv-icon wdv-icon-hand-right"><i class="wdv-icon wdv-icon-fw wdv-icon-hand-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-hand-left"><i class="wdv-icon wdv-icon-fw wdv-icon-hand-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-hand-up"><i class="wdv-icon wdv-icon-fw wdv-icon-hand-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-hand-down"><i class="wdv-icon wdv-icon-fw wdv-icon-hand-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-circle-arrow-left"><i class="wdv-icon wdv-icon-fw wdv-icon-circle-arrow-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-circle-arrow-right"><i class="wdv-icon wdv-icon-fw wdv-icon-circle-arrow-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-circle-arrow-up"><i class="wdv-icon wdv-icon-fw wdv-icon-circle-arrow-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-circle-arrow-down"><i class="wdv-icon wdv-icon-fw wdv-icon-circle-arrow-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-globe"><i class="wdv-icon wdv-icon-fw wdv-icon-globe"></i></span>
		<span tooltip="wdv-icon wdv-icon-wrench"><i class="wdv-icon wdv-icon-fw wdv-icon-wrench"></i></span>
		<span tooltip="wdv-icon wdv-icon-tasks"><i class="wdv-icon wdv-icon-fw wdv-icon-tasks"></i></span>
		<span tooltip="wdv-icon wdv-icon-filter"><i class="wdv-icon wdv-icon-fw wdv-icon-filter"></i></span>
		<span tooltip="wdv-icon wdv-icon-briefcase"><i class="wdv-icon wdv-icon-fw wdv-icon-briefcase"></i></span>
		<span tooltip="wdv-icon wdv-icon-fullscreen"><i class="wdv-icon wdv-icon-fw wdv-icon-fullscreen"></i></span>
		<span tooltip="wdv-icon wdv-icon-group"><i class="wdv-icon wdv-icon-fw wdv-icon-group"></i></span>
		<span tooltip="wdv-icon wdv-icon-link"><i class="wdv-icon wdv-icon-fw wdv-icon-link"></i></span>
		<span tooltip="wdv-icon wdv-icon-cloud"><i class="wdv-icon wdv-icon-fw wdv-icon-cloud"></i></span>
		<span tooltip="wdv-icon wdv-icon-beaker"><i class="wdv-icon wdv-icon-fw wdv-icon-beaker"></i></span>
		<span tooltip="wdv-icon wdv-icon-cut"><i class="wdv-icon wdv-icon-fw wdv-icon-cut"></i></span>
		<span tooltip="wdv-icon wdv-icon-copy"><i class="wdv-icon wdv-icon-fw wdv-icon-copy"></i></span>
		<span tooltip="wdv-icon wdv-icon-paper-clip"><i class="wdv-icon wdv-icon-fw wdv-icon-paper-clip"></i></span>
		<span tooltip="wdv-icon wdv-icon-save"><i class="wdv-icon wdv-icon-fw wdv-icon-save"></i></span>
		<span tooltip="wdv-icon wdv-icon-sign-blank"><i class="wdv-icon wdv-icon-fw wdv-icon-sign-blank"></i></span>
		<span tooltip="wdv-icon wdv-icon-reorder"><i class="wdv-icon wdv-icon-fw wdv-icon-reorder"></i></span>
		<span tooltip="wdv-icon wdv-icon-list-ul"><i class="wdv-icon wdv-icon-fw wdv-icon-list-ul"></i></span>
		<span tooltip="wdv-icon wdv-icon-list-ol"><i class="wdv-icon wdv-icon-fw wdv-icon-list-ol"></i></span>
		<span tooltip="wdv-icon wdv-icon-strikethrough"><i class="wdv-icon wdv-icon-fw wdv-icon-strikethrough"></i></span>
		<span tooltip="wdv-icon wdv-icon-underline"><i class="wdv-icon wdv-icon-fw wdv-icon-underline"></i></span>
		<span tooltip="wdv-icon wdv-icon-table"><i class="wdv-icon wdv-icon-fw wdv-icon-table"></i></span>
		<span tooltip="wdv-icon wdv-icon-magic"><i class="wdv-icon wdv-icon-fw wdv-icon-magic"></i></span>
		<span tooltip="wdv-icon wdv-icon-truck"><i class="wdv-icon wdv-icon-fw wdv-icon-truck"></i></span>
		<span tooltip="wdv-icon wdv-icon-pinterest"><i class="wdv-icon wdv-icon-fw wdv-icon-pinterest"></i></span>
		<span tooltip="wdv-icon wdv-icon-pinterest-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-pinterest-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-google-plus-sign"><i class="wdv-icon wdv-icon-fw wdv-icon-google-plus-sign"></i></span>
		<span tooltip="wdv-icon wdv-icon-google-plus"><i class="wdv-icon wdv-icon-fw wdv-icon-google-plus"></i></span>
		<span tooltip="wdv-icon wdv-icon-money"><i class="wdv-icon wdv-icon-fw wdv-icon-money"></i></span>
		<span tooltip="wdv-icon wdv-icon-caret-down"><i class="wdv-icon wdv-icon-fw wdv-icon-caret-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-caret-up"><i class="wdv-icon wdv-icon-fw wdv-icon-caret-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-caret-left"><i class="wdv-icon wdv-icon-fw wdv-icon-caret-left"></i></span>
		<span tooltip="wdv-icon wdv-icon-caret-right"><i class="wdv-icon wdv-icon-fw wdv-icon-caret-right"></i></span>
		<span tooltip="wdv-icon wdv-icon-columns"><i class="wdv-icon wdv-icon-fw wdv-icon-columns"></i></span>
		<span tooltip="wdv-icon wdv-icon-sort"><i class="wdv-icon wdv-icon-fw wdv-icon-sort"></i></span>
		<span tooltip="wdv-icon wdv-icon-sort-down"><i class="wdv-icon wdv-icon-fw wdv-icon-sort-down"></i></span>
		<span tooltip="wdv-icon wdv-icon-sort-up"><i class="wdv-icon wdv-icon-fw wdv-icon-sort-up"></i></span>
		<span tooltip="wdv-icon wdv-icon-envelope-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-envelope-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-linkedin"><i class="wdv-icon wdv-icon-fw wdv-icon-linkedin"></i></span>
		<span tooltip="wdv-icon wdv-icon-undo"><i class="wdv-icon wdv-icon-fw wdv-icon-undo"></i></span>
		<span tooltip="wdv-icon wdv-icon-legal"><i class="wdv-icon wdv-icon-fw wdv-icon-legal"></i></span>
		<span tooltip="wdv-icon wdv-icon-dashboard"><i class="wdv-icon wdv-icon-fw wdv-icon-dashboard"></i></span>
		<span tooltip="wdv-icon wdv-icon-comment-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-comment-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-comments-alt"><i class="wdv-icon wdv-icon-fw wdv-icon-comments-alt"></i></span>
		<span tooltip="wdv-icon wdv-icon-bolt"><i class="wdv-icon wdv-icon-fw wdv-icon-bolt"></i></span>
		<span tooltip="wdv-icon wdv-icon-sitemap"><i class="wdv-icon wdv-icon-fw wdv-icon-sitemap"></i></span>
		<span tooltip="wdv-icon wdv-icon-umbrella"><i class="wdv-icon wdv-icon-fw wdv-icon-umbrella"></i></span>
		<span tooltip="wdv-icon wdv-icon-paste"><i class="wdv-icon wdv-icon-fw wdv-icon-paste"></i></span>
		<span tooltip="wdv-icon wdv-icon-user-md"><i class="wdv-icon wdv-icon-fw wdv-icon-user-md"></i></span>
	</div>
</section>

</div>

</div>

<div class="row">
<div class="col-half">
<section class="dev-box">
	<div class="box-title">
		<h3>Tab box</h3>
	</div>
	<div class="box-content">

		<div class="tabs">
			<section class="tab">
				<input type="radio" id="tab-11" name="tab-group-1" checked>
				<label for="tab-11">HTML</label>

				<div class="content">
					<pre>
&lt;div class="<b>tabs</b>">
    <i style="color:#5BB">&lt;!-- First tab --></i>
    &lt;section class="<b>tab</b>">
        &lt;input type="radio" id="<b>tab-1</b>" name="tab-group" <b>checked</b>>
        &lt;label for="<b>tab-1</b>">Tab 1&lt;/label>

        &lt;div class="<b>content</b>">
            The tab content
        &lt;/div>
    &lt;/section>

    <i style="color:#5BB">&lt;!-- Second tab --></i>
    &lt;section class="<b>tab</b>">
        &lt;input type="radio" id="<b>tab-2</b>" name="tab-group">
        &lt;label for="<b>tab-2</b>">Tab 2&lt;/label>

        &lt;div class="<b>content</b>">
            The tab content
        &lt;/div>
    &lt;/section>
&lt;/div></pre>

				</div>
			</section>

			<section class="tab">
				<input type="radio" id="tab-12" name="tab-group-1">
				<label for="tab-12">Tab 2</label>

				<div class="content">
					<p>This is another tab.</p>
				</div>
			</section>

			<section class="tab">
				<input type="radio" id="tab-13" name="tab-group-1">
				<label for="tab-13">Tab 3</label>

				<div class="content">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</div>
			</section>
		</div>

	</div>
</section>

<div class="tabs">
	<section class="tab">
		<input type="radio" id="tab-21" name="tab-group-2" checked>
		<label for="tab-21">Info</label>

		<div class="content">
			<p>The tab-code for this is displayed in the "HTML" tab on the left side. You can place the code inside a <i>box</i> or inside a <i>grid-cell</i>, like this:</p>
			<pre>
<i style="color:#5BB">&lt;!-- inside box --></i>
&lt;div class="<b>dev-box</b>">
    ...
    &lt;div class="<b>box-content</b>">
        &lt;div class="<b>tabs</b>">...&lt;/div>
    &lt;/div>
&lt;/div>

<i style="color:#5BB">&lt;!-- inside grid cell --></i>
&lt;div class="<b>row</b>">
    &lt;div class="<b>col-half</b>">
        &lt;div class="<b>tabs</b>">...&lt;/div>
    &lt;/div>
&lt;/div></pre>
		</div>
	</section>

	<section class="tab">
		<input type="radio" id="tab-22" name="tab-group-2">
		<label for="tab-22">Tab 2</label>

		<div class="content">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation divlamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</section>

	<section class="tab">
		<input type="radio" id="tab-23" name="tab-group-2">
		<label for="tab-23">Tab 3</label>

		<div class="content">
			<p>Stuff for Tab 3</p>
		</div>
	</section>
</div>

<div class="vertical-tabs">
	<section class="tab">
		<input type="radio" name="tab_group1" id="tab_1" checked>
		<label for="tab_1">Info</label>
		<div class="content">
			<h2 class="tab-title">Info</h2>
			<p>This is the markup:</p>

<pre>&lt;div class="<b>vertical-tabs</b>">
    <i style="color:#5BB">&lt;!-- First tab is displayed by CSS... --></i>

    &lt;section class="<b>tab</b>">
        &lt;input <b>type="radio"</b> name="tab_group1" id="tab_1" checked />
        &lt;<b>label</b> for="tab_1">Tab 1&lt;/label>

        &lt;div class="<b>content</b>">
            Tab 1
        &lt;/div>
    &lt;/section>

    <i style="color:#5BB">&lt;!-- Second tab uses a link to reload the page... --></i>
    &lt;section class="<b>tab</b>">
        &lt;input <b>type="radio"</b> name="tab_group1" id="tab_2" checked />
        &lt;<b>label</b> for="tab_2">
            &lt;a href="?some_param=tab2">Tab 2&lt;/a>
        &lt;/label>

        &lt;div class="<b>content</b>">
            Loading...
        &lt;/div>
    &lt;/section>

   <i style="color:#5BB">&lt;!-- add more .tab elements here... --></i>
&lt;/div>
</pre>

		</div>
	</section>

	<section class="tab">
		<input type="radio" name="tab_group1" id="tab_2">
		<label for="tab_2"><i class="dashicons dashicons-admin-page"></i> Pages</label>
		<div class="content">
			<h2 class="tab-title"><i class="dashicons dashicons-admin-page"></i> Pages</h2>
			Content of the second tab.
			<hr>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua...
		</div>
	</section>

	<section class="tab">
		<input type="radio" name="tab_group1" id="tab_3">
		<label for="tab_3"><i class="dashicons dashicons-admin-settings"></i> Settings</label>
		<div class="content">
			<h2 class="tab-title"><i class="dashicons dashicons-admin-settings"></i> Settings</h2>
			More demo content...
			<hr>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo...
		</div>
	</section>

	<section class="tab">
		<input type="radio" name="tab_group1" id="tab_4">
		<label for="tab_4"><i class="dashicons dashicons-admin-media"></i> Media</label>
		<div class="content">
			<h2 class="tab-title"><i class="dashicons dashicons-admin-media"></i> Media</h2>
			Oh my, more useless demo!
			<hr>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo...
		</div>
	</section>
</div>


<section class="dev-box">
	<div class="box-title">
		<h3>Typography</h3>
	</div>
	<div class="box-content">
		<h1>Heading 1</h1>
		<h2>Heading 2</h2>
		<h3>Heading 3</h3>
		<h4>Heading 4</h4>
		<h5>Heading 5</h5>
		<h6>Heading 6</h6>
		<p><big><dfn tooltip="<p><big>...</big></p>">BIG TEXT</dfn>: Lorem <strong>ipsum dolor</strong> sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore <em>"magna aliqua"</em>. Ut enim <u>ad minim</u> veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip <a href="#">ex ea commodo</a></big></p>
		<p><dfn tooltip="<p>...</p>">DEFAULT TEXT</dfn>: Lorem <strong>ipsum dolor</strong> sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore <em>"magna aliqua"</em>. Ut enim <u>ad minim</u> veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip <a href="#">ex ea commodo</a>
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p><small><dfn tooltip="<p><small>...</small></p>">SMALL TEXT</dfn>: Lorem <strong>ipsum dolor</strong> sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore <em>"magna aliqua"</em>. Ut enim <u>ad minim</u> veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip <a href="#">ex ea commodo</a>
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small></p>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Notifications</h3>
	</div>
	<div class="box-content">
		<p>There are some javascript functions that can trigger notifications.</p>
		<p>
		<code style="cursor:pointer" onclick="note_demo1()"><i class="wdv-icon wdv-icon-play-circle"></i> WDP.showSuccess()</code>
		<br>
		<code style="cursor:pointer" onclick="note_demo2()"><i class="wdv-icon wdv-icon-play-circle"></i> WDP.showError()</code>
		<br>
		<code style="cursor:pointer" onclick="note_demo3()"><i class="wdv-icon wdv-icon-play-circle"></i> WDP.showError("You clicked the wrong button")</code>
		<br>
		<code style="cursor:pointer" onclick="note_demo4()"><i class="wdv-icon wdv-icon-play-circle"></i> $('.load-demo').loading(true)</code><br>
		<code style="cursor:pointer" onclick="note_demo5()"><i class="wdv-icon wdv-icon-play-circle"></i> $('.load-demo').loading(true, "Wait 3 seconds")</code>
		</p>
		<p>
		<button type="button" class="load-demo">This is .load-demo</button>
		</p>

		<script>
		function note_demo1() {
			WDP.showSuccess();
		}
		function note_demo2() {
			WDP.showError();
		}
		function note_demo3() {
			WDP.showError("You clicked the wrong button");
		}
		function note_demo4() {
			jQuery('.load-demo').loading(true);
			window.setTimeout(function(){
				jQuery('.load-demo').loading(false);
			}, 3000);
		}
		function note_demo5() {
			jQuery('.load-demo').loading(true, "Wait 3 seconds");
			window.setTimeout(function(){
				jQuery('.load-demo').loading(false);
			}, 3000);
		}
		</script>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Lists</h3>
	</div>
	<div class="box-content">
		<p>
		Default listing displays items with a distinct list-icon and icon-color.<br>
		<code>&lt;ul class="<b>listing</b>">...&lt;/ul></code>
		</p>
		<ul class="listing">
			<li>Default layout: <code>&lt;li>Default icon&lt;/li></code></li>
			<li class="circle">Icon: <code>&lt;li class="<b>circle</b>">Circle&lt;/li></code></li>
			<li class="help">Icon: <code>&lt;li class="<b>help</b>">Help&lt;/li></code></li>
			<li class="up">Icon: <code>&lt;li class="<b>up</b>">Up&lt;/li></code></li>
			<li class="down">Icon: <code>&lt;li class="<b>down</b>">Down&lt;/li></code></li>
			<li class="logo">Icon: <code>&lt;li class="<b>logo</b>">WPMUDEV Logo&lt;/li></code></li>
			<li class="cross">Icon: <code>&lt;li class="<b>cross</b>">Cross&lt;/li></code></li>
			<li class="tick">Icon: <code>&lt;li class="<b>tick</b>">Alternate tick&lt;/li></code></li>
			<li class="lock">Icon: <code>&lt;li class="<b>lock</b>">Locked&lt;/li></code></li>
			<li class="unlock">Icon: <code>&lt;li class="<b>unlock</b>">Unlocked&lt;/li></code></li>
			<li class="black">Color: <code>&lt;li class="<b>black</b>">Black&lt;/li></code></li>
			<li class="red">Color: <code>&lt;li class="<b>red</b>">Red&lt;/li></code></li>
			<li class="green">Color: <code>&lt;li class="<b>green</b>">Green&lt;/li></code></li>
			<li class="yellow">Color: <code>&lt;li class="<b>yellow</b>">Yellow&lt;/li></code></li>
		</ul>
		<p>
		For special promotional lists the text should be bold.<br>
		<code>&lt;ul class="listing <b>bold</b>">...&lt;/ul></code>
		</p>
		<ul class="listing bold">
			<li>Bold text</li>
			<li>More bold text</li>
		</ul>
	</div>
</section>

</div>


<div class="col-half">
<section class="dev-box">
	<div class="box-title">
		<h3>Tooltips</h3>
	</div>
	<div class="box-content">
		<p>Any text can have a tooltip, like this: <dfn tooltip="Some sample text">Hover here!</dfn></p>
		<p>To create a tooltip all you need to do is add the attribute <code tooltip='<span tooltip="Your text">...</span>'>tooltip</code> to an element (hover over the code above for an example)</p>
		<hr>
		<p>Badges:</p>
		<p><span class="count">5</span> <code>&lt;span class="count">5&lt;/span></code></p>
		<p><span class="count notification">5</span> <code>&lt;span class="count notification">5&lt;/span></code></p>
		<p><span class="count reply">5</span> <code>&lt;span class="count reply">5&lt;/span></code></p>
		<p><span class="count reply notification">5</span> <code>&lt;span class="count reply notification">5&lt;/span></code></p>
		<hr />
		<div class="inline-notice">Default notification <code>class="inline-notice"</code> <button>OK</button></div>
		<div class="inline-notice ok">Success notification <code>class="inline-notice ok"</code> <button>OK</button></div>
		<div class="inline-notice err">Error notification <code>class="inline-notice err"</code> <button>OK</button></div>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Modal dialogs</h3>
	</div>
	<div class="box-content">
		<ul>
			<li>Here you can see a <a href="#demo" rel="dialog">normal dialog</a></li>
			<li>This is a <a href="#demo2" rel="dialog">small dialog</a></li>
			<li>A dialog <a href="#demo3" rel="dialog">without close button</a></li>
			<li>This is how a dialog <a href="#demo4" rel="dialog">with long content</a> looks like</li>
		</ul>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Form elements</h3>
	</div>
	<div class="box-content">
		<p class="group">
			<label for="inp1">Normal label</label>
			<input type="text" id="inp1" placeholder="Normal text input" />
		</p>
		<p class="group">
			<label for="inp2" class="inline-label">Inline label</label>
			<input type="text" id="inp2" placeholder="Normal text input" class="float-r" style="width:200px" />
		</p>
		<p class="group">
			<textarea placeholder="Textarea"></textarea>
		</p>
		<p class="group">
			<select>
			<option>Select value 1</option>
			<option>Select value 2</option>
			<option>Select value 3</option>
			</select>
		</p>
		<p class="group">
			<label class="inline-label" for="chk1">Normal checkbox:</label>
			<span class="float-r"><input type="checkbox" id="chk1" /></span>
		</p>
		<p class="group">
			<label class="inline-label" for="chk3">Styled checkbox:</label>
			<span class="toggle float-r">
				<input type="checkbox" class="toggle-checkbox" id="chk3" checked="checked" />
				<label class="toggle-label" for="chk3"></label>
			</span>
		</p>
		<p class="group">
			<label class="inline-label">Normal radio:</label>
			<span class="float-r">
				<input type="radio" name="r1" id="r1" value="1" />
				<input type="radio" name="r1" value="2" checked="checked" />
				<input type="radio" name="r1" value="3" />
				<input type="radio" name="r1" value="4" />
			</span>
		</p>
		<p class="group">
			<label class="inline-label">Styled radio:</label>
			<span class="radio-group float-r">
				<input type="radio" name="r2" id="r2-1" value="A" />
				<label for="r2-1">A</label>

				<input type="radio" name="r2" id="r2-2" value="B" checked="checked" />
				<label for="r2-2">B</label>

				<input type="radio" name="r2" id="r2-3" value="C" />
				<label for="r2-3">C<br>C</label>

				<input type="radio" name="r2" id="r2-4" value="D" />
				<label for="r2-4">D</label>
			</span>
		</p>
		<p class="group">
			<label class="inline-label">Styled radio 2:</label>
			<span class="radio-group with-icon float-r">
				<input type="radio" name="r3" id="r3-1" value="A" />
				<label for="r3-1">A<br>A</label>

				<input type="radio" name="r3" id="r3-2" value="B" checked="checked" />
				<label for="r3-2">B</label>

				<input type="radio" name="r3" id="r3-3" value="C" />
				<label for="r3-3">C</label>

				<input type="radio" name="r3" id="r3-4" value="D" />
				<label for="r3-4">D</label>
			</span>
		</p>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Tabular lists (simple)</h3>
	</div>
	<div class="box-content">
		<p>
		Simple lists can be created by using a UL list using the class <code>dev-list</code><br>
		This list has 2 columns, where the first column is left aligned and the second one right-aligned.<br>
		Modifiers: <code tooltip="Add hover effect to rows">hover-effect</code>, <code tooltip="Vertical align: top">top</code>, <code tooltip="Left-align for all columns">left</code>, <code tooltip="Do not wrap text, but hide/ellipsis on overflow">nowrap</code>, <code tooltip="Add top margin">inline</code>, <code tooltip="Reduce bottom margin">standalone</code>
		</p>
		<ul class="dev-list hover-effect inline">
			<li class="list-header">
				<div>
					<span class="list-label">Title 1</span>
					<span class="list-detail">Title 2</span>
				</div>
			</li>
			<li>
				<div>
					<span class="list-label">Label 1-A</span>
					<span class="list-detail">Label 1-B</span>
				</div>
			</li>
			<li>
				<div>
					<span class="list-label">Label 2-A</span>
					<span class="list-detail">Label 2-B</span>
				</div>
			</li>
		</ul>

		<pre>
&lt;ul class="<b>dev-list</b> hover-effect">
    &lt;li class="<b>list-header</b>">
        <b>&lt;div></b>
            &lt;span class="<b>list-label</b>">Title 1&lt;/span>
            &lt;span class="<b>list-detail</b>">Title 2&lt;/span>
        <b>&lt;/div></b>
    &lt;/li>
    &lt;li>
        <b>&lt;div></b>
            &lt;span class="<b>list-label</b>">Label 1&lt;/span>
            &lt;span class="<b>list-detail</b>">Label 2&lt;/span>
        <b>&lt;/div></b>
    &lt;/li>
&lt;/ul>
		</pre>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Tabular lists (complex)</h3>
	</div>
	<div class="box-content">
		<p>
		More complex lists can be created by using a TABLE element using the class <code>list-table</code>. <br>
		Modifiers: <code>hover-effect</code>
		</p>
		<table class="list-table hover-effect">
			<thead>
				<tr>
					<th>Col 1</th>
					<th>Col 2</th>
					<th>Col 3</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Row 1-A</td>
					<td>Row 1-B</td>
					<td class="tr">Row 1-C</td>
				</tr>
				<tr>
					<td>Row 2-A</td>
					<td>Row 2-B</td>
					<td class="tr">Row 2-C</td>
				</tr>
				<tr>
					<td>
					<div>
					<span class="toggle" tooltip="test">
						<input type="checkbox" class="toggle-checkbox" id="chk4" checked="checked" />
						<label class="toggle-label" for="chk4"></label>
					</span>
					</div>
					</td>
					<td class="tc">
					<span class="radio-group with-icon">
						<input type="radio" name="r4" id="r4-1" value="A" />
						<label for="r4-1"><i class="dev-icon dev-icon-book"></i></label>

						<input type="radio" name="r4" id="r4-2" value="B" checked="checked" />
						<label for="r4-2"><span tooltip="Test"></span><i class="dev-icon dev-icon-rocket_alt"></i></label>

						<input type="radio" name="r4" id="r4-3" value="C" />
						<label for="r4-3"><i class="dev-icon dev-icon-speach"></i></label>

						<input type="radio" name="r4" id="r4-4" value="D" />
						<label for="r4-4"><i class="dev-icon dev-icon-support"></i></label>
					</span>
					</td>
					<td class="tr">OK</td>
				</tr>
				<tr>
					<td>Row 4-A</td>
					<td><select><option>A<option>B<option>C<option>D<option>E</select></td>
					<td class="tr">Row 4-C</td>
				</tr>
				<tr>
					<td>Row 5-A</td>
					<td><select><option>A<option>B<option>C<option>D<option>E</select></td>
					<td class="tr">Row 5-C</td>
				</tr>
			</tbody>
		</table>
		<pre>
&lt;table class="<b>list-table</b> hover-effect">
    &lt;<b>thead</b>> <i style="color:#5BB">&lt;!-- thead must only contain th elements! --></i>
        &lt;tr>
            &lt;th>Col 1&lt;/th>
            &lt;th>Col 2&lt;/th>
            &lt;th>Col 3&lt;/th>
        &lt;/tr>
    &lt;/<b>thead</b>>
    &lt;<b>tbody</b>> <i style="color:#5BB">&lt;!-- tbody must only contain td elements! --></i>
        &lt;tr>
            &lt;td>Row 1-A&lt;/td>
            &lt;td>Row 1-B&lt;/td>
            &lt;td>Row 1-C&lt;/td>
        &lt;/tr>
        &lt;tr>
            &lt;td>Row 2-A&lt;/td>
            &lt;td>Row 2-B&lt;/td>
            &lt;td>Row 2-C&lt;/td>
        &lt;/tr>
    &lt;/<b>tbody</b>>
&lt;/table>
		</pre>
	</div>
</section>

<section class="dev-box">
	<div class="box-title">
		<h3>Search-Field</h3>
	</div>
	<div class="box-content">
		<p>All input fields with <code>type="search"</code> are converted to some advanced search fields that have special javascript events/functions:</p>
		<p>
		<code style="cursor:pointer" onclick="search_demo1()"><i class="wdv-icon wdv-icon-play-circle"></i> $('#search').trigger('progress:start')</code>
		<br>
		<code style="cursor:pointer" onclick="search_demo2()"><i class="wdv-icon wdv-icon-play-circle"></i> $('#search').trigger('progress:stop')</code>
		<br>
		<code style="cursor:pointer" onclick="search_demo3()"><i class="wdv-icon wdv-icon-play-circle"></i> $('#search').trigger('results:show', [items])</code>
		<br>
		<code style="cursor:pointer" onclick="search_demo4()"><i class="wdv-icon wdv-icon-play-circle"></i> $('#search').trigger('results:clear')</code>
		</p>

		<p>
		<strong>Demo</strong><br>
		<input type="search" id="inp-sea" placeholder="<input type='search' />" />
		</p>

		<p>
		The items-list of 'results:show' has this structure:
		</p>

		<pre>
var items = [
    {
        id: 1, <i style="color:#5BB">// This is sent as field-value on submit.</i>
        label: "First Item", <i style="color:#5BB">// Can contain HTML code.</i>
        thumb: "http://...img-1.png" <i style="color:#5BB">// Optional.</i>
    },
    {
        id: 2,
        label: "&lt;div <strong>class='title'</strong>>Second Item&lt;/div>&lt;em>Subtitle&lt;/em>",
        thumb: "http://...img-2.png"
    },
    <i style="color:#5BB">// More items...</i>
];
		</pre>

		<script>
		var _search = jQuery('#inp-sea');

		function search_demo1() {
			_search.trigger('progress:start');
		}
		function search_demo2() {
			_search.trigger('progress:stop');
		}
		function search_demo3() {
			var items = [
				{ id: 1, label: "Alfa", thumb: "http://lorempixel.com/40/40/abstract/1" },
				{ id: 2, label: "Bravo", thumb: "http://lorempixel.com/40/40/abstract/2" },
				{ id: 3, label: "Charlie", thumb: "http://lorempixel.com/40/40/abstract/3" },
				{ id: 4, label: "Delta", thumb: "http://lorempixel.com/40/40/abstract/4" },
				{ id: 5, label: "<div>Echo</div><em>No title defined here...</em>", thumb: "http://lorempixel.com/40/40/abstract/5" },
				{ id: 6, label: "<div class='title'>Foxtrot</div><em>Whiskey + Juliett + Hotel: Bravo Romeo!</em>", thumb: "http://lorempixel.com/40/40/abstract/6" },
				{ id: 7, label: "<div style='height:20px;background:url(http://lorempixel.com/200/20/abstract/7)'></div><em>The sport or the car?</em><div class='title'>Golf</div>", thumb: "http://lorempixel.com/40/40/abstract/7" },
				{ id: 8, label: "<div class='title'>Hotel</div>", thumb: "http://lorempixel.com/40/40/abstract/8" },
				{ id: 9, label: "<div class='title'>India</div><div>Contains following items:</div><ol><li>Chai<li>Cows<li>Beaches<li>Spices</ol>", thumb: "http://lorempixel.com/40/40/abstract/9" },
				{ id: 10, label: "<div class='title'>Juliett</div>", thumb: "http://lorempixel.com/40/40/abstract/10" },
			];
			_search.trigger('results:show', [items]);
		}
		function search_demo4() {
			_search.trigger('results:clear');
		}
		</script>
	</div>
</section>
</div>


</div>








<hr>








<h5>Create the boxes</h5>
<b>A normal box, just like the ones on this page</b>:
<div><pre>&lt;section class="<b>dev-box</b>"&gt;
	&lt;div class="<b>box-title</b>"&gt;
		&lt;<b>h3</b>&gt;Title here...&lt;/<b>h3</b>&gt;
	&lt;/div&gt;
	&lt;div class="<b>box-content</b>"&gt;
		Text here...
	&lt;/div&gt;
&lt;/section&gt;
</pre></div>

<h5>Create the grid</h5>
<b>Create a 3-column layout:</b>
<div><pre>&lt;div class="<b>row</b>"&gt;
	&lt;div class="<b>col-third</b>"&gt;
		(box code from above)
		(another box here)
		(another box here)
	&lt;/div&gt;
	&lt;div class="<b>col-third</b>"&gt;
		(another box here)
	&lt;/div&gt;
	&lt;div class="<b>col-third</b>"&gt;
		(another box here)
	&lt;/div&gt;
&lt;/div&gt;</pre></div>
<br>
<br>
<b>Create a 2-column layout:</b>
<div><pre>&lt;div class="<b>row</b>"&gt;
	&lt;div class="<b>col-half</b>"&gt;
		(another box here)
		(another box here)
	&lt;/div&gt;
	&lt;div class="<b>col-half</b>"&gt;
		(another box here)
	&lt;/div&gt;
&lt;/div&gt;
</pre></div>

<hr>


<dialog id="demo" title="A demo dialog">
	<p>It's very simple to add dialogs to pages:</p>
	<p><strong>1.</strong> This code will trigger the dialog with id="demo"<br><code>&lt;a href="#demo" rel="dialog">Overlay&lt;/a></code></p>
	<p><strong>2.</strong> This code (on the same page) defines the content of the dialog:<br><code>&lt;dialog id="demo" title="A demo dialog">Dialog content here...&lt;/dialog></code></p>
</dialog>


<dialog id="demo2" title="A small dialog" class="small">
	<p>This dialog is declared with class="small", like this:<br><code>&lt;dialog id="demo2" title="A small dialog" <u>class="small"</u>>Dialog content here...&lt;/dialog></code></p>
</dialog>

<dialog id="demo3" title="No close button" class="no-close">
	<p>This dialog is declared with class="no-close", like this:<br><code>&lt;dialog id="demo3" title="No close button" <u>class="no-close"</u>>Dialog content here...&lt;/dialog></code></p>
	<p>To close the dialog manually you can optionally add an element with class ".close" to the contents. Like this: <button class="close">&lt;button class="close">&lt;/button></button></p>
</dialog>

<dialog id="demo4" title="This dialog is very long" class="small no-close">
	<p><big>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</big><br>
	<button class="close float-r">Close</button></p>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>
	<button class="close float-r">Close</button></p>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>
	<button class="close float-r">Close</button></p>
	<br class="group">
	<div style="margin-bottom:-12px;margin-top:40px" class="tc">
		<div class="dev-tip">With great power comes great responsibility</div>
		<img src="<?php echo esc_url( WPMUDEV_Dashboard::$site->plugin_url ); ?>/image/devman.svg" />
	</div>
	<hr>
	<p><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small></p>
	<div class="tc"><button class="close button button-small">Close</button></div>
	<p><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small></p>
	<div class="tc"><button class="close button button-small">Close</button></div>
	<p><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small></p>
	<div class="tc"><button class="close button button-small">Close</button></div>
</dialog>
