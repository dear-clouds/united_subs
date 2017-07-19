jQuery(".accordion").accordion({header: "h3.accordion-title", heightStyle: "content"});
jQuery("h3.accordion-title").toggle(
	function(){
		jQuery(this).addClass("active");
	}, function () {
		jQuery(this).removeClass("active");
	}
);