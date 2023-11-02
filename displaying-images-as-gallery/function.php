function get_image_field() {
    $images = rwmb_meta( 'image_gallery', ['size' => 'large'] );    
    $html ='<div class="wrapper mb-slider">';
        $html .='<div class="carousel">';
            foreach ( $images as $image ) :
                    $html .='<img src="'.$image['url'].'">';
            endforeach ;
        $html .='</div>';
    $html .='</div>';

    return $html;
}
add_shortcode( 'brand_image', 'get_image_field' );
