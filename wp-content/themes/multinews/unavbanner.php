<?php if (mom_option('unav_banner') == 1) { 
  if (mom_display_logic('unav_banner_display_logic') == true) {
  $auto_close = mom_option('unav_banner_close_timeout');
  ?>
<div class="unav_banner" data-timeout="<?php echo $auto_close; ?>">
 <div class="inner">
   <?php
    if (mom_option('unav_banner_close') == 1) {
     $save_state = 'tb_save_close';
     if (mom_option('unav_banner_close_save') == 1) {
       $save_state = 'tb_save_close';
     }
     echo '<a class="unav_banner_close '.$save_state.'" href="#" data-exp="7"><i class="fa-icon-remove"></i></a>';
    }
    if (mom_option('unav_banner_content') == 1) {
       echo do_shortcode('[ad id="'.mom_option('unav_banner_ad').'"]');
    } else {
      echo do_shortcode(mom_option('unav_banner_custom')); 
    }
   ?>
 </div>
</div>
 <?php } } ?>