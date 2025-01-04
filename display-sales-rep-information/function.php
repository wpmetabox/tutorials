<?php
function your_sales_representative(){
	$connected = new WP_Query( [
        'relationship' => [
            'id'      => 'salesrep-to-user',
            'to'      => get_current_user_id(),
        ],
    ] );

    $html ='';
     while ( $connected->have_posts() ) :
     	$connected->the_post();
     	$id_salesrep = get_the_ID();
     	 $html  .= '<div class="mb-container"> 
            <div class="mb-content">
            	<div class="mb-your-sale">Your Sales Representative</div>
            	<div class="mb-title-sale">'. get_the_title() .'</div>
            	<img src=" '. get_the_post_thumbnail_url($id_salesrep).'" />
            	<div class="mb-phone"><b>Phone Number</b>: '.rwmb_meta( 'phone', $id_salesrep ) .'</div>
                <div class="mb-email"><b>Email</b>: '.rwmb_meta( 'email', $id_salesrep ) .'</div>
                <div class="mb-experience"><b>Years of experience</b>: '.rwmb_meta( 'years_of_experience', $id_salesrep ) .'</div>
                <div class="mb-language"><b>Language</b>: '.rwmb_meta( 'language', $id_salesrep ) .'</div>
                <div class="mb-motto"><b>Working Motto</b>: '.rwmb_meta( 'working_motto', $id_salesrep ) .'</div>
            </div>
        </div>';            
    endwhile;
    return $html;
}

add_shortcode( 'your_sales_rep', 'your_sales_representative' );
?>
