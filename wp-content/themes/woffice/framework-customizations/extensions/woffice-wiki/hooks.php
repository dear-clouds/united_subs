<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/*---------------------------------------------------------
** 
** TRICK TO CHECK IF THE EXTENSIONS IS ENABLED
**
----------------------------------------------------------*/
function woffice_wiki_extension_on(){
	return;
}
/*---------------------------------------------------------
** 
** LIKE BUTTON JQUERY
**
----------------------------------------------------------*/	
function woffice_wiki_buttons_js(){
	
	if (is_singular("wiki")){
		/*Ajax URL*/
		$ajax_url = admin_url('admin-ajax.php');
		/*Ajax Nonce*/
		$ajax_nonce = wp_create_nonce('ajax-nonce');
		
		echo'<script type="text/javascript">
			jQuery(function () {
			
				jQuery(".wiki-like a").click(function(){
	     
			        like = jQuery(this);
			        post_id = like.data("post_id");
			         
			        // Ajax call
			        jQuery.ajax({
			            type: "post",
			            url: "'.$ajax_url.'",
			            data: "action=post-like&nonce='.$ajax_nonce.'&post_like=&post_id="+post_id,
			            success: function(count){
			                if(count != "already")
			                {
			                    like.closest(".wiki-like").addClass("voted");
			                    like.siblings(".count").text(count);
			                }
			            }
			        });
			         
			        return false;
			        
			    });
			
			});
		</script>';
	}
	
}
add_action('wp_footer', 'woffice_wiki_buttons_js');

/*---------------------------------------------------------
** 
** LIKE BUTTON FUNCTION
**
----------------------------------------------------------*/	
function post_like(){
	
	$ext_instance = fw()->extensions->get( 'woffice-wiki' );
	
    // Check for nonce security
    $nonce = $_POST['nonce'];
  
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
     
    if(isset($_POST['post_like']))
    {
        // Retrieve user IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        $post_id = $_POST['post_id'];
         
        // Get voters'IPs for the current post
        $meta_IP = get_post_meta($post_id, "voted_IP");
        $voted_IP = (empty($meta_IP)) ? 0 : $meta_IP[0];
 
        if(!is_array($voted_IP))
            $voted_IP = array();
         
        // Get votes count for the current post
        $meta_count = get_post_meta($post_id, "votes_count", true);
 
        // Use has already voted ?
        if(!$ext_instance->woffice_user_has_already_voted($post_id))
        {
            $voted_IP[$ip] = time();
 
            // Save IP and increase votes count
            update_post_meta($post_id, "voted_IP", $voted_IP);
            update_post_meta($post_id, "votes_count", ++$meta_count);
             
            // Display count (ie jQuery return value)
            echo $meta_count;
        }
        else
            echo "already";
    }
    exit;
}
add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');