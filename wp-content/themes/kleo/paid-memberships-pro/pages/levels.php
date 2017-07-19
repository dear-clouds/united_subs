<?php 
global $wpdb, $pmpro_msg, $pmpro_msgt, $pmpro_levels, $current_user, $pmpro_currency_symbol;
if($pmpro_msg)
{
?>
<div class="message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<div class="row membership pricing-table">
    
	<?php	
  $restrict_options = kleo_memberships();
  
	$pmpro_levels = array_filter($pmpro_levels);
	
  $levelsno = count($pmpro_levels);
  $levelsno = ($levelsno == 0)? 1:$levelsno;
  $level_cols = 12/$levelsno;
	
	$newoptions = sq_option('membership');

	$popular = $newoptions['kleo_membership_popular'];
	$kleo_pmpro_levels_order = isset($newoptions['kleo_pmpro_levels_order']) ? $newoptions['kleo_pmpro_levels_order'] : NULL;

  
  switch ($level_cols)
  {
      case "1":
        $level_cols = "1";
        break;
      case "2":
        $level_cols = "2";
        break;
      case "3":
        $level_cols = "3";
        break;
      case "4":
        $level_cols = "4";
        break;
      case "6":
        $level_cols = "6";
        break;
      case "12":
        $level_cols = "12";
        break;
      default: 
        $level_cols = "3";
        break;
  }
  $level_cols = apply_filters('kleo_pmpro_level_columns', $level_cols);
  
  $pmpro_levels_sorted = array();
  
  if (is_array($kleo_pmpro_levels_order)) 
  {
    asort($kleo_pmpro_levels_order);

    foreach($kleo_pmpro_levels_order as $k => $v)
    {
      if(!empty($pmpro_levels[$k])) {
        $pmpro_levels_sorted[$k] = $pmpro_levels[$k];
        unset($pmpro_levels[$k]);
      }
    }
    $pmpro_levels_sorted = $pmpro_levels_sorted + $pmpro_levels;
  }
 else  
 {
   $pmpro_levels_sorted = $pmpro_levels;
 }
  
	foreach($pmpro_levels_sorted as $level)
	{
    if(isset($current_user->membership_level->ID)) {
		  $current_level = ($current_user->membership_level->ID == $level->id);
		}
	  else {
		  $current_level = false;
		}
	?>

  <div class="col-md-<?php echo $level_cols;?>">
    <div class="panel text-center panel-info kleo-level-<?php echo $level->id; ?><?php if ($popular == $level->id) echo ' popular';?>">
      <div class="panel-heading"><h3><?php echo $level->name; ?></h3></div>
      <div class="panel-body">
        <?php
        //recurring part
        if(pmpro_isLevelFree($level))
        {
          echo "<strong>" . __('Free', 'pmpro') . "</strong>";
        }
        elseif($level->billing_amount != '0.00')
        {
          if($level->billing_limit > 1)
          {			
            if($level->cycle_number == '1')
            {
              printf(_x('%s per %s for %d more %s.', 'Recurring payment in cost text generation. E.g. $5 every month for 2 more payments.', 'kleo_framework'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));					
            }				
            else
            { 
              printf(_x('%s every %d %s for %d more %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months for 2 more payments.', 'kleo_framework'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));					
            }
          }
          elseif($level->billing_limit == 1)
          {
            printf(_x('%s after %d %s.', 'Recurring payment in cost text generation. E.g. $5 after 2 months.', 'kleo_framework'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));									
          }
          else
          {
            if($level->cycle_number == '1')
            {
              printf(_x('%s per %s.', 'Recurring payment in cost text generation. E.g. $5 every month.', 'kleo_framework'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period));					
            }				
            else
            { 
              printf(_x('%s every %d %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months.', 'kleo_framework'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));					
            }			
          }
        }			

        //trial
        if(pmpro_isLevelTrial($level))
        {
          if($level->trial_amount == '0.00')
          {
            if($level->trial_limit == '1')
            {
              echo ' ' . _x('After your initial payment, your first payment is Free.', 'Trial payment in cost text generation.', 'pmpro');
            }
            else
            {
              printf(' ' . _x('After your initial payment, your first %d payments are Free.', 'Trial payment in cost text generation.', 'pmpro'), $level->trial_limit);
            }
          }
          else
          {
            if($level->trial_limit == '1')
            {
              printf(' ' . _x('After your initial payment, your first payment will cost %s.', 'Trial payment in cost text generation.', 'pmpro'), $pmpro_currency_symbol . $level->trial_amount);
            }
            else
            {
              printf(' ' . _x('After your initial payment, your first %d payments will cost %s.', 'Trial payment in cost text generation. E.g. ... first 2 payments will cost $5', 'pmpro'), $level->trial_limit, $pmpro_currency_symbol . $level->trial_amount);
            }
          }
        }

        $expiration_text = pmpro_getLevelExpiration($level);
        if($expiration_text)
        {
        ?>
          <br /><span class="pmpro_level-expiration"><?php echo $expiration_text?></span>
        <?php
        }
        ?>
					
				<div class="pmpro-price">
					<p class="lead">
					<?php if(pmpro_isLevelFree($level) || $level->initial_payment === "0.00") { ?>
							<?php echo $pmpro_currency_symbol?><?php _e('0', 'pmpro');?>
					<?php } else {
						$l_price = explode(".", $level->initial_payment);
						
						echo $pmpro_currency_symbol; echo $l_price[0];
						if (isset($l_price[1])) {
							echo '<sup>.' . $l_price[1] . '</sup>';
						}
					} ?>
					</p>
				</div>
					
      </div>

			

			
      <?php if ($level->description) { ?>
      <div class="extra-description"><?php echo $level->description;?></div>
      <?php } ?>
			
      <ul class="list-group list-group-flush">
      <?php
      if ( function_exists('bp_is_active') ) {
          global $kleo_pay_settings;
          foreach ($kleo_pay_settings as $set) {
              if ($restrict_options[$set['name']]['showfield'] != 2) { ?>
                  <li class="list-group-item <?php if ($restrict_options[$set['name']]['type'] == 1 || ($restrict_options[$set['name']]['type'] == 2 && isset($restrict_options[$set['name']]['levels']) && is_array($restrict_options[$set['name']]['levels']) && in_array($level->id, $restrict_options[$set['name']]['levels']))) {
                      _e("unavailable", 'pmpro');
                  } ?>"><?php echo $set['front']; ?></li>
              <?php
              }
          }
      }
      do_action('kleo_pmpro_after_membership_table_items', $level);
      ?>
      </ul>
			
      <div class="panel-footer">
        <?php if(empty($current_user->membership_level->ID)) { ?>
          <a class="<?php if ($popular == $level->id) echo 'btn btn-highlight'; else echo 'btn btn-default';?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'kleo_framework');?></a>               
        <?php } elseif ( !$current_level ) { ?>                	
          <a class="<?php if ($popular == $level->id) echo 'btn btn-default'; else echo 'btn btn-default';?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'kleo_framework');?></a>       			
        <?php } elseif($current_level) { ?>      
          <a class="btn btn-default disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
        <?php } ?>
                
      </div>
    </div>
  </div>
	<?php  
  }
  ?>
		
</div>



<nav id="nav-below" class="navigation" role="navigation" style="display: inline-block;">
	<div class="nav-previous alignleft">
		<?php if(!empty($current_user->membership_level->ID)) { ?>
			<a href="<?php echo pmpro_url("account")?>" class="btn btn-link"><?php _e('&larr; Return to Your Account', 'pmpro');?></a>
		<?php } else { ?>
			<a href="<?php echo home_url()?>" class="btn btn-link"><?php _e('&larr; Return to Home', 'pmpro');?></a>
		<?php } ?>
	</div><br>&nbsp;<br><br>
</nav>