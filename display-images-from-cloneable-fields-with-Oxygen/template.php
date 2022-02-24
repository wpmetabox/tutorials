<?
$group = rwmb_meta( 'brand_group', ['object_type' => 'setting'], 'brand' );
?>
<div class="brand-group">
	<?php foreach( $group as $value): ?>
		<?php
			$image = RWMB_Image_Field::file_info( $value['brand_logo_upload'], ['size' => 'thumbnail'] );
		?>
		<div class="brand-img">
			<?php  if (!empty($image)): ?>
				<img src="<?php echo $image['url']?>"/>
			<?php  elseif (!empty($value['brand_logo_url'])): ?>
				<img src="<?php echo $value['logo_url'] ?>"/>
			<?php  else: ?>
				<img src="<?php echo $image['url']?>"/>
			<?php endif; ?>
			<p class="name"><?php echo $value['brand_name'] ?></p>
		</div>
	<?php endforeach; ?>
</div>
			<p class="name"><?php echo $value['brand_name'] ?></p>
		</div>
	<?php endforeach; ?>
</div>
