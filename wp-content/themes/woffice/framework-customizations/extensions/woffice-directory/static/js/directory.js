/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* DIRECTORY 
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
(function($) {
    "use strict";
	
	// CREATE NEW ARTICLE
	$("#directory-create, #directory-loader").hide();
	$("#show-directory-create").on('click', function(){
    	$('#directory-loader').slideDown();
	    $("#directory, #content article").hide();
	    function show_create_directory() {
	    	$("#directory-create").show();
			$('#directory-loader').slideUp();
			$("#show-directory-create").hide();
		}
		setTimeout(show_create_directory, 1000);	    
	});
	$("#hide-directory-create").on('click', function(){
    	$('#directory-loader').slideDown();
	    $("#directory-create").hide();
	    function hide_create_directory() {
	    	$("#directory, #content article").show();
			$('#directory-loader').slideUp();
			$("#show-directory-create").show();
		}
		setTimeout(hide_create_directory, 1000);	    
	});
})(jQuery);