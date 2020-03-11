<?php
namespace MBFS;

use WP_Query;

class Dashboard {
	private $query;
	private $edit_page_atts;

	public function __construct() {
		add_shortcode( 'mb_frontend_dashboard', [ $this, 'shortcode' ] );
	}

	public function shortcode( $atts ) {
		/*
		 * Do not render the shortcode in the admin.
		 * Prevent errors with enqueue assets in Gutenberg where requests are made via REST to preload the post content.
		 */
		if ( is_admin() ) {
			return '';
		}

		$this->get_edit_page_attrs( $atts['edit_page'] );

		$atts = shortcode_atts( [
			// Meta box id.
			'id'           => $this->edit_page_atts['id'],

			// Edit page id.
			'edit_page'    => '',

			// // Post type.
			// 'post_type'    => '',

			// Add new post button text
			'add_new'      => __( 'Add New', 'mb-frontend-submission' ),

			// Delete permanently.
			'force_delete' => 'false',
		], $atts );

		ob_start();

		if ( ! is_user_logged_in() ) {
			esc_html_e( 'Please login to view the dashboard.', 'mb-frontend-submission' );
			return ob_get_clean();
		}

		$this->query_posts( $atts );
		$this->show_welcome_message( $atts );
		$this->show_user_posts( $atts );

		return ob_get_clean();
	}

	private function query_posts( $atts ) {
		$this->query = new WP_Query( [
			'author'                 => get_current_user_id(),
			'post_type'              => $this->edit_page_atts['post_type'],
			'posts_per_page'         => -1,
			'post_status'            => 'any',
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );
	}

	private function show_welcome_message( $atts ) {
		?>
		<h3><?= esc_html( sprintf( __( 'Howdie, %s!', 'mb-frontend-submission' ), wp_get_current_user()->display_name ) ) ?></h3>
		<p><?= esc_html( sprintf( __( 'You have %d posts.', 'mb-frontend-submission' ), $this->query->post_count ) ) ?></p>
		<?php
	}

	private function get_edit_page_attrs( $edit_page_id ) {
		$edit_page = get_post( $edit_page_id );
		$pattern   = get_shortcode_regex();

		if ( ! preg_match_all( '/'. $pattern .'/s', $edit_page->post_content, $matches ) || empty( $matches[2] ) || ! in_array( 'mb_frontend_form', $matches[2] ) ) {
			return;
		}

		// Get shortcode attributes.
		$key            = array_search( 'mb_frontend_form', $matches[2] );
		$shortcode_atts = explode( ' ', $matches[3][ $key ] );

		// Get only 'id' and 'post_type' attributes.
		$attributes = [
			'post_type' => 'post',
			'url'       => get_permalink( $edit_page ),
		];
		foreach ( $shortcode_atts as $attribute ) {
			$attribute = explode( '=', $attribute );

			if ( in_array( $attribute[0], ['id', 'post_type'] ) ) {
				$attributes[ $attribute[0] ] = str_replace( ['"', "'"], '', $attribute[1] );
			}
		}

		$this->edit_page_atts = $attributes;
	}

	private function show_user_posts( $atts ) {
		?>
		<a class="mbfs-add-new-post" href="<?= esc_url( $this->edit_page_atts['url'] ) ?>">
			<?= esc_html_e( $atts['add_new'], 'mb-frontend-submission' ) ?>
		</a>
		<?php

		if ( ! $this->query->have_posts() ) {
			esc_html_e( 'You currently have no posts.', 'mb-frontend-submission' );
			return;
		}
		?>
		<table class="mbfs-posts">
			<tr>
				<th><?php esc_html_e( 'Title', 'mb-frontend-submission' ) ?></th>
				<th><?php esc_html_e( 'Date', 'mb-frontend-submission' ) ?></th>
				<th><?php esc_html_e( 'Status', 'mb-frontend-submission' ) ?></th>
				<th><?php esc_html_e( 'Actions', 'mb-frontend-submission' ) ?></th>
			</tr>
			<?php while( $this->query->have_posts() ) : $this->query->the_post(); ?>
				<tr>
					<td><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></td>
					<td align="center"><?php the_time( 'Y-m-d' ) ?></td>
					<td align="center"><?= get_post_status(); ?></td>
					<td align="center" class="mbfs-actions">
						<a href="<?= esc_url( add_query_arg( 'rwmb_frontend_field_post_id', get_the_ID(), $this->edit_page_atts['url'] ) ) ?>" title="<?php esc_html_e( 'Edit', 'mb-frontend-submission' ) ?>">
							<img src="<?= MBFS_URL . 'assets/images/pencil.svg' ?>">
						</a>
						<a class="mbfs-delete" title="<?php esc_html_e( 'Delete', 'mb-frontend-submission' ) ?>">
							<img src="<?= MBFS_URL . 'assets/images/trash.svg' ?>">
						</a>
						<div class="mbfs-confirm">
							<div class="mbfs-confirm__content">
								<p><?php esc_html_e( 'Are you sure to delete this post?', 'mb-frontend-submission' ) ?></p>
								<?= do_shortcode( '[mb_frontend_form id="' . $this->edit_page_atts['id'] . '" post_id="' . get_the_ID() . '" ajax="true" allow_delete="true" force_delete="'. $atts['force_delete'] .'" only_delete="true" delete_button="' . esc_html__( 'Confirm', 'mb-frontend-submission' ) . '"]' ); ?>
								<button class="mbfs-close">&times;</button>
							</div>
						</div>
					</td>
				</tr>
			<?php endwhile ?>
		</table>
		<?php
		$this->enqueue();
	}

	private function enqueue() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/css/frontend-dashboard.css', '', '2.1.0' );
		wp_enqueue_script( 'mb-frontend-form', MBFS_URL . 'assets/js/frontend-submission.js', array( 'jquery' ), '2.1.0', true );
	}
}