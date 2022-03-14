<?php 
	$product_types  = rwmb_meta( 'does_this_product_have_variations' ); 
?>
<div class="container detail-product">
	<?php if ( $product_types == "0" ): ?>
		<?php $simple_product = rwmb_meta( 'simple_product' ); ?> 
		<div class="page-layout simple-product">
			<div class="gallery-side">
				<div class="group-image">
					<?php $simple_image_ids = $simple_product['product_images'];?>
					<div class="slider slider-single">
						<?php foreach ( $simple_image_ids as $large_img ) : ?>
							<?php $large_size = RWMB_Image_Field::file_info( $large_img, ['size' => 'large'] ); ?>
							<img src="<?php echo $large_size['full_url'] ?>">
						<?php endforeach; ?>
					</div>
					<div class="slider slider-nav">
						<?php foreach ( $simple_image_ids as $thumb_img ) : ?>
							<?php $thumb_size = RWMB_Image_Field::file_info( $thumb_img, ['size' => 'thumbnail'] ); ?>
							<img src="<?php echo $thumb_size['full_url'] ?>">
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="info-detail-product">
				<h1 class="title-product"><?php the_title(); ?></h1>
				<h2 class="description-product"><p><?php the_content(); ?></p></h2>
				<div class="price-contain-group">
					<div class="price-group">
						<div class="price">
							 <?php if ($simple_product['promotional_price']): ?>
								<div class="promotional-price"><?php echo $simple_product['promotional_price'] ?></div>
								<div class="original-price"><?php echo $simple_product['original_price'] ?></div>
							<?php else: ?>
								<div class="original-price"><?php echo $simple_product['original_price'] ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="size-contain-group">
					<p class="type-size">Size:</p>
					<div class="size-group">
						<div class="info">
							<div class="list-size">
								<?php $i = 0; ?>
								<?php $values = $simple_product['size']; ?>
								<?php foreach ( $values as $value ) : ?>
									<?php $i ++; ?>
									<p class="size-name <?php if( $i == 1 ){ echo "active"; } ?>"><?php echo $value; ?></p>
								<?php endforeach;?>
							</div>
							
						</div>
					</div>
				</div>
					<?php 
						$status = isset( $simple_product['status'] ) ? $simple_product['status'] : '';
						$group  = rwmb_get_field_settings( 'simple_product' );
						foreach ( $group['fields'] as $field ) {
							if ( empty( $field['options'] ) ) {
								continue;
							}
					?>
						<?php if($field['options'][$status]): ?>
							<div class="status"><?= $field['options'][$status]; ?></div>
						<?php endif; ?>
								<?php
						}
					?>
				<button class="order-now">Order Now</button>
			</div>
		</div>
	<?php else : ?>
		<?php $variations_of_product = rwmb_meta( 'variations_of_product' ); ?> 
		<div class="page-layout grouped-product">
			<div class="gallery-side">
				<?php $i = 0; ?>
				<?php foreach ( $variations_of_product as $gallery ) : ?>
				<?php $i ++; ?>
				<div class="group-image <?php if( $i == 1 ){ echo "active"; } ?>" data-id="<?php echo $gallery['color_name'] ?>">
					<?php $variation_image_ids = $gallery['product_images'];?>
					<div class="slider slider-single">
						<?php foreach ( $variation_image_ids as $large_image ) : ?>
							<?php $large = RWMB_Image_Field::file_info( $large_image, ['size' => 'large'] ); ?>
							<img src="<?php echo $large['full_url'] ?>">
						<?php endforeach; ?>
					</div>
					<div class="slider slider-nav">
						<?php foreach ( $variation_image_ids as $thumbnail_image ) : ?>
							<?php $thumbnail = RWMB_Image_Field::file_info( $thumbnail_image, ['size' => 'thumbnail'] ); ?>
							<img src="<?php echo $thumbnail['full_url'] ?>">
						<?php endforeach; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="info-detail-product">
				<h1 class="title-product"><?php the_title(); ?></h1>
				<h2 class="description-product"><p><?php the_content(); ?></p></h2>
				<div class="color-contain-group">
					<p class="type-color">Color:</p>
					<div class="color-group">
						<?php $i = 0; ?>
						<?php foreach ( $variations_of_product as $color ) : ?>
						<?php $i ++; ?>
						<div class="color-name <?php if( $i == 1 ){ echo "active"; } ?>">
						<?php $b = 0; ?>
							<?php $variation_color = $color['color_name']; ?>
									<?php $b ++; ?>
									<a href="#<?php echo $variation_color ?>" class="color <?php echo $variation_color ?>" title="<?php echo $variation_color ?>"><?php echo $variation_color ?></a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="price-contain-group">
					<?php $j = 0; ?>
					<?php foreach ( $variations_of_product as $price ) : ?>
					<?php $j ++; ?>
					<div class="price-group <?php if( $j == 1 ){ echo "active"; } ?>" data-id="<?php echo $price['color_name'] ?>">
						<div class="price">
							 <?php if ($price['promotional_price']): ?>
								<div class="promotional-price"><?php echo $price['promotional_price'] ?></div>
								<div class="original-price"><?php echo $price['original_price'] ?></div>
							<?php else: ?>
								<div class="original-price"><?php echo $price['original_price'] ?></div>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="size-contain-group">
					<p class="type-size">Size:</p>
					<div class="size-group">
						<?php $k = 0; ?>
						<?php foreach ( $variations_of_product as $size_group ) : ?>
						<?php $k ++; ?>
						<div class="info <?php if( $k == 1 ){ echo "active"; } ?>" data-id="<?php echo $size_group['color_name'] ?>">
							<div class="list-size">
							<?php $o = 0; ?>
								<?php $values = $size_group['size']; ?>
								<?php foreach ( $values as $value ) : ?>
									<?php $o ++; ?>
									<p class="size-name <?php if( $o == 1 ){ echo "active"; } ?>"><?php echo $value; ?></p>
								<?php endforeach;?>
						   </div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="status-group">
					<?php
						foreach ( $variations_of_product as $key => $variation ) {
							$class  = $key === 0 ? ' active' : '';
							$status = isset( $variation['status'] ) ? $variation['status'] : '';
							$group  = rwmb_get_field_settings( 'variations_of_product' );
						foreach ( $group['fields'] as $field ) {
							if ( empty( $field['options'] ) ) {
								continue;
							}
					?>
						<?php if($field['options'][$status]): ?>
							<div class="status <?= $class ?>" data-id="<?= $variation['color_name'] ?>"><?= $field['options'][$status]; ?></div>
						<?php endif; ?>
						<?php
							}
						}			
					?>
				</div>
				<button class="order-now">Order Now</button>
			</div>
		</div>
<?php endif; ?>
</div>
