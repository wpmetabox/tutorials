<?php get_header(); ?>
<div class="content">
	<h3><a href="<?php  the_permalink() ?> " title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<p><span class="uabb-meta-date"> <?php echo get_the_date('d.m.Y'); ?> </p></h5>
	<div class="img-post">
		<div>
			<?php 
			 	$images = rwmb_meta( 'image', array( 'size' => 'full' ) );
				foreach ( $images as $image ) {
	                echo '<img src="'. $image['url']. '">';
	        	}
	        ?>
		</div>
	</div>
	<div class="infomation">
		<?php
			$investors = rwmb_meta( 'investors', '', get_the_ID() );
	        $customer = rwmb_meta( 'customer', '', get_the_ID() );
	        $description = rwmb_meta( 'description', '', get_the_ID() );
		?>
		<table>
			<tr>
				<td class="col-1">Investors</td>
				<td><?php echo $investors; ?></td>
			</tr>
			<tr>
				<td class="col-1">Customer</td>
				<td><?php echo $customer; ?></td>
			</tr>
			<tr>
				<td class="col-1">Description</td>
				<td><?php echo $description; ?></td>
			</tr>
		</table>
	</div>
</div>
<?php get_footer(); ?>