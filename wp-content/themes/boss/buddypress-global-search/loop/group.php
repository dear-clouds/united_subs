<li class="bboss_search_item bboss_search_item_group">

    <div class="item-avatar">
        <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=full&width=70&height=70' ); ?></a>
    </div>

    <div class="item">
        <div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
        <div class="item-meta"><div class="mobile"><?php bp_group_type(); ?></div><span class="activity"><?php printf( __( 'active %s', 'boss' ), bp_get_group_last_active() ); ?></span></div>

        <div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

        <div class="item-meta">

            <?php   
            global $groups_template;
            if ( isset( $groups_template->group->total_member_count ) ) {
                 $count = (int) $groups_template->group->total_member_count;
            } else {
                 $count = 0;
            }

            $html = sprintf( _n( '<span class="count">%s</span> <span>member</span>', '<span class="count">%s</span> <span>members</span>', $count, 'boss' ), $count );

            ?>

            <span class="desktop"><?php bp_group_type(); ?>&nbsp; / </span><?php  echo $html; ?>

        </div>

        <?php do_action( 'bp_directory_groups_item' ); ?>

    </div>

    <div class="action">

        <div class="action-wrap">

            <?php do_action( 'bp_directory_groups_actions' ); ?>
        </div>

    </div>
</li>