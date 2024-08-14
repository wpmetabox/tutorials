<?php
/**
 * Title: Related events
 * Slug: twentytwentyfour/related-events
 * Inserter: no
 */
?>

<h2 style="font-weight:bold;">Related Events</h2>

<?php

$current_id = get_the_ID();
$connected = new WP_Query( [
    'relationship' => [
        'id'      => 'event-to-artist',
        'from'      => get_the_ID(),
    ],
] );

$atist_related = [];
while ( $connected->have_posts() ) : 
	$connected->the_post(); 
	$atist_related[] = get_the_ID();
endwhile;

$events_related = [];
foreach ( $atist_related as $id_atist ) :
	$connected1 = new WP_Query( [
	    'relationship' => [
	        'id'      => 'event-to-artist',
	        'to'      => $id_atist,
	    ],
	] );
	while ( $connected1->have_posts() ) : 
		$connected1->the_post();
		
	    $events_related [get_the_ID()] = get_the_title();
	endwhile;
endforeach;

unset($events_related[$current_id]);?>

<?php foreach ( $events_related as $key => $value ) : ?>
	<li><a href="<?php the_permalink($key); ?>"><?php echo $value; ?></a></li>
<?php endforeach;?>
