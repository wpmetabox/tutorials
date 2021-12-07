<?php
    $terms= get_the_terms( $post->ID, 'portfolio-type');
    $background_image = get_term_meta( $terms[0]->term_id, 'upload_portfolio_thumbnail', true );
    if ($background_image) {
        $link_image = wp_get_attachment_image_src( $background_image, 'full' );
        $link_image_source = $link_image[0];
    }
    else {
        $link_image_source = get_term_meta( $terms[0]->term_id, 'url_portfolio_thumbnail', true );
    }
    if ( !empty( $terms ) ){
        $term = array_shift( $terms );
    }
?>
<div class="port-thumbnail">
    <img class="thumbnail-cat" src="<?php echo $link_image_source ?>">
</div>
<div class="portfolio-heading"><?php echo $term->name; ?></div>
<div class="portfolio-description"><?php echo category_description(the_category_id()); ?> </div>
