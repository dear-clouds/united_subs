<ul id="pages-sortable">
    <?php
    foreach($pages as $page){
        echo '<li id="position_'.$page->ID.'" class="default">
                <div class="bb-field-content-wrap"><strong>' . stripslashes($page->post_title) .'</strong> <span class="bb-arrow">&rarr;</span> ' . (($page->post_status == 'publish')?__('displayed','bpge'):__('<u>not</u> displayed','bpge')) . '</div>
                <span class="items-link">
                    <a href="' . bp_get_group_permalink( $bp->groups->current_group ) . $page_slug . '/' . $page->post_name . '" class="button bb-view-button" target="_blank" title="'.__('View this page live','bpge').'"><i class="fa fa-eye"></i></a>&nbsp;
                    <a href="' . bp_get_group_permalink( $bp->groups->current_group ) . 'admin/'.$slug . '/pages-manage/?edit=' . $page->ID . '" class="button bb-edit-button" title="'.__('Change its title, content etc','bpge').'"><i class="fa fa-pencil"></i></a>&nbsp;
                    <a href="#" class="button delete_page bb-delete-button" title="'.__('Delete this item and all its content', 'bpge').'"><i class="fa fa-times"></i></a>
                </span>
            </li>';
    } ?>
</ul>