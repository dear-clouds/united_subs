<?php
/**
 * the template file to display content search result page
 * instead create a folder 'buddyboss-global-search' inside your theme, copy this file over there, and make changes there
 */
?>


<div class="bboss_search_page">
		<div class="bboss_search_results_wrapper">
		    <div id="item-nav">
                <div class="search_filters item-list-tabs no-ajax" role="navigation">
                    <ul>
                        <?php buddyboss_global_search_filters();?>
                    </ul>
                </div>
            </div>
			<div class="search_results dir-form dir-list">
				<?php buddyboss_global_search_results();?>
			</div>
		</div>
</div><!-- .bboss_search_page -->