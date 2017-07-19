<div class="top-share-icons">
<?php 
if(mom_option('share_position') == 'top' || mom_option('share_position') == 'both') {
if(mom_option('post_sharee')) {
if ($DPS != 1) { mom_posts_share(get_the_ID(),get_permalink()); }
} }
?>
</div>