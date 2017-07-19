jQuery(function(){
jQuery("#object-nav, #subnav").wrapAll("<div id='mytabs' />");
});



jQuery(function(){
    var content_height = jQuery('#content').height();
    var sidebar_height = jQuery('#sidebar').height();
    if (content_height < sidebar_height) {
       jQuery('#content').css('border-right', 'none');
       jQuery('#sidebar').css('border-left', '1px solid #eaeaea');
       jQuery('#item-body').css('margin-right', '-16px');
    }
}); 


jQuery(document).ready(function()
{
    jQuery(".hoverText").focus(function(srcc)
    {
        if (jQuery(this).val() == jQuery(this)[0].title)
        {
            jQuery(this).removeClass("hoverTextActive");
            jQuery(this).val("");
        }
    });
    
    jQuery(".hoverText").blur(function()
    {
        if (jQuery(this).val() == "")
        {
            jQuery(this).addClass("hoverTextActive");
            jQuery(this).val(jQuery(this)[0].title);
        }
    });
    
    jQuery(".hoverText").blur();        
});





(function(jQuery){
 jQuery.fn.extend({
 
 	customStyle : function(options) {
	  if(!jQuery.browser.msie || (jQuery.browser.msie&&jQuery.browser.version>6)){
	  return this.each(function() {
	  
			var currentSelected = jQuery(this).find(':selected');
			jQuery(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:jQuery(this).next().css('font-size')});
			var selectBoxSpan = jQuery(this).next();
			var selectBoxWidth = parseInt(jQuery(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));			
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			jQuery(this).height(selectBoxHeight).change(function(){
				// selectBoxSpanInner.text(jQuery(this).val()).parent().addClass('changed');   This was not ideal
			selectBoxSpanInner.text(jQuery(this).find(':selected').text()).parent().addClass('changed');
				// Thanks to Juarez Filho & PaddyMurphy
			});
			
	  });
	  }
	}
 });
})(jQuery);

jQuery(function(){

jQuery('select#activity-filter-by, select#forums-order-by, select#members-order-by, #top-bar select#search-which, select#members-friends, select#blogs-order-by, select#notifications-sort-order-list').customStyle();

});




(function(jQuery) {

    jQuery.organicTabs = function(el, options) {
    
        var base = this;
        base.jQueryel = jQuery(el);
        base.jQuerynav = base.jQueryel.find(".tabs-nav, .tabs-nav2");
                
        base.init = function() {
        
            base.options = jQuery.extend({},jQuery.organicTabs.defaultOptions, options);
            
            // Accessible hiding fix
            jQuery(".hidden-tab").css({
                "position": "relative",
                "top": 0,
                "left": 0,
                "display": "none"
            }); 
            
            base.jQuerynav.delegate("li > a", "click", function() {
            
                // Figure out current list via CSS class
                var curList = base.jQueryel.find("a.current").attr("href").substring(1),
                
                // List moving to
                    jQuerynewList = jQuery(this),
                    
                // Figure out ID of new list
                    listID = jQuerynewList.attr("href").substring(1),
                
                // Set outer wrapper height to (static) height of current inner list
                    jQueryallListWrap = base.jQueryel.find(".list-wrap"),
                    curListHeight = jQueryallListWrap.height();
                jQueryallListWrap.height(curListHeight);
                                        
                if ((listID != curList) && ( base.jQueryel.find(":animated").length == 0)) {
                                            
                    // Fade out current list
                    base.jQueryel.find("#"+curList).fadeOut(base.options.speed, function() {
                        
                        // Fade in new list on callback
                        base.jQueryel.find("#"+listID).fadeIn(base.options.speed);
                        
                        // Adjust outer wrapper to fit new list snuggly
                        var newHeight = base.jQueryel.find("#"+listID).height();
                        jQueryallListWrap.animate({
                            height: newHeight
                        });
                        
                        // Remove highlighting - Add to just-clicked tab
                        base.jQueryel.find(".tabs-nav li a, .tabs-nav2 li a").removeClass("current");
                        jQuerynewList.addClass("current");
                            
                    });
                    
                }   
                
                // Don't behave like a regular link
                // Stop propegation and bubbling
                return false;
            });
            
        };
        base.init();
    };
    
    jQuery.organicTabs.defaultOptions = {
        "speed": 700
    };
    
    jQuery.fn.organicTabs = function(options) {
        return this.each(function() {
            (new jQuery.organicTabs(this, options));
        });
    };
    
})(jQuery);



        jQuery(function() {
            jQuery("#tabs-container").organicTabs({
                "speed": 500
            });
        });


        jQuery(function() {
            jQuery("#tabs-container2").organicTabs({
                "speed": 500
            });
        });



jQuery(function(){
jQuery("#content h3:empty").remove();
jQuery(".thumbnail span:empty").remove();
})


jQuery(document).ready(function() { 
    jQuery('#banner').oneByOne({
		className: 'oneByOne1',
		showButton: true,  
		showArrow: false, 	            
		easeType: 'random'
	});  
}); 


jQuery(function() {
jQuery('table tr.sticky div.topic-title a.forum-post-title').before('<span class="sticky-label"></span>');
jQuery('table tr.status-closed div.topic-title a.forum-post-title').before('<span class="closed-label"></span>');
});


/**
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 */
(function() {
  if (!window.console) {
    window.console = {};
  }
  // union of Chrome, FF, IE, and Safari console methods
  var m = [
    "log", "info", "warn", "error", "debug", "trace", "dir", "group",
    "groupCollapsed", "groupEnd", "time", "timeEnd", "profile", "profileEnd",
    "dirxml", "assert", "count", "markTimeline", "timeStamp", "clear"
  ];
  // define undefined methods as noops to prevent errors
  for (var i = 0; i < m.length; i++) {
    if (!window.console[m[i]]) {
      window.console[m[i]] = function() {};
    }    
  } 
})();
