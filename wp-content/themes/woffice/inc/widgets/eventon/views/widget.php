<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo $before_widget;

echo $title;
?>
	<!-- WIDGET -->
	<ul class="list-styled list-events">
		<?php 
			// GET EVENTON POSTS
			$widget_eventon_query = new WP_Query(array(
                'post_type' => 'ajde_events',
                'showposts' => -1,
                'meta_key' => 'evcal_srow',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            ));
            
            $loop_number = 0;

			if ( $widget_eventon_query->have_posts() ) {
                $events = array();
				while($widget_eventon_query->have_posts() && $loop_number <= $show) : $widget_eventon_query->the_post();
                    //Get start date
                    $start_date_timestamp = get_post_meta(get_the_ID(), 'evcal_srow');

                    //Check if the event is recurring
                    $repeat_intervals = get_post_meta(get_the_ID(), 'repeat_intervals');

                    //If the event is recurring, then check the next closer date
                    if(!empty($repeat_intervals)) {
                        $repeat_intervals = array_reverse($repeat_intervals[0]);
                        $available = false;
                        $i = 0;
                        while($repeat_intervals[$i][0] > time()) {
                            $available = $repeat_intervals[$i][0];
                            $i++;
                        }

                        if(!empty($available))
                            $start_date_timestamp[0] = $available;
                    }


                    //Check if start date is a past date
                    if($start_date_timestamp[0] > time()) {

                        $events[$start_date_timestamp[0]] = '<li><a href="'. get_the_permalink() .'" rel="bookmark">' . get_the_title() . '</a>' . ' - ' . date('d M', $start_date_timestamp[0]) . '</li>';
                    
						$loop_number++;
						
                    }

				endwhile;


                if(empty($events)) {
                    _e("No events found...","woffice");
                } else {
                    //Sort the events, this is necessary cause the recurring events
                    ksort($events);
                    foreach($events as $event)
                        echo $event;
                }

			} 
			else{
				_e("No events found...","woffice");
			}
			wp_reset_postdata();
		?>
	</ul>
<?php echo $after_widget ?>