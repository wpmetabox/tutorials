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
		<span class="entry_address"><?php echo rwmb_meta( 'dia-chi' ); ?></span> - 
		<span class="entry_distance"><?php echo 'Cách trung tâm ' . rwmb_meta( 'khoang-cach' ); ?></span>
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
			'width'        => '640px',
			'height'       => '480px',
			'zoom'         => 14,
			'marker'       => true,
			'marker_icon'  => 'https://url_to_icon.png',
			'marker_title' => 'Click me',
			'info_window'  => '<h3>Title</h3><p>Content</p>.',
		);
		echo rwmb_meta( 'osm_dia-chi', $args );
		?>
		</div>

		<div class="hotel-amenities">
			<h2>Các tiện nghi được ưa chuộng nhất</h2>
			<?php
			rwmb_the_value( 'tien-nghi' );
			?>
		</div>

		<div class="hotel-availability">
			<h2>Phòng trống</h2>
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
					<th>Ảnh</th>
					<th>Tên phòng</th>
					<th>Phù hợp với</th>
					<th>Giá phòng/đêm</th>
					<th>Đặt trước</th>
				</thead>
				<tbody>
					<?php
					$room             = rwmb_meta( 'group_room' );
					$search_check_in  = $_POST['check-in-date'];
					$search_check_out = $_POST['check-out-date'];
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
								<b>Kích thước phòng:</b>
								<?php
								echo $value['dien-tich'];
								?>
								<div class="hotel-amenities">
									<b>Các tiện nghi trong phòng</b>
									<ul>
									<?php
									foreach ( $value['tien-nghi_g4zooy6n28n'] as $tien_nghi_phong ) {
										echo '<li>' . $tien_nghi_phong . '</li>';
									}
									?>
									</ul>
								</div>
							</td>
							<td class="so-luong">
							<?php
							echo 'Người lớn: ' . $value['so-nguoi'] . '<br>
									Trẻ em: ' . $value['so-tre-em'];
							?>
							</td>
							<td class="gia"><?php echo $value['price'] . ' $'; ?></td>
							<td class="dat-truoc"><button class="btn btn-main">Đặt ngay</button></td>
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
