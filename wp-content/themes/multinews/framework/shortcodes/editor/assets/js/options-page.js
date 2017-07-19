// Wait DOM
jQuery(document).ready(function ($) {

	// ########## About screen ##########

	$('.mom-su-demo-video').magnificPopup({
		type: 'iframe',
		callbacks: {
			open: function () {
				// Change z-index
				$('body').addClass('mom-su-mfp-shown');
			},
			close: function () {
				// Change z-index
				$('body').removeClass('mom-su-mfp-shown');
			}
		}
	});

	// ########## Custom CSS screen ##########

	$('.mom-su-custom-css-originals a').magnificPopup({
		type: 'iframe',
		callbacks: {
			open: function () {
				// Change z-index
				$('body').addClass('mom-su-mfp-shown');
			},
			close: function () {
				// Change z-index
				$('body').removeClass('mom-su-mfp-shown');
			}
		}
	});

	// Enable ACE editor
	if ($('#sunrise-field-custom-css-editor').length > 0) {
		var editor = ace.edit('sunrise-field-custom-css-editor'),
			$textarea = $('#sunrise-field-custom-css').hide();
		editor.getSession().setValue($textarea.val());
		editor.getSession().on('change', function () {
			$textarea.val(editor.getSession().getValue());
		});
		editor.getSession().setMode('ace/mode/css');
		editor.setTheme('ace/theme/monokai');
		editor.getSession().setUseWrapMode(true);
		editor.getSession().setWrapLimitRange(null, null);
		editor.renderer.setShowPrintMargin(null);
		editor.session.setUseSoftTabs(null);
	}

	// ########## Add-ons screen ##########

	var addons_timer = 0;
	$('.mom-su-addons-item').each(function () {
		var $item = $(this),
			delay = 300;
		$item.click(function (e) {
			window.open($(this).data('url'));
			e.preventDefault();
		});
		addons_timer = addons_timer + delay;
		window.setTimeout(function () {
			$item.addClass('animated bounceIn').css('visibility', 'visible');
		}, addons_timer);
	});

	// ########## Examples screen ##########

	// Disable all buttons
	$('#mom-su-examples-preview').on('click', '.mom-su-button', function (e) {
		if ($(this).hasClass('mom-su-example-button-clicked')) alert(mom_su_options_page.not_clickable);
		else $(this).addClass('mom-su-example-button-clicked');
		e.preventDefault();
	});

	var open = $('#mom_su_open_example').val(),
		$example_window = $('#mom-su-examples-window'),
		$example_preview = $('#mom-su-examples-preview');
	$('.mom-su-examples-group-title, .mom-su-examples-item').each(function () {
		var $item = $(this),
			delay = 200;
		if ($item.hasClass('mom-su-examples-item')) {
			$item.on('click', function (e) {
				var code = $(this).data('code'),
					id = $(this).data('id');
				$item.magnificPopup({
					type: 'inline',
					alignTop: true,
					callbacks: {
						open: function () {
							// Change z-index
							$('body').addClass('mom-su-mfp-shown');
						},
						close: function () {
							// Change z-index
							$('body').removeClass('mom-su-mfp-shown');
							$example_preview.html('');
						}
					}
				});
				var mom_su_example_preview = $.ajax({
					url: ajaxurl,
					type: 'get',
					dataType: 'html',
					data: {
						action: 'mom_su_example_preview',
						code: code,
						id: id
					},
					beforeSend: function () {
						if (typeof mom_su_example_preview === 'object') mom_su_example_preview.abort();
						$example_window.addClass('mom-su-ajax');
						$item.magnificPopup('open');
					},
					success: function (data) {
						$example_preview.html(data);
						$example_window.removeClass('mom-su-ajax');
					}
				});
				e.preventDefault();
			});
			// Open preselected example
			if ($item.data('id') === open) $item.trigger('click');
		}
	});
	$('#mom-su-examples-window').on('click', '.mom-su-examples-get-code', function (e) {
		$(this).hide();
		$(this).parent('.mom-su-examples-code').children('textarea').slideDown(300);
		e.preventDefault();
	});

	// ########## Cheatsheet screen ##########
	$('.mom-su-cheatsheet-switch').on('click', function (e) {
		$('body').toggleClass('mom-su-print-cheatsheet');
		e.preventDefault();
	});
});