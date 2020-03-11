<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Justread
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
		<?php if ( is_sticky() ) : ?>
			<?php echo justread_get_svg( array( 'icon' => 'bookmark' ) ); // wpcs xss: ok. ?>
		<?php endif; ?>
		<div class="card__body">
			<div class="entry-content card__content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="card__footer">
				<?php justread_posted_on(); ?>
			</footer><!-- .entry-footer -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
