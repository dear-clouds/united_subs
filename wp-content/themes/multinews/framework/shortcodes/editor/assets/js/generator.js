jQuery(document).ready(function ($) {

	// Prepare data
	var $generator = $('#mom-su-generator'),
		$search = $('#mom-su-generator-search'),
		$filter = $('#mom-su-generator-filter'),
		$filters = $filter.children('a'),
		$choices = $('#mom-su-generator-choices'),
		$choice = $choices.find('span'),
		$settings = $('#mom-su-generator-settings'),
		$prefix = $('#mom-su-compatibility-mode-prefix'),
		$result = $('#mom-su-generator-result'),
		$selected = $('#mom-su-generator-selected'),
		mce_selection = '';

	// Generator button
	$('body').on('click', '.mom-su-generator-button', function (e) {
		e.preventDefault();
		// Save the target
		window.mom_su_generator_target = $(this).data('target');
		// Get open shortcode
		var shortcode = $(this).data('shortcode');
		// Open magnificPopup
		$(this).magnificPopup({
			type: 'inline',
			alignTop: true,
			callbacks: {
				open: function () {
					// Open queried shortcode
					if (shortcode) $choice.filter('[data-shortcode="' + shortcode + '"]').trigger('click');
					// Focus search field when popup is opened
					else window.setTimeout(function () {
						$search.focus();
					}, 200);
					// Change z-index
					$('body').addClass('mom-su-mfp-shown');
					// Save selection
					mce_selection = (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor != null && tinyMCE.activeEditor.hasOwnProperty('selection')) ? tinyMCE.activeEditor.selection.getContent({
						format: "text"
					}) : '';
				},
				close: function () {
					// Clear search field
					$search.val('');
					// Hide settings
					$settings.html('').hide();
					// Remove narrow class
					$generator.removeClass('mom-su-generator-narrow');
					// Show filters
					$filter.show();
					// Show choices panel
					$choices.show();
					$choice.show();
					// Clear selection
					mce_selection = '';
					// Change z-index
					$('body').removeClass('mom-su-mfp-shown');
				}
			}
		}).magnificPopup('open');
	});

	// Filters
	$filters.click(function (e) {
		// Prepare data
		var filter = $(this).data('filter');
		// If filter All, show all choices
		if (filter === 'all') $choice.css({
			opacity: 1
		}).removeClass('mom-su-generator-choice-first');
		// Else run search
		else {
			var regex = new RegExp(filter, 'gi');
			// Hide all choices
			$choice.css({
				opacity: 0.2
			});
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var group = $(this).data('group');
				// Show choice if matched
				if (group.match(regex) !== null) $(this).css({
					opacity: 1
				}).removeClass('mom-su-generator-choice-first');
			});
		}
		e.preventDefault();
	});

	// Go to home link
	$('#mom-su-generator').on('click', '.mom-su-generator-home', function (e) {
		// Clear search field
		$search.val('');
		// Hide settings
		$settings.html('').hide();
		// Remove narrow class
		$generator.removeClass('mom-su-generator-narrow');
		// Show filters
		$filter.show();
		// Show choices panel
		$choices.show();
		$choice.show();
		// Clear selection
		mce_selection = '';
		// Focus search field
		$search.focus();
		e.preventDefault();
	});

	// Generator close button
	$('#mom-su-generator').on('click', '.mom-su-generator-close', function (e) {
		// Close popup
		$.magnificPopup.close();
		// Prevent default action
		e.preventDefault();
	});

	// Search field
	$search.on({
		focus: function () {
			// Clear field
			$(this).val('');
			// Hide settings
			$settings.html('').hide();
			// Remove narrow class
			$generator.removeClass('mom-su-generator-narrow');
			// Show choices panel
			$choices.show();
			$choice.css({
				opacity: 1
			}).removeClass('mom-su-generator-choice-first');
			// Show filters
			$filter.show();
		},
		blur: function () {},
		keyup: function (e) {
			var $first = $('.mom-su-generator-choice-first:first'),
				val = $(this).val(),
				regex = new RegExp(val, 'gi');
			// Hotkey action
			if (e.keyCode === 13 && $first.length > 0) {
				e.preventDefault();
				$(this).val('').blur();
				$first.trigger('click');
			}
			// Hide all choices
			$choice.css({
				opacity: 0.2
			}).removeClass('mom-su-generator-choice-first');
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var id = $(this).data('shortcode'),
					name = $(this).data('name'),
					desc = $(this).data('desc'),
					group = $(this).data('group');
				// Show choice if matched
				if ((id + name + desc + group).match(regex) !== null) {
					$(this).css({
						opacity: 1
}).removeClass('mom-su-generator-choice-first');
					if (val === id || val === name || val === name.toLowerCase()) {
						$(this).addClass('mom-su-generator-choice-first');
					}
				}
			});
		}
	});

	// Click on shortcode choice
	$choice.on('click', function (e) {
		// Prepare data
		var shortcode = $(this).data('shortcode');
		// Load shortcode options
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'mom_su_generator_settings',
				shortcode: shortcode
			},
			beforeSend: function () {
				// Hide preview box
				$('#mom-su-generator-preview').hide();
				// Hide choices panel
				$choices.hide();
				// Show loading animation
				$settings.addClass('mom-su-generator-loading').show();
				// Add narrow class
				$generator.addClass('mom-su-generator-narrow');
				// Hide filters
				$filter.hide();
			},
			success: function (data) {

				// Hide loading animation
				$settings.removeClass('mom-su-generator-loading');
				// Insert new HTML
				$settings.html(data);
				// Apply selected text to the content field
				if (typeof mce_selection !== 'undefined' && mce_selection !== '') $('#mom-su-generator-content').val(mce_selection);
				// Init range pickers
				$('.mom-su-generator-range-picker').each(function (index) {
					var $picker = $(this),
						$val = $picker.find('input'),
						min = $val.attr('min'),
						max = $val.attr('max'),
						step = $val.attr('step');
					// Apply noUIslider
					$val.simpleSlider({
						snap: true,
						step: step,
						range: [min, max]
					});
					$val.attr('type', 'text').show();
					$val.on('keyup blur', function (e) {
						$val.simpleSlider('setValue', $val.val());
					});
				});
				// Init color pickers
				$('.mom-su-generator-select-color').each(function (index) {
					$(this).find('.mom-su-generator-select-color-wheel').filter(':first').farbtastic('.mom-su-generator-select-color-value:eq(' +
						index + ')');
					$(this).find('.mom-su-generator-select-color-value').focus(function () {
						$('.mom-su-generator-select-color-wheel:eq(' + index + ')').show();
					});
					$(this).find('.mom-su-generator-select-color-value').blur(function () {
						$('.mom-su-generator-select-color-wheel:eq(' + index + ')').hide();
					});
				});
				// Init image sourse pickers
				$('.mom-su-generator-isp').each(function () {
					var $picker = $(this),
						$sources = $picker.find('.mom-su-generator-isp-sources'),
						$source = $picker.find('.mom-su-generator-isp-source'),
						$add_media = $picker.find('.mom-su-generator-isp-add-media'),
						$images = $picker.find('.mom-su-generator-isp-images'),
						$cats = $picker.find('.mom-su-generator-isp-categories'),
						$taxes = $picker.find('.mom-su-generator-isp-taxonomies'),
						$terms = $('.mom-su-generator-isp-terms'),
						$val = $picker.find('.mom-su-generator-attr'),
						frame;
					// Update hidden value
					var update = function () {
							var val = 'none',
								ids = '',
								source = $sources.val();
							// Media library
							if (source === 'media') {
								var images = [];
								$images.find('span').each(function (i) {
									images[i] = $(this).data('id');
								});
								if (images.length > 0) ids = images.join(',');
							}
							// Category
							else if (source === 'category') {
								var categories = $cats.val() || [];
								if (categories.length > 0) ids = categories.join(',');
							}
							// Taxonomy
							else if (source === 'taxonomy') {
								var tax = $taxes.val() || '',
									terms = $terms.val() || [];
								if (tax !== '0' && terms.length > 0) val = 'taxonomy: ' + tax + '/' + terms.join(',');
							}
							// Deselect
							else if (source === '0') {
								val = 'none';
							}
							// Other options
							else {
								val = source;
							}
							if (ids !== '') val = source + ': ' + ids;
							$val.val(val).trigger('change');
						}
						// Switch source
					$sources.on('change', function (e) {
						var source = $(this).val();
						e.preventDefault();
						$source.removeClass('mom-su-generator-isp-source-open');
						if (source.indexOf(':') === -1) $picker.find('.mom-su-generator-isp-source-' + source).addClass('mom-su-generator-isp-source-open');
						update();
					});
					// Remove image
					$images.on('click', 'span i', function () {
						$(this).parent('span').css('border-color', '#f03').fadeOut(300, function () {
							$(this).remove();
							update();
						});
					});
					// Add image
					$add_media.click(function (e) {
						e.preventDefault();
						if (typeof (frame) !== 'undefined') frame.close();
						frame = wp.media.frames.mom_su_media_frame_1 = wp.media({
							title: mom_su_generator.isp_media_title,
							library: {
								type: 'image'
							},
							button: {
								text: mom_su_generator.isp_media_insert
							},
							multiple: true
						});
						frame.on('select', function () {
							var files = frame.state().get('selection').toJSON();
							$images.find('em').remove();
							$.each(files, function (i) {
								$images.append('<span data-id="' + this.id + '" title="' + this.title + '"><img src="' + this.url + '" alt="" /><i class="fa fa-times"></i></span>');
							});
							update();
						}).open();
					});
					// Sort images
					$images.sortable({
						revert: 200,
						containment: $picker,
						tolerance: 'pointer',
						stop: function () {
							update();
						}
					});
					// Select categories and terms
					$cats.on('change', update);
					$terms.on('change', update);
					// Select taxonomy
					$taxes.on('change', function () {
						var $cont = $(this).parents('.mom-su-generator-isp-source'),
							tax = $(this).val();
						// Remove terms
						$terms.hide().find('option').remove();
						update();
						// Taxonomy is not selected
						if (tax === '0') return;
						// Taxonomy selected
						else {
							var ajax_term_select = $.ajax({
								url: ajaxurl,
								type: 'post',
								dataType: 'html',
								data: {
									'action': 'mom_su_generator_get_terms',
									'tax': tax,
									'class': 'mom-su-generator-isp-terms',
									'multiple': true,
									'size': 10
								},
								beforeSend: function () {
									if (typeof ajax_term_select === 'object') ajax_term_select.abort();
									$terms.html('').attr('disabled', true).hide();
									$cont.addClass('mom-su-generator-loading');
								},
								success: function (data) {
									$terms.html(data).attr('disabled', false).show();
									$cont.removeClass('mom-su-generator-loading');
								}
							});
						}
					});
				});
				// Init media buttons
				$('.mom-su-generator-upload-button').each(function () {
					var $button = $(this),
						$val = $(this).parents('.mom-su-generator-attr-container').find('input:text'),
						file;
					$button.on('click', function (e) {
						e.preventDefault();
						e.stopPropagation();
						// If the frame already exists, reopen it
						if (typeof (file) !== 'undefined') file.close();
						// Create WP media frame.
						file = wp.media.frames.mom_su_media_frame_2 = wp.media({
							// Title of media manager frame
							title: mom_su_generator.upload_title,
							button: {
								//Button text
								text: mom_su_generator.upload_insert
							},
							// Do not allow multiple files, if you want multiple, set true
							multiple: false
						});
						//callback for selected image
						file.on('select', function () {
							var attachment = file.state().get('selection').first().toJSON();
							$val.val(attachment.url).trigger('change');
						});
						// Open modal
						file.open();
					});
				});
				// Init icon pickers
				$('.mom-su-generator-icon-picker-button').each(function () {
					var $button = $(this),
						$field = $(this).parents('.mom-su-generator-attr-container'),
						$val = $field.find('.mom-su-generator-attr'),
						$picker = $field.find('.mom-su-generator-icon-picker'),
						$filter = $picker.find('input:text');

					$button.click(function (e) {
						$picker.toggleClass('mom-su-generator-icon-picker-visible');
						$filter.val('').trigger('keyup');
						if ($picker.hasClass('mom-su-generator-icon-picker-loaded')) return;
						// Load icons
						$.ajax({
							type: 'post',
							url: ajaxurl,
							data: {
								action: 'mom_su_generator_get_icons'
							},
							dataType: 'html',
							beforeSend: function () {
								// Show loading animation
								$picker.addClass('mom-su-generator-loading');
								// Add loaded class
								$picker.addClass('mom-su-generator-icon-picker-loaded');
							},
							success: function (data) {
								$picker.append(data);
								var $icons = $picker.children('i');
								$icons.click(function (e) {
									$val.val($(this).attr('title'));
									$picker.removeClass('mom-su-generator-icon-picker-visible');
									$val.trigger('change');
									e.preventDefault();
								});
								$filter.on({
									keyup: function () {
										var val = $(this).val(),
											regex = new RegExp(val, 'gi');
										// Hide all choices
										$icons.hide();
										// Find searched choices and show
										$icons.each(function () {
											// Get shortcode name
											var name = $(this).attr('title');
											// Show choice if matched
											if (name.match(regex) !== null) $(this).show();
										});
									},
									focus: function () {
										$(this).val('');
										$icons.show();
									}
								});
								$picker.removeClass('mom-su-generator-loading');
							}
						});
						e.preventDefault();
					});
				});
				// Init switches
				$('.mom-su-generator-switch').click(function (e) {
					// Prepare data
					var $switch = $(this),
						$value = $switch.parent().children('input'),
						is_on = $value.val() === 'yes';
					// Disable
					if (is_on) {
						// Change value
						$value.val('no').trigger('change');
					}
					// Enable
					else {
						// Change value
						$value.val('yes').trigger('change');
					}
					e.preventDefault();
				});
				$('.mom-su-generator-switch-value').on('change', function () {
					// Prepare data
					var $value = $(this),
						$switch = $value.parent().children('.mom-su-generator-switch'),
						value = $value.val();
					// Disable
					if (value === 'yes') $switch.removeClass('mom-su-generator-switch-no').addClass('mom-su-generator-switch-yes');
					// Enable
					else if (value === 'no') $switch.removeClass('mom-su-generator-switch-yes').addClass('mom-su-generator-switch-no');
				});
				// Init tax_term selects
				$('select#mom-su-generator-attr-taxonomy').on('change', function () {
					var $taxonomy = $(this),
						tax = $taxonomy.val(),
						$terms = $('select#mom-su-generator-attr-tax_term');
					// Load new options
					window.mom_su_generator_get_terms = $.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'mom_su_generator_get_terms',
							tax: tax,
							noselect: true
						},
						dataType: 'html',
						beforeSend: function () {
							// Check previous requests
							if (typeof window.mom_su_generator_get_terms === 'object') window.mom_su_generator_get_terms.abort();
							// Show loading animation
							$terms.parent().addClass('mom-su-generator-loading');
						},
						success: function (data) {
							// Remove previous options
							$terms.find('option').remove();
							// Append new options
							$terms.append(data);
							// Hide loading animation
							$terms.parent().removeClass('mom-su-generator-loading');
						}
					});
				});
				// Init shadow pickers
				$('.mom-su-generator-shadow-picker').each(function (index) {
					var $picker = $(this),
						$fields = $picker.find('.mom-su-generator-shadow-picker-field input'),
						$hoff = $picker.find('.mom-su-generator-sp-hoff'),
						$voff = $picker.find('.mom-su-generator-sp-voff'),
						$blur = $picker.find('.mom-su-generator-sp-blur'),
						$color = {
							cnt: $picker.find('.mom-su-generator-shadow-picker-color'),
							value: $picker.find('.mom-su-generator-shadow-picker-color-value'),
							wheel: $picker.find('.mom-su-generator-shadow-picker-color-wheel')
						},
						$val = $picker.find('.mom-su-generator-attr');
					// Init color picker
					$color.wheel.farbtastic($color.value);
					$color.value.focus(function () {
						$color.wheel.show();
					});
					$color.value.blur(function () {
						$color.wheel.hide();
					});
					// Handle text fields
					$fields.on('change blur keyup', function () {
						$val.val($hoff.val() + 'px ' + $voff.val() + 'px ' + $blur.val() + 'px ' + $color.value.val()).trigger('change');
					});
					$val.on('keyup', function () {
						var value = $(this).val().split(' ');
						// Value is correct
						if (value.length === 4) {
							$hoff.val(value[0].replace('px', ''));
							$voff.val(value[1].replace('px', ''));
							$blur.val(value[2].replace('px', ''));
							$color.value.val(value[3]);
							$fields.trigger('keyup');
						}
					});
				});
				// Init border pickers
				$('.mom-su-generator-border-picker').each(function (index) {
					var $picker = $(this),
						$fields = $picker.find('.mom-su-generator-border-picker-field input, .mom-su-generator-border-picker-field select'),
						$width = $picker.find('.mom-su-generator-bp-width'),
						$style = $picker.find('.mom-su-generator-bp-style'),
						$color = {
							cnt: $picker.find('.mom-su-generator-border-picker-color'),
							value: $picker.find('.mom-su-generator-border-picker-color-value'),
							wheel: $picker.find('.mom-su-generator-border-picker-color-wheel')
						},
						$val = $picker.find('.mom-su-generator-attr');
					// Init color picker
					$color.wheel.farbtastic($color.value);
					$color.value.focus(function () {
						$color.wheel.show();
					});
					$color.value.blur(function () {
						$color.wheel.hide();
					});
					// Handle text fields
					$fields.on('change blur keyup', function () {
						$val.val($width.val() + 'px ' + $style.val() + ' ' + $color.value.val()).trigger('change');
					});
					$val.on('keyup', function () {
						var value = $(this).val().split(' ');
						// Value is correct
						if (value.length === 3) {
							$width.val(value[0].replace('px', ''));
							$style.val(value[1]);
							$color.value.val(value[2]);
							$fields.trigger('keyup');
						}
					});
				});
				// required 
				$('.mom-su-generator-attr-container').each(function() {
					var t = $(this);
					var req = t.attr('data-required');
					var val = t.attr('data-value');
					var op = t.attr('data-operator');
					var el = t.parent('#mom-su-generator-settings').find('#mom-su-generator-attr-'+req);
					//el.css('background', 'red');
					if (typeof t.data('required') !== 'undefined') {
						t.hide();
						if (op === '!=') {
						if (el.val() !== val) {
							t.show();
						}
						el.on('change',function() {
							if ($(this).val() !== val) {
								t.show();
							} else {
								t.hide();
							}

						});
					} else {
						if (el.val() === val) {
							t.show();
						}
						el.on('change',function() {
							if ($(this).val() === val) {
								t.show();
							} else {
								t.hide();
							}

						});
					}

					}
				});
				// required
				// Remove skip class when setting is changed
				$settings.find('.mom-su-generator-attr').on('change keyup blur', function () {
					var $cnt = $(this).parents('.mom-su-generator-attr-container'),
						_default = $cnt.data('default'),
						val = $(this).val();
					// Value is changed
					if (val != _default) $cnt.removeClass('mom-su-generator-skip');
					else $cnt.addClass('mom-su-generator-skip');
				});
				// Init value setters
				$('.mom-su-generator-set-value').click(function (e) {
					$(this).parents('.mom-su-generator-attr-container').find('input').val($(this).text()).trigger('change');
				});
				// Save selected value
				$selected.val(shortcode);
				// Load last used preset
				$.ajax({
					type: 'GET',
					url: ajaxurl,
					data: {
						action: 'mom_su_generator_get_preset',
						id: 'last_used',
						shortcode: shortcode
					},
					beforeSend: function () {
						// Show loading animation
						// $settings.addClass('mom-su-generator-loading');
					},
					success: function (data) {
						// Remove loading animation
						// $settings.removeClass('mom-su-generator-loading');
						// Set new settings
						set(data);
						// Apply selected text to the content field
						if (typeof mce_selection !== 'undefined' && mce_selection !== '') $('#mom-su-generator-content').val(mce_selection);
					},
					dataType: 'json'
				});
			},
			dataType: 'html'
		});
	});

	// Insert shortcode
	$('#mom-su-generator').on('click', '.mom-su-generator-insert', function (e) {
		// Prepare data
		var shortcode = parse();
		// Save current settings to presets
			//add_preset('last_used', mom_su_generator.last_used);
		// Close popup
		$.magnificPopup.close();
		// Save shortcode to div
		$result.text(shortcode);
		// Prevent default action
		e.preventDefault();
		// Save original activeeditor
		window.mom_su_wpActiveEditor = window.wpActiveEditor;
		// Set new active editor
		window.wpActiveEditor = window.mom_su_generator_target;
		// Insert shortcode
		window.wp.media.editor.insert(shortcode);
		// Restore previous editor
		window.wpActiveEditor = window.mom_su_wpActiveEditor;
		// Check for target content editor
		// if (typeof window.mom_su_generator_target === 'undefined') return;
		// Insert into default content editor
		// else if (window.mom_su_generator_target === 'content') window.wp.media.editor.insert(shortcode);
		// Insert into ET page builder (text box)
		// else if (window.mom_su_generator_target === 'et_pb_content_new') window.wp.media.editor.insert(shortcode);
		// Insert into textarea
		// else {
		// var $target = $('textarea#' + window.mom_su_generator_target);
		// if ($target.length > 0) $target.val($target.val() + shortcode);
		// }
	});

	// Preview shortcode
	$('#mom-su-generator').on('click', '.mom-su-generator-toggle-preview', function (e) {
		// Prepare data
		var $preview = $('#mom-su-generator-preview'),
			$button = $(this);
		// Hide button
		$button.hide();
		// Show preview box
		$preview.addClass('mom-su-generator-loading').show();
		// Bind updating on settings changes
		$settings.find('input, textarea, select').on('change keyup blur', function () {
			update_preview();
		});
		// Update preview box
		update_preview(true);
		// Prevent default action
		e.preventDefault();
	});

	var gp_hover_timer;

	// Presets manager - mouseenter
	$('#mom-su-generator').on('mouseenter click', '.mom-su-generator-presets', function () {
		clearTimeout(gp_hover_timer);
		$('.mom-su-gp-popup').show();
	});
	// Presets manager - mouseleave
	$('#mom-su-generator').on('mouseleave', '.mom-su-generator-presets', function () {
		gp_hover_timer = window.setTimeout(function () {
			$('.mom-su-gp-popup').fadeOut(200);
		}, 600);
	});
	// Presets manager - add new preset
	$('#mom-su-generator').on('click', '.mom-su-gp-new', function (e) {
		// Prepare data
		var $container = $(this).parents('.mom-su-generator-presets'),
			$list = $('.mom-su-gp-list'),
			id = new Date().getTime();
		// Ask for preset name
		var name = prompt(mom_su_generator.presets_prompt_msg, mom_su_generator.presets_prompt_value);
		// Name is entered
		if (name !== '' && name !== null) {
			// Hide default text
			$list.find('b').hide();
			// Add new option
			$list.append('<span data-id="' + id + '"><em>' + name + '</em><i class="fa fa-times"></i></span>');
			// Perform AJAX request
			add_preset(id, name);
		}
	});
	// Presets manager - load preset
	$('#mom-su-generator').on('click', '.mom-su-gp-list span', function (e) {
		// Prepare data
		var shortcode = $('.mom-su-generator-presets').data('shortcode'),
			id = $(this).data('id'),
			$insert = $('.mom-su-generator-insert');
		// Hide popup
		$('.mom-su-gp-popup').hide();
		// Disable hover timer
		clearTimeout(gp_hover_timer);
		// Get the preset
		$.ajax({
			type: 'GET',
			url: ajaxurl,
			data: {
				action: 'mom_su_generator_get_preset',
				id: id,
				shortcode: shortcode
			},
			beforeSend: function () {
				// Disable insert button
				$insert.addClass('button-primary-disabled').attr('disabled', true);
			},
			success: function (data) {
				// Enable insert button
				$insert.removeClass('button-primary-disabled').attr('disabled', false);
				// Set new settings
				set(data);
			},
			dataType: 'json'
		});
		// Prevent default action
		e.preventDefault();
		e.stopPropagation();
	});
	// Presets manager - remove preset
	$('#mom-su-generator').on('click', '.mom-su-gp-list i', function (e) {
		// Prepare data
		var $list = $(this).parents('.mom-su-gp-list'),
			$preset = $(this).parent('span'),
			id = $preset.data('id');
		// Remove DOM element
		$preset.remove();
		// Show default text if last preset was removed
		if ($list.find('span').length < 1) $list.find('b').show();
		// Perform ajax request
		remove_preset(id);
		// Prevent <span> action
		e.stopPropagation();
		// Prevent default action
		e.preventDefault();
	});

	/**
	 * Create new preset with specified name from current settings
	 */
	function add_preset(id, name) {
		// Prepare shortcode name and current settings
		var shortcode = $('.mom-su-generator-presets').data('shortcode'),
			settings = get();
		// Perform AJAX request
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'mom_su_generator_add_preset',
				id: id,
				name: name,
				shortcode: shortcode,
				settings: settings
			}
		});
	}

	/**
	 * Remove preset by ID
	 */
	function remove_preset(id) {
		// Get current shortcode name
		var shortcode = $('.mom-su-generator-presets').data('shortcode');
		// Perform AJAX request
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'mom_su_generator_remove_preset',
				id: id,
				shortcode: shortcode
			}
		});
	}

	function parse() {
		// Prepare data
		var query = $selected.val(),
			prefix = $prefix.val(),
			$settings = $('#mom-su-generator-settings .mom-su-generator-attr-container:not(.mom-su-generator-skip) .mom-su-generator-attr'),
			content = $('#mom-su-generator-content').val(),
			result = new String('');
		// Open shortcode
		result += '[' + prefix + query;
		// Add shortcode attributes
		$settings.each(function () {
			// Prepare field and value
			var $this = $(this),
				value = '';
			// Selects
			if ($this.is('select')) value = $this.find('option:selected').val();
			if ($this.is('input[type="radio"]')) value = $this.parent().find(':checked').val();
			// Other fields
			else value = $this.val();
			// Check that value is not empty
			if (value == null) value = '';
			else if (typeof value === 'array') value = value.join(',');
			// Add attribute
			if (value !== '') result += ' ' + $(this).attr('name') + '="' + $(this).val().toString().replace(/"/gi, "'") + '"';
		});
		// End of opening tag
		result += ']';
		// Wrap shortcode if content presented
		if (content != 'false') result += content + '[/' + prefix + query + ']';
		// Return result
		return result;
	}

	function get() {
		// Prepare data
		var query = $selected.val(),
			$settings = $('#mom-su-generator-settings .mom-su-generator-attr'),
			content = $('#mom-su-generator-content').val(),
			data = {};
		// Add shortcode attributes
		$settings.each(function (i) {
			// Prepare field and value
			var $this = $(this),
				value = '',
				name = $this.attr('name');
			// Selects
			if ($this.is('select')) value = $this.find('option:selected').val();
			// Other fields
			else value = $this.val();
			// Check that value is not empty
			if (value == null) value = '';
			// Save value
			data[name] = value;
		});
		// Add content
		data['content'] = content.toString();
		// Return data
		return data;
	}

	function set(data) {
		// Prepare data
		var $settings = $('#mom-su-generator-settings .mom-su-generator-attr'),
			$content = $('#mom-su-generator-content');
		// Loop through settings
		$settings.each(function () {
			var $this = $(this),
				name = $this.attr('name');
			// Data contains value for this field
			if (data.hasOwnProperty(name)) {
				// Set new value
				$this.val(data[name]);
				$this.trigger('keyup').trigger('change').trigger('blur');
			}
		});
		// Set content
		if (data.hasOwnProperty('content')) $content.val(data['content']).trigger('keyup').trigger('change').trigger('blur');
		// Update preview
		update_preview();
	}

	var update_preview_timer,
		update_preview_request;

	function update_preview(forced) {
		// Prepare data
		var $preview = $('#mom-su-generator-preview'),
			shortcode = parse(),
			previous = $result.text();
		// Check forced mode
		forced = forced || false;
		// Break if preview box is hidden (preview isn't enabled)
		if (!$preview.is(':visible')) return;
		// Check shortcode is changed is this is not a forced mode
		if (shortcode === previous && !forced) return;
		// Run timer to filter often calls
		window.clearTimeout(update_preview_timer);
		update_preview_timer = window.setTimeout(function () {
			update_preview_request = $.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data: {
					action: 'mom_su_generator_preview',
					shortcode: shortcode
				},
				beforeSend: function () {
					// Abort previous requests
					if (typeof update_preview_request === 'object') update_preview_request.abort();
					// Show loading animation
					$preview.addClass('mom-su-generator-loading').html('');
				},
				success: function (data) {
					// Hide loading animation and set new HTML
					$preview.html(data).removeClass('mom-su-generator-loading');
				},
				dataType: 'html'
			});
		}, 300);
		// Save shortcode to div
		$result.text(shortcode);
	}

});