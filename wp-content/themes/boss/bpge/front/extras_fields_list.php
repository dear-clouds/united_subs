<ul id="fields-sortable">
    <?php
    foreach((array)$fields as $field){ ?>
        <li id="position_<?php echo $field->ID; ?>" class="default">
			<div class="bb-field-content-wrap">
				<strong title="<?php echo  htmlspecialchars(strip_tags($field->post_content));?>"><?php echo stripslashes($field->post_title);?></strong>
				<span class="bb-arrow">&rarr;</span> <?php echo stripslashes($field->post_excerpt);?>
				<span class="bb-arrow">&rarr;</span> <?php (($field->post_status == 'publish')?_e('displayed','bpge'):_e('<u>not</u> displayed','bpge'));?>
				<span class="bb-arrow">&rarr;</span> <?php (($field->pinged == 'req')?_e('required','bpge'):_e('<u>not</u> required','bpge'));?>
			</div>
			
            <span class="items-link">
                <a href="<?php echo bp_get_group_permalink( $bp->groups->current_group );?>admin/<?php echo $slug; ?>/fields-manage/?edit=<?php echo $field->ID;?>" class="button bb-edit-button" title="<?php _e('Change its title, description etc','bpge');?>"><i class="fa fa-pencil"></i></a>
                <a href="#" class="button delete_field bb-delete-button" title="<?php _e('Delete this item and all its content', 'bpge');?>"><i class="fa fa-times"></i></a>
            </span>
        </li>
    <?php } ?>
</ul>