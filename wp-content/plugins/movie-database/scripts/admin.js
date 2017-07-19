jQuery(document).ready(function()
{
	jQuery('.movdb-form input#movie').suggest();
	jQuery('#movie-edit #title').movieInfo();
	jQuery('.type-filename').copyTitleToClipboard();
});

jQuery.fn.suggest = function ()
{
	var fieldId;
	var fieldTitle;
	var dropdown;
	var searchQuery;
	var keyUpTimeout;
	var lastKeyUpTime;
	
	var initialize = function ()
	{
		fieldId = jQuery(this);
		fieldTitle = createTitleField();
		dropdown = createDropdownMenu();
		
		fieldId.attr('type', 'hidden');
		fieldId.after(fieldTitle);
		fieldId.after(dropdown);
		
		dropdown.adjustDimensions(
			fieldTitle.position().left,
			fieldTitle.position().top + fieldTitle.height() + 10,
			fieldTitle.width()
		);
		
		jQuery(window).keydown(function (event) {
			if (event.keyCode == 13 && !dropdown.isHidden) {
				event.preventDefault();
				return false;
			}
		});
	};
	
	var createTitleField = function ()
	{
		var f = jQuery('<input type="text" id="movie_title" name="movie_title" autocomplete="off" />');
		
		if (fieldId.attr('data-title')) {
			f.val(fieldId.attr('data-title'));
			f.attr('disabled', 'disabled');
		}
		else {
			f.keydown(onKeyDown);
			f.keyup(onKeyUp);
			f.on('input', onInput);
		}
		
		return f;
	};
	
	var createDropdownMenu = function ()
	{
		var d = jQuery('<div class="movdb-title-dropdown"></div>');
		
		d.open = function ()
		{
			this.show();
			this.isHidden = false;
		};
		
		d.close = function ()
		{
			this.hide();
			this.isHidden = true;
		};
		
		d.adjustDimensions = function (leftPosition, topPosition, minWidth)
		{
			this.css('left', leftPosition + 'px');
			this.css('top', topPosition + 'px');
			this.css('min-width', minWidth + 'px');
		};
		
		d.list = jQuery('<ul></ul>');
		
		d.list.selectedIndex = -1;
		
		d.list.selectNextItem = function ()
		{
			var itemCount = this.children().length;
			
			if (itemCount == 0) {
				this.selectedIndex = -1;
				return;
			}
			
			this.selectedIndex++;
			
			if (this.selectedIndex >= itemCount) {
				this.selectedIndex = 0;
			}
			
			this.selectItem(this.selectedIndex);
		};
		
		d.list.selectPreviousItem = function ()
		{
			var itemCount = this.children().length;
			
			if (itemCount == 0) {
				this.selectedIndex = -1;
				return;
			}
			
			this.selectedIndex--;
			
			if (this.selectedIndex < 0) {
				this.selectedIndex = itemCount - 1;
			}
			
			this.selectItem(this.selectedIndex);
		};
		
		d.list.selectItem = function (index)
		{
			var items = this.children();
			var itemCount = items.length;
			
			if (index < -1 || index >= itemCount) {
				return;
			}
			
			items.removeClass('selected');
			
			if (index == -1) {
				return;
			}
			
			jQuery(items.get(index)).addClass('selected');
		};
		
		d.list.selectedItem = function ()
		{
			if (this.selectedIndex < 0) {
				return null;
			}
			
			var items = this.children();
			
			if (this.selectedIndex >= items.length) {
				return null;
			}
			
			return jQuery(this.children().get(this.selectedIndex));
		};
		
		d.list.getSelectedItemData = function ()
		{
			var item = this.selectedItem();
			
			if (item == null) {
				return null;
			}
			
			var data = {
				id: item.attr('data-movie-id'),
				title: item.attr('data-movie-title')
			};
			
			return data;
		};
		
		d.list.scrollToSelectedItem = function ()
		{
			var item = this.selectedItem();
			
			if (item == null) {
				return null;
			}
			
			this.parent().scrollTop(0);
			var top = item.position().top;
			this.parent().scrollTop(top);
		};
		
		d.list.clear = function ()
		{
			this.empty();
			this.selectedIndex = -1;
		};
		
		d.append(d.list);
		
		d.close();
		
		return d;
	};
	
	var onKeyDown = function (event)
	{
		switch (event.keyCode)
		{
			case 13: // enter
				if (!dropdown.isHidden) {
					event.preventDefault();
					var selectedItemData = dropdown.list.getSelectedItemData();
					fieldId.val(selectedItemData.id);
					fieldTitle.val(selectedItemData.title);
					dropdown.close();
				}
				return;
				
			case 38: // up
				event.preventDefault();
				dropdown.list.selectPreviousItem();
				dropdown.list.scrollToSelectedItem();
				return;
				
			case 40: // down
				event.preventDefault();
				dropdown.list.selectNextItem();
				dropdown.list.scrollToSelectedItem();
				return;
		}
	};
	
	var onKeyUp = function (event)
	{
		if (event.keyCode == 13 || event.keyCode == 38 || event.keyCode == 40) {
			return;
		}
		
		searchQuery = jQuery(this).val();
		
		if (searchQuery.length < 2) {
			dropdown.close();
			return;
		}
		
		var currentTime = new Date().getTime();
		
		if (currentTime - lastKeyUpTime < 1000) {
			window.clearTimeout(keyUpTimeout);
		}
		
		keyUpTimeout = window.setTimeout(loadSuggestions, 1000);
		
		lastKeyUpTime = currentTime;
	};
	
	var onInput = function (event)
	{
		// when changing the title again, clear previously selected id
		fieldId.val('');
	};
	
	var loadSuggestions = function ()
	{
		var data = {
			action: 'movdb_movie_search',
			query: searchQuery
		};
		
		jQuery.post(ajaxurl, data, handleResponse, 'json');
	};
	
	var handleResponse = function (response)
	{
		//alert(response);
		dropdown.list.clear();
		
		if (response.length == 0) {
			dropdown.close();
			return;
		}
		
		for (var i = 0; i < response.length; i++)
		{
			var item = createDropdownListItem(response[i]);
			
			item.click(function ()
			{
				fieldId.val(jQuery(this).attr('data-movie-id'));
				fieldTitle.val(jQuery(this).attr('data-movie-title'));
				dropdown.close();
			});
			
			dropdown.list.append(item);
		}
		
		dropdown.open();
	};
	
	var createDropdownListItem = function (resultItem)
	{
		var item = jQuery('<li data-movie-id="' + resultItem.id + '" data-movie-title="' + resultItem.title + '"></li>');
		
		if (resultItem.year) {
			item.append('<p class="year">' + resultItem.year + '</p>');
		}
		
		var title = resultItem.title;
		
		if (resultItem.version) {
			title += ' <span class="version">(' + resultItem.version + ')</span>';
		}
		
		item.append('<p class="title">' + title + '</p>');
		
		if (resultItem.org_title) {
			item.append('<p class="org-title">' + resultItem.org_title + '</p>');
		}
		
		return item;
	};
	
	return this.each(initialize);
};

jQuery.fn.movieInfo = function ()
{
	return this.each(function ()
	{
		var textfield = jQuery(this);
		
		var initialize = function ()
		{
			textfield.ready(showInfoFrame);
			textfield.focusout(showInfoFrame);
		};
		
		var showInfoFrame = function ()
		{
			var movieTitle = textfield.val();
			
			if (movieTitle.length < 3) {
				return;
			}
			
			var iframe = jQuery('#movdb_movie_info');
			
			if (iframe.length == 0) {
				iframe = jQuery('<iframe id="movdb_movie_info" src="#" width="100%" height="600"></iframe>');
				textfield.parents('form').after(iframe);
			}
			
			iframe.attr('src', movdb_l10n.wikiUrl + movieTitle.replace(' ', '_'));
		};
		
		initialize();
	});
};

jQuery.fn.copyTitleToClipboard = function ()
{
	return this.each(function () {
		jQuery(this).click(function ()
		{
			prompt(movdb_l10n.copyFilename, jQuery(this).attr('title').replace('.*', ''));
		});
	});
};
