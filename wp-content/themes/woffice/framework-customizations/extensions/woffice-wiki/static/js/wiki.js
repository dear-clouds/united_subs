/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* WIKI 
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
(function($) {
    "use strict";
    // NAVAIGATION ACTIVE CLASS
    $('#wiki-nav ul').on('click', 'li', function(){
	    $('#wiki-nav ul li').removeClass('active');
	    $(this).addClass('active');
	});
    // INITIATE
    $("#wiki-content-edit, #wiki-content-comments, #wiki-content-revisions, #wiki-loader").hide();
    // VIEW 
    $("#wiki-tab-view a").on('click', function(){
    	$('#wiki-loader').slideDown();
		$("#wiki-content-edit, #wiki-content-comments, #wiki-content-revisions").hide();
    	function show_wiki_view() {
	    	$("#wiki-content-view").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(show_wiki_view, 1000);
	});
    // EDIT 
    $("#wiki-tab-edit a").on('click', function(){
    	$('#wiki-loader').slideDown();
	    $("#wiki-content-view, #wiki-content-comments, #wiki-content-revisions").hide();
	    function show_wiki_edit() {
	    	$("#wiki-content-edit").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(show_wiki_edit, 1000);
	});
    // COMMENTS 
    $("#wiki-tab-comments a").on('click', function(){
    	$('#wiki-loader').slideDown();
	    $("#wiki-content-view, #wiki-content-edit, #wiki-content-revisions").hide();
	    function show_wiki_comments() {
	    	$("#wiki-content-comments").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(show_wiki_comments, 1000);
	});
    // REVISIONS 
    $("#wiki-tab-revisions a").on('click', function(){
    	$('#wiki-loader').slideDown();
	    $("#wiki-content-view, #wiki-content-edit, #wiki-content-comments").hide();
	    function show_wiki_revisions() {
	    	$("#wiki-content-revisions").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(show_wiki_revisions, 1000);	    
	});
	
	// CHANGE BUDDYPRESS LINK EFFECT
	$( "#wiki-nav .item-list-tabs #wiki-tab-delete a").unbind( "click" );
	
	// CREATE NEW ARTICLE
	$("#wiki-create, #wiki-loader").hide();
	$("#show-wiki-create").on('click', function(){
    	$('#wiki-loader').slideDown();
	    $("#wiki-page-content").hide();
	    function show_create_wiki() {
	    	$("#wiki-create").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(show_create_wiki, 1000);	    
	});
	$("#hide-wiki-create").on('click', function(){
    	$('#wiki-loader').slideDown();
	    $("#wiki-create").hide();
	    function hide_create_wiki() {
	    	$("#wiki-page-content").show();
			$('#wiki-loader').slideUp();
		}
		setTimeout(hide_create_wiki, 1000);	    
	});
})(jQuery);