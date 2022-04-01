add_filter(
	'wp_grid_builder/blocks', function( $blocks ) {

		// 'custom_image_block' corresponds to the block slug.
		$blocks['custom_image_block'] = [
			'name'            => __( 'Custom image block', 'text-domain' ),
			'render_callback' => function() {

				// Get current post, term, or user object.
				$post  = wpgb_get_post();
				$image = get_post_meta( $post->ID, 'custom_field_name', true );

				if ( empty( $image ) ) {
					return;
				}

				$source = wp_get_attachment_image_src( $image );

				if ( empty( $source ) ) {
					return;
				}

				printf(
					'<img src="%s" width="%s" height="%s">',
					esc_url( $source[0] ),
					esc_attr( $source[1] ),
					esc_attr( $source[2] )
				);

			},
		];

		return $blocks;

	}
);
