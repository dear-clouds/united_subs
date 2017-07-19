<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * MULTIVERSO CHANGES
 * @internal
 */
/*
Manage Files
*/
?>

<?php if ( !is_user_logged_in() ) { _e('You need to be logged to manage your files!', 'woffice'); }else{ // Check user logged ?>

<?php $page_id =  get_the_ID(); ?>

<?php 
// UPDATE File 
if (isset($_POST['subUpdate'])) {

	mv_update_frontend_post($_POST['fileID']);
	
}

// SAVE File 
if (isset($_POST['subSave'])) {

	mv_save_frontend_post($page_id);
	
}

// TRASH File
if (isset($_GET['mv_trash_file'])) {

	wp_trash_post($_GET['mv_trash_file']);
	
}
?>


<?php
global $post;
$post_slug = $post->post_name;
$the_terms = get_term_by( 'slug', $post_slug, 'multiverso-categories');
$first = true;
foreach ($the_terms as $term):
	if (!empty($term) && $first):
		$project_id = $term;	
		$first = false;
	endif;
endforeach;

global $current_user;
get_currentuserinfo();

$user = $current_user->user_login;

$query = new WP_Query( array(
    'post_type' => 'multiverso',
    'tax_query' => array(
		array(
			'taxonomy' => 'multiverso-categories',
			'field'    => 'id',
			'terms'    => $project_id,
		),
	),
    'posts_per_page' => -1,
	'meta_key' => 'mv_user',
	'meta_value' => $user,
    'post_status' => array(
        'publish',
        'pending',
        'draft',
        'private',
        'trash'
    )
));

?>

<div class="mv-file-managing">

<?php

 // ADD FILE // 
$add_post = add_query_arg( 'mv_add_file', true, get_permalink( $page_id ) );

echo '<div class="mv-addfile-wrap"><a href="'.esc_url($add_post).'">'.__('Add new File', 'woffice').'</a></div>';

if( isset($_GET['mv_add_file']) && $_GET['mv_add_file'] == 1 ) {
        
	mv_add_form($page_id);    
        
}


?>
<div class="mv-clear"></div>
<table class="mv-editfile">
 
    <tr class="mv-editfile-head">
        <th class="mv-editfile-title"><?php _e('Title','woffice'); ?></th>
        <th class="mv-editfile-folder"><?php _e('Category/Folder','woffice'); ?></th>
        <th class="mv-editfile-status"><?php _e('Status','woffice'); ?></th>
        <th class="mv-editfile-actions"><?php _e('Actions','woffice'); ?></th> 
    </tr>
 
    <?php
	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
	$edit_post = add_query_arg( 'mv_edit_file', get_the_ID(), get_permalink( $page_id ) );
	$trash_post = add_query_arg( 'mv_trash_file', get_the_ID(), get_permalink( $page_id ) );
    ?>
        <tr>
            <td><?php echo get_the_title(); ?></td> 
            <td><?php mv_file_categories(get_the_ID(), 'multiverso-categories', 'multiverso', false, false); ?></td>
            <td class="mv-editfile-status <?php echo get_post_status( get_the_ID() ) ?>"><?php echo get_post_status( get_the_ID() ); ?></td>
            <td>
            
            <a href="<?php echo esc_url($edit_post); ?>" title="Edit"><i class="mvico-pencil"></i></a> 
            
            <?php if( !(get_post_status() == 'trash') ) { ?> 
 
   				<a onclick="return confirm('<?php _e('Are you sure you wish to trash the file: ', 'woffice'); echo get_the_title().'?'; ?>')"href="<?php echo esc_url($trash_post); ?>" title="Trash"><i class="mvico-remove2"></i></a>
  
			<?php } ?>
            
            </td>
        </tr>
        
        <?php if( isset($_GET['mv_edit_file']) && $_GET['mv_edit_file'] == get_the_ID() ) { ?>
        
        <tr>
            <td colspan="4"><?php mv_edit_form($_GET['mv_edit_file'], $page_id); ?></td> 
        </tr>
        
        <?php } ?>
 
<?php endwhile; endif; wp_reset_postdata(); ?>
 
</table>


<?php } // End if user logged ?>





<?php 

// EDIT FORM //

function mv_edit_form($file_id, $page_id) {
	
// Setup Data
$file_data = get_post($file_id);

// Lock the file to prevent simultaneous editing
mv_set_file_lock($file_id);

?>

<h3 class="mv-editfile-title"><?php _e( 'Edit File', 'woffice'); ?><span><a href="<?php echo get_permalink($page_id); ?>" class="mv-edit-close"><i class="mvico-close"></i></a></span></h3>

<form action="" id="updateFile" method="POST" enctype="multipart/form-data" autocomplete="off">
 
    <fieldset>
 
        <input type="text" name="fileTitle" id="fileTitle" value="<?php echo esc_attr($file_data->post_title); ?>" placeholder="<?php _e( 'Title', 'woffice' ); ?>">
 
        <textarea name="fileContent" id="fileContent" rows="8" cols="30" placeholder="<?php _e( 'Description', 'woffice' ); ?>"><?php echo esc_html($file_data->post_content); ?></textarea>
 
    </fieldset>
 
 
    <fieldset class="mv-basicfields"> 
 
    	<label for="mvCategory"><?php _e( 'Category', 'woffice'); ?></label>
        
    	<select name="mvCategory" id="mvCategory">
		
        <?php
		
		// MV Cateogires
		$categories = mv_get_categories();
		$saved_cats = get_the_terms( $file_data->ID, 'multiverso-categories' );
		if ( !empty( $saved_cats ) ) {
            foreach ( $saved_cats as $c ) {
				$saved_cat = $c->term_id;
				break;
			}
        }
		
        foreach ($categories as $cat) {
			if( $cat['value'] == $saved_cat ) {
        		echo '<option value="'.$cat['value'].'" selected="selected">'.$cat['label'].'</option>';
			}else{
				echo '<option value="'.$cat['value'].'">'.$cat['label'].'</option>';
			}
        }
		
		?>
	
		</select>
  		<div class="mv-clear"></div>
        
    	<label for="mvStatus"><?php _e( 'Status', 'woffice'); ?></label>
    	<select name="mvStatus" id="mvStatus">
			<option value="publish" <?php if($file_data->post_status == 'publish' ){ echo 'selected="selected"'; } ?>><?php _e('Published','woffice'); ?></option>
        	<option value="pending" <?php if($file_data->post_status == 'pending' ){ echo 'selected="selected"'; } ?>><?php _e('Pending Review','woffice'); ?></option>
        	<option value="draft" <?php if($file_data->post_status == 'draft' ){ echo 'selected="selected"'; } ?>><?php _e('Draft','woffice'); ?></option>
            <option value="trash" <?php if($file_data->post_status == 'trash' ){ echo 'selected="selected"'; } ?>><?php _e('Trashed','woffice'); ?></option>
        </select>
        <div class="mv-clear"></div>
        
    </fieldset>
    
    <fieldset class="mv-advancedfields">
    
    <?php mv_meta_frontend_file_update($file_id); ?> 
    
    </fieldset>
    
    <fieldset class="mv-submitfields">
         
        <?php wp_nonce_field( 'post_nonce', 'mvfile_nonce' ); ?>
 		
        <input type="hidden" name="fileID" id="fileID" value="<?php echo $file_data->ID; ?>">
        <input type="hidden" name="subUpdate" id="subUpdate" value="true" />
        <button type="submit"><?php _e( 'Update', 'woffice'); ?></button> 
 
    </fieldset>
 
</form>

<?php } // End Edit Form ?>



<?php 

// ADD FORM //

function mv_add_form($page_id) {
	
?>

<h3 class="mv-addfile-title"><?php _e('Add new File', 'woffice'); ?><span><a href="<?php echo get_permalink($page_id); ?>" title="Close"><i class="mvico-close"></i></a> </span></h3>
<div class="mv-addfile-form">

<form action="<?php echo get_permalink( $page_id ); ?>" id="addFile" method="POST" enctype="multipart/form-data" autocomplete="off">
 
    <fieldset>
 
        <input type="text" name="fileTitle" id="fileTitle" value="" placeholder="<?php _e( 'Title', 'woffice' ); ?>" >
 
    </fieldset>
 
 
    <fieldset>
 
        <textarea name="fileContent" id="fileContent" rows="8" cols="30" placeholder="<?php _e( 'Description', 'woffice' ); ?>"></textarea>
 
    </fieldset> 
    
    <fieldset class="mv-basicfields">
    
    	<label for="mvCategory"><?php _e( 'Category', 'woffice'); ?></label>
    	
    	<select name="mvCategory" id="mvCategory">
    	<?php
		/**
		* EDITED FOR WOFFICE
		**/
		global $post;
		$post_slug = $post->post_name;
		$the_terms = get_term_by( 'slug', $post_slug, 'multiverso-categories');
		$first = true;
		foreach ($the_terms as $term):
			if (!empty($term) && $first):
				$project_id = $term;	
				$first = false;
			endif;
		endforeach;
		$the_term_name = get_term_by('name', $project_id, 'multiverso-categories'); ?>
    	
    	
		<?php
		// MV Cateogires
		$categories = mv_get_categories();
		
        foreach ($categories as $cat) {
        	if ($cat['value'] == $project_id):
			echo '<option value="'.$cat['value'].'">'.$cat['label'].'</option>';	
			endif;
        }
		
		?>
	
		</select>
    	<div class="mv-clear"></div>
   
    	<label for="mvStatus"><?php _e( 'Status', 'woffice'); ?></label>
    	<select name="mvStatus" id="mvStatus">
			<option value="publish" selected="selected"><?php _e( 'Published', 'woffice'); ?></option>
        	<option value="pending"><?php _e( 'Pending Review', 'woffice'); ?></option>
        	<option value="draft"><?php _e( 'Draft', 'woffice'); ?></option>
            <option value="trash"><?php _e( 'Trashed', 'woffice'); ?></option>
        </select>
        <div class="mv-clear"></div>
    </fieldset>
    
    <fieldset class="mv-advancedfields">
    
    <?php mv_meta_frontend_file_add(); ?> 
    
    </fieldset>
    
    <fieldset class="mv-submitfields">
         
        <?php wp_nonce_field( 'post_nonce', 'mvfile_nonce' ); ?>

        <input type="hidden" name="subSave" id="subSave" value="true" />
        <button type="submit"><?php _e( 'Save', 'woffice'); ?></button> 
        
 
    </fieldset>
 
</form>
</div>

<?php } // End Add Form ?>

</div>

<?php 


function mv_set_file_lock( $post_id ) {
	if ( !$post = get_post( $post_id ) )
		return false;
	if ( 0 == ($user_id = get_current_user_id()) )
		return false;

	$now = time();
	$lock = "$now:$user_id";

	update_post_meta( $post->ID, '_edit_lock', $lock );
	return array( $now, $user_id );
}