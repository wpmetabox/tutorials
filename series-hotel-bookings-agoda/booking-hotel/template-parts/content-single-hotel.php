<?php
/**
 * Template part for displaying single posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Justread
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<span class="show_map_icon"></span>
		<span class="entry_address"><?php echo rwmb_meta( 'address' ); ?></span> -
		<span class="entry_distance"><?php echo 'Distance to center ' . rwmb_meta( 'distance' ); ?></span>
	</header><!-- .entry-header -->

	<div class="entry-body">
		<div class="gallery-side-reviews-wrapper">
		<?php
		$images = rwmb_meta( 'gallery-images', array( 'size' => 'full' ) );
		foreach ( $images as $image ) {
			echo '<a href="', $image['full_url'], '"><img src="', $image['url'], '"></a>';
		}
		?>
		</div>
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'justread' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

		<div class="hotel-address">
		<?php
		$args = array(
			'zoom'   => 14,
			'marker' => true,
		);
		echo rwmb_meta( 'osm_address', $args );
		?>
		</div>

		<div class="hotel-amenities">
			<h2>The most popular facilities</h2>
			<?php
			rwmb_the_value( 'facilities' );
			?>
		</div>

		<div class="hotel-availability">
			<h2>Check availability</h2>
			<?php
			$value_checkin  = isset( $_POST['check-in-date'] ) ? $_POST['check-in-date'] : '';
			$value_checkout = isset( $_POST['check-out-date'] ) ? $_POST['check-out-date'] : '';
			?>
			<form id="hotel-availform" method="POST" style="margin-bottom: 30px;">
				<div class="filter-hotel">
					<input class="date-check check-in-date" value="<?php echo $value_checkin; ?>" id="" type="" name="check-in-date" placeholder="Check-in date">
					<input class="date-check check-out-date" value="<?php echo $value_checkout; ?>" id="" type="" name="check-out-date" placeholder="Check-out date">
					<input class="filter-action" type="submit" name="" value="Check availability">
				</div>
			</form>
			<table>
				<thead>
					<th>Images</th>
					<th>Room name</th>
					<th>Suitable</th>
					<th>Price per night</th>
					<th>Book</th>
				</thead>
				<tbody>
					<?php
					$room             = rwmb_meta( 'group_room' );
					$search_check_in  = isset( $_POST['check-in-date'] ) ? $_POST['check-in-date'] : '';
					$search_check_out = isset( $_POST['check-out-date'] ) ? $_POST['check-out-date'] : '';
					foreach ( $room as $key => $value ) :
						// var_dump($value);
						$room_date_check_in  = $value['date_check_in'];
						$room_date_check_out = $value['date_check_out'];
						if ( ( strtotime( $room_date_check_in ) > strtotime( $search_check_in ) && strtotime( $room_date_check_in ) >= strtotime( $search_check_out ) ) ||
							( strtotime( $room_date_check_out ) <= strtotime( $search_check_in ) && strtotime( $room_date_check_out ) < strtotime( $search_check_out ) ) ) :

						?>
						<tr>
							<td class="image-room">
								<div class="gallery-side-popup">
								<?php
								foreach ( $value['gallery-images-room'] as $image ) {
									$img_url_full = wp_get_attachment_image_src( $image, 'full', false );
									$img_url_small = wp_get_attachment_image_src( $image, 'thumbnail', false );
									?>
									<a href="<?php echo $img_url_full[0]; ?>"><img src="<?php echo $img_url_small[0]; ?>"></a>
									<?php
								}
								?>
								</div>
							</td>
							<td class="thong-tin-phong">
								<span><a class="ten-phong" href="#<?php echo $key ?>"><?php echo $value['room_name']; ?></a></span>
								<br>
								<b>Total area:</b>
								<?php
								echo $value['room-area'];
								?>
								<div class="hotel-amenities">
									<b>Facilities</b>
									<ul>
									<?php
									foreach ( $value['room_facilities'] as $room_facilities ) {
										echo '<li>' . $room_facilities . '</li>';
									}
									?>
									</ul>
								</div>
							</td>
							<td class="so-luong">
							<?php
							echo 'Adults: ' . $value['adults'] . '<br>
									Children: ' . $value['children'];
							?>
							</td>
							<td class="gia"><?php echo $value['price'] . ' $'; ?></td>
							<td class="dat-truoc">
								<button class="btn btn-main">Book</button>
								<p style="line-height: 1.4; margin-top: 20px; color: #ff3131;"><?php echo 'Our last ' . $value['our_last_room'] . ' rooms'; ?></p>
							</td>
						</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<footer class="entry-footer">
			<?php justread_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
