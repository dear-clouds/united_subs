/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* PROJECTS 
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
(function($) {
    "use strict";
    /* 
     * The todo JS here
     */
    // THE CHECKBOX ACTIONS
    $('.woffice-task header label input').each(function(){
    	var Checkbox = $(this);
	    if (Checkbox.is(':checked')) {
		    Checkbox.closest('.woffice-task').addClass('is-done');
	    }
	    
	});
	
	// THE NOTE TOGGLE
	$(".woffice-task .todo-note").hide();
	$("#woffice-project-todo").on('click', '.woffice-task header i.fa.fa-file-text-o', function(){
		var Task = $(this).closest('.woffice-task');
	    Task.find('.todo-note').slideToggle();
	    Task.toggleClass('unfolded');
	});
	
    // NAVAIGATION ACTIVE CLASS
    $('#project-nav ul').on('click', 'li', function(){
	    $('#project-nav ul li').removeClass('active');
	    $(this).addClass('active');
	    
		$("#right-sidebar").mCustomScrollbar("update");
	    
	});
	
	//DATEPICKER : 
	$('.row .datepicker').datepicker({
	    format: 'dd-mm-yyyy',
	    todayHighlight: true,
        clearBtn: true
	});
	
	//SORTABLE : 
	var adjustment;
	$(".woffice-project-todo-group").sortable({
		pullPlaceholder: false,
		itemSelector: '.woffice-task',
		placeholder: '<div class="todo-placeholder placeholder"><i class="fa fa-arrow-right"></i></div>',
		start: function( event, ui ) {
			$(window).on('resize', function() {
				if($(window).width() <= 450) {
					$(".woffice-project-todo-group").sortable('disable');
				} else {
					$(".woffice-project-todo-group").sortable('enable');
				}
			});
		},
		onDragStart: function ($item, container, _super) {
			var offset = $item.offset(),
			    pointer = container.rootGroup.pointer;
			
			adjustment = {
			  left: pointer.left - offset.left,
			  top: pointer.top - offset.top
			};
			
			_super($item, container);
		},
		onDrag: function ($item, position) {
			$item.css({
			  left: position.left - adjustment.left,
			  top: position.top - adjustment.top
			});
		},
		onDrop: function ($item, container, _super) {
			
			var Woffice_OrderData = $(".woffice-project-todo-group").serialize();
			
			var data_send = {
				action : 'wofficeTodoOrder',
				form : Woffice_OrderData
			};
			
			$.ajax({
				type:"POST",
				url: ajaxurl,
				data: data_send,
				success:function(returnval){
					console.log(returnval);
					console.log("Task order updated");	
				},
			});
			
			_super($item, container);
		}
	});
	
	/* 
     * The layout JS here
     */
    // INITIATE
	$("#project-content-edit, #project-content-comments, #project-content-todo, #project-content-files, #project-loader").hide();
    
    // REDIRECT ON PAGE RELOAD
    var hash = location.hash.replace('#', '');
    var search = location.search.replace('?', '');
    if(search == 'mv_add_file=1'){
    	$("#project-tab-files").addClass("active");
		$('#project-content-files').show();
		$('#project-tab-view').removeClass('active');
		$("#project-content-view").hide();
    }
    else {
	    if (hash != '') {
	    	$('#'+hash).show();
	    	if (hash != 'project-content-view') {
	    		$('#project-tab-view').removeClass('active');
				$("#project-content-view").hide();
		    	if (hash == 'project-content-edit') {
				    $("#project-tab-edit").addClass("active");
				} else if (hash == 'project-content-todo') {
				    $("#project-tab-todo").addClass("active");
				} else if (hash == 'project-content-files') {
				    $("#project-tab-files").addClass("active");
				} else {
				    $("#project-tab-comments").addClass("active");
					$("#project-content-comments").show();
				}
			}
	    } 
	}
    
    // VIEW 
    $("#project-tab-view a").on('click', function(){
    	$('#project-loader').slideDown();
		$("#project-content-edit, #project-content-comments, #project-content-files, #project-content-todo").hide();
    	function show_project_view() {
	    	$("#project-content-view").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_project_view, 1000);
	});
	
	
    // EDIT 
    $("#project-tab-edit a").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#project-content-view, #project-content-comments, #project-content-files, #project-content-todo").hide();
	    function show_project_edit() {
	    	$("#project-content-edit").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_project_edit, 1000);
	});
		
    // TODO 
    $("#project-tab-todo a").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#project-content-view, #project-content-edit, #project-content-comments, #project-content-files").hide();
	    function show_project_todo() {
	    	$("#project-content-todo").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_project_todo, 1000);	    
	});
		
    // FILES 
    $("#project-tab-files a").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#project-content-view, #project-content-edit, #project-content-comments, #project-content-todo").hide();
	    function show_project_files() {
	    	$("#project-content-files").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_project_files, 1000);	    
	});
	
    // COMMENTS 
    $("#project-tab-comments a").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#project-content-view, #project-content-edit, #project-content-files, #project-content-todo").hide();
	    function show_project_comments() {
	    	$("#project-content-comments").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_project_comments, 1000);
	});
	
	// CHANGE BUDDYPRESS LINK EFFECT
	$( "#project-nav .item-list-tabs #project-tab-delete a").unbind( "click" );
	
	// CREATE NEW PROJECT
	$("#project-create, #project-loader").hide();
	$("#show-project-create").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#projects-list, #projects-bottom").hide();
	    function show_create_project() {
	    	$("#project-create").show();
			$('#project-loader').slideUp();
		}
		setTimeout(show_create_project, 1000);	    
	});
	$("#hide-project-create").on('click', function(){
    	$('#project-loader').slideDown();
	    $("#project-create").hide();
	    function hide_create_project() {
	    	$("#projects-list,#projects-bottom").show();
			$('#project-loader').slideUp();
		}
		setTimeout(hide_create_project, 1000);	    
	});
})(jQuery);