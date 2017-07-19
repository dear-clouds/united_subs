jQuery(document).ready(function($) {

	$(".run-demo-content").click( function(e){
		e.preventDefault();

		t = jQuery(this);
		dir = t.data('dir');
		var yes = confirm("Importing the dummy data will overwrite your current Theme Option settings. Proceed anyways?");
		if (yes===true) {
					jQuery.ajax({
			    type: "post",
			    url: demo_installer.url,
			    dataType: 'html',
			    data: "action=demo_installer&nonce="+demo_installer.nonce+"&dir="+dir,
			    beforeSend: function() {
			    	t.addClass('active');
			    },
			    success: function(){
			    	t.addClass('success');
			    	t.find('.demo_loading').removeClass('loading').addClass('done');
			    	t.find('.import_warning').text('All Done .. Have Fun!');
				    //setTimeout(function(){window.location.reload();}, 5000);
			    }
			});
		}


});
}) // jQuery end 