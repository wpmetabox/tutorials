<?php 

require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

$args = array(
    'post_type' => 'booking',
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {

    $events = array();

    while( $query->have_posts() ) {  $query->the_post();

        $bookings = get_post_meta( get_the_ID(), 'group_booking', true );

        if ($bookings) {
              
            foreach ($bookings as $key => $booking) {

                $room = $booking['room'];

                $begin = $booking['check_in']; 

                $end = $booking['check_out']; 

                $e['title'] = "#".get_the_ID().' '.get_the_title($room);
                $e['start'] = $begin;
                $e['end'] =  $end;
                $e['url'] =  get_edit_post_link(get_the_ID(),'');
                $e['classNames'] = 'room-'.$room; 
                $e['allDay'] = true;

                array_push($events, $e);
            }

        }

    }

    echo json_encode($events);

}

?>