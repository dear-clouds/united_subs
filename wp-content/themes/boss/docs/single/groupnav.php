<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
    <ul>
        <?php 
        $navs = get_option( 'bboss_bpd_sg_group_navs_info' );
        $permalink = bp_get_group_permalink();
        foreach( $navs as $nav => $details ){
            $class = $nav=='docs' ? ' current selected ' : '';
            $link = trailingslashit( $permalink );
            if( $nav !='home' ){
                $link .= $nav . '/';
            }
            echo "<li id='nav-{$nav}-groups-li' class='{$class}'><a id='nav-{$nav}' href='{$link}'>{$details['name']}</a></li>";
        }
        ?>
    </ul>
</div>