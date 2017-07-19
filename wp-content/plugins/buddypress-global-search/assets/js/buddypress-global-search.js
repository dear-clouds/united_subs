jQuery(document).ready(function($) {
	BBOSS_GLOBAL_SEARCH.cache = [];

	if (BBOSS_GLOBAL_SEARCH.enable_ajax_search == 'yes') {
        var document_height = $(document).height();
		$("form[role='search'], form.search-form, form.searchform, form#adminbarsearch").each(function() {
			var $form = $(this);
			$search_field = $form.find("input[name='s']");
			if ($search_field.length > 0) {
				currentType = '';
                
                /**
                 * If the search input is positioned towards bottom of html document,
                 * autocomplete appearing vertically below the input isn't very effective.
                 * Lets flip it in that case.
                 */
                var ac_position_prop = {},
                    input_offset = $search_field.offset(),
                    input_offset_plus = input_offset.top + $search_field.outerHeight(),
                    distance_from_bottom = document_height - input_offset_plus;
                
                //assuming 400px is good enough to display autocomplete ui
                if( distance_from_bottom < 400 ){
                    //but if space available on top is even less!
                    if( input_offset.top > distance_from_bottom ){
                        ac_position_prop = { collision: 'flip flip' };
                    }
                }
                
				$($search_field).autocomplete({
					source: function(request, response) {

						var term = request.term;
						if (term in BBOSS_GLOBAL_SEARCH.cache) {
							response(BBOSS_GLOBAL_SEARCH.cache[ term ]);
							return;
						}

						var data = {
							'action': BBOSS_GLOBAL_SEARCH.action,
							'nonce': BBOSS_GLOBAL_SEARCH.nonce,
							'search_term': request.term,
                            'per_page': BBOSS_GLOBAL_SEARCH.per_page
						};

						response({value: '<div class="loading-msg"><span class="bb_global_search_spinner"></span>' + BBOSS_GLOBAL_SEARCH.loading_msg + '</div>'});

						$.ajax({
							url:BBOSS_GLOBAL_SEARCH.ajaxurl,
							dataType: "json",
							data: data,
							success: function(data) {
								BBOSS_GLOBAL_SEARCH.cache[ term ] = data;
								response(data);
							}
						});
					},
					minLength: 2,
					select: function(event, ui) {
						window.location = $(ui.item.value).find("a").attr("href");
						return false;
					},
					focus: function(event, ui) {
						$(".ui-autocomplete li").removeClass("ui-state-hover");
						$(".ui-autocomplete").find("li:has(a.ui-state-focus)").addClass("ui-state-hover");
						return false;
					},
					open: function() {
						$(".bb-global-search-ac").outerWidth($(this).outerWidth());
					},
                    position: ac_position_prop
				})
				.data("ui-autocomplete")._renderItem = function(ul, item) {
					ul.addClass("bb-global-search-ac");

					if (item.type_label != "") {
						$(ul).data("current_cat", item.type)
						return $("<li>").attr("class", 'bbls-' + item.type + "-type bbls-category").append("<span>" + item.value + "</span>").appendTo(ul);
					} else {
						return $("<li>").attr("class", 'bbls-' + item.type + "-type bbls-sub-item").append("<a class='x'>" + item.value + "</a>").appendTo(ul);
					}


					/*
					 currentCategory = "";
					 var li;
					 if ( item.type != currentType ) {
					 ul.append( "<li class='ui-autocomplete-category'>" + item.type + "</li>" );
					 currentType = item.type;
					 }
					 //li = this._renderItemData( ul, item );
					 if ( item.type ) {
					 li.attr( "aria-label", item.type + " : " + item.label );
					 }
					 */

				};

			}
		});

        $("#bbp-search-form, #bbp-search-index-form").each(function() {
            var $form = $(this);
            $search_field = $form.find("#bbp_search");
            if ($search_field.length > 0) {
                currentType = '';

                /**
                 * If the search input is positioned towards bottom of html document,
                 * autocomplete appearing vertically below the input isn't very effective.
                 * Lets flip it in that case.
                 */
                var ac_position_prop = {},
                    input_offset = $search_field.offset(),
                    input_offset_plus = input_offset.top + $search_field.outerHeight(),
                    distance_from_bottom = document_height - input_offset_plus;

                //assuming 400px is good enough to display autocomplete ui
                if( distance_from_bottom < 400 ){
                    //but if space available on top is even less!
                    if( input_offset.top > distance_from_bottom ){
                        ac_position_prop = { collision: 'flip flip' };
                    }
                }

                $($search_field).autocomplete({
                    source: function(request, response) {

                        var term = request.term;
                        if (term in BBOSS_GLOBAL_SEARCH.cache) {
                            response(BBOSS_GLOBAL_SEARCH.cache[ term ]);
                            return;
                        }

                        var data = {
                            'action': BBOSS_GLOBAL_SEARCH.action,
                            'nonce': BBOSS_GLOBAL_SEARCH.nonce,
                            'search_term': request.term,
                            'forum_search_term': true,
                            'per_page': 15
                        };

                        response({value: '<div class="loading-msg"><span class="bb_global_search_spinner"></span>' + BBOSS_GLOBAL_SEARCH.loading_msg + '</div>'});

                        $.ajax({
                            url:BBOSS_GLOBAL_SEARCH.ajaxurl,
                            dataType: "json",
                            data: data,
                            success: function(data) {
                                BBOSS_GLOBAL_SEARCH.cache[ term ] = data;
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location = $(ui.item.value).find("a").attr("href");
                        return false;
                    },
                    focus: function(event, ui) {
                        $(".ui-autocomplete li").removeClass("ui-state-hover");
                        $(".ui-autocomplete").find("li:has(a.ui-state-focus)").addClass("ui-state-hover");
                        return false;
                    },
                    open: function() {
                        $(".bb-global-search-ac").outerWidth($(this).outerWidth());
                    },
                    position: ac_position_prop
                })
                    .data("ui-autocomplete")._renderItem = function(ul, item) {
                    ul.addClass("bb-global-search-ac");

                    if (item.type_label != "") {
                        $(ul).data("current_cat", item.type)
                        return $("<li>").attr("class", 'bbls-' + item.type + "-type bbls-category").append("<span>" + item.value + "</span>").appendTo(ul);
                    } else {
                        return $("<li>").attr("class", 'bbls-' + item.type + "-type bbls-sub-item").append("<a class='x'>" + item.value + "</a>").appendTo(ul);
                    }
                };

            }
        });

    }

	/* ajax load */

	$(document).on("click", ".bboss_search_results_wrapper .item-list-tabs li a", function(e) {
		e.preventDefault();

		_this = this;

		$(this).addClass("loading");

		get_page = $.post(BBOSS_GLOBAL_SEARCH.ajaxurl, {
			'action': BBOSS_GLOBAL_SEARCH.action,
			'nonce': BBOSS_GLOBAL_SEARCH.nonce,
			'subset': $(this).parent().data("item"),
			's': BBOSS_GLOBAL_SEARCH.search_term,
			'view': 'content'
		});
		get_page.done(function(d) {
			$(_this).removeClass("loading");
			if (d != '') {
				present = $(".bboss_search_page");
				present.after(d);
				present.remove();
			}
		});

		get_page.fail(function() {
			$(_this).removeClass("loading");
		});

		return false;

	});

	$(document).on("click", ".bboss_search_results_wrapper .pagination-links a", function(e) {
		e.preventDefault();

		_this = this;

		$(this).addClass("loading");
		var qdata = {
			'action': BBOSS_GLOBAL_SEARCH.action,
			'nonce': BBOSS_GLOBAL_SEARCH.nonce,
			'subset': $(this).parent().data("item"),
			's': BBOSS_GLOBAL_SEARCH.search_term,
			'view': 'content',
			'list': $(this).data('pagenumber')
		};

		var current_subset = $(".bboss_search_results_wrapper .item-list-tabs li.active").data('item');
		qdata.subset = current_subset;

		get_page = $.post(BBOSS_GLOBAL_SEARCH.ajaxurl, qdata);
		get_page.done(function(d) {
			$(_this).removeClass("loading");
			if (d != '') {
				present = $(".bboss_search_page");
				present.after(d);
				present.remove();
			}
		});

		get_page.fail(function() {
			$(_this).removeClass("loading");
		});

		return false;

	});

	/* end ajax load */

});