<li class="bboss_search_item bboss_search_item_post">
    <header>
        <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'boss' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h3>
    </header><!-- .entry-header -->

    <div class="entry-meta mobile">
        <?php buddyboss_entry_meta(false); ?>
    </div>

    <div class="entry-content entry-summary">

        <footer class="entry-meta table">

            <div class="table-cell desktop">
            <?php buddyboss_entry_meta(); ?>
            </div>     

            <div class="mobile">
            <?php buddyboss_entry_meta(true,false,false); ?>
            </div>

        </footer><!-- .entry-meta -->

    </div><!-- .entry-content -->
</li>