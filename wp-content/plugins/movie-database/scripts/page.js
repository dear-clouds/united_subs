jQuery(document).ready(function()
{
	jQuery('var.movdb-rating').rating(false);
	jQuery('input.movdb-rating').rating(true);
});

jQuery.fn.rating = function (editable)
{
	return this.each(function ()
	{
		var org = jQuery(this);
		var container;
		
		var initialValue; // bleibt immer der Initialwert
		var savedValue;   // ändert sich nur bei Click
		var changedValue; // ändert sich bei MouseMove
		
		initialValue = org.attr('data-value') || org.val();
		savedValue = changedValue = initialValue;
		
		var initialize = function ()
		{
			createStars();
			
			if (editable) {
				replaceEditable();
				makeEditable();
			} else {
				replaceViewable();
			}
		};
		
		var createStars = function ()
		{
			container = jQuery('<span class="movdb-rating-object"></span>');
			redrawStars(initialValue);
		};
		
		var redrawStars = function (value)
		{
			container.empty();
			
			var halfValue = value / 2;
			
			var fullStars = Math.floor(halfValue);
			var halfStars = Math.ceil(halfValue - Math.floor(halfValue));
			var emptyStars = 5 - Math.ceil(halfValue);
			
			for (var i = 0; i < fullStars; i++) container.append('<span class="dashicons-before dashicons-star-filled"></span>');
			for (var i = 0; i < halfStars; i++) container.append('<span class="dashicons-before dashicons-star-half"></span>');
			for (var i = 0; i < emptyStars; i++) container.append('<span class="dashicons-before dashicons-star-empty"></span>');
		};
		
		var makeEditable = function ()
		{
			container.addClass('movdb-rating-edit');
			
			container.mousemove(function (event)
			{
				var pos = event.pageX - container.offset().left;
				var percent = 100 / container.width() * pos;
				var rating = Math.ceil(percent / 10);
				
				if (rating != changedValue) {
					changedValue = rating;
					redrawStars(rating);
				}
				
				//jQuery('#title').val(rating);
			});
			
			container.click(function (event)
			{
				setValue(changedValue);
			});
			
			container.mouseleave(function (event)
			{
				changedValue = savedValue;
				redrawStars(savedValue);
			});
		};
		
		var replaceEditable = function ()
		{
			org.after(container);
			org.hide();
		};
		
		var replaceViewable = function ()
		{
			org.replaceWith(container);
		};
		
		var setValue = function (value)
		{
			savedValue = value;
			org.val(value); // bringt scheinbar nichts
			org.attr('value', value);
		};
		
		initialize();
	});
};