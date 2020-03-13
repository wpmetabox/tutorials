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
		<?php if ( has_post_thumbnail() ) : ?>
			<a class="card__media" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
		<?php endif; ?>
		<div class="card__body">
			<header class="entry-header">
				<?php if ( 'post' === get_post_type() ) : ?>
					<?php
					$category = get_the_category();
					$category = reset( $category );
					?>
					<a class="cat-links card__subtitle" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endif; ?>
				<?php the_title( '<h2 class="entry-title card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-content card__content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<footer class="card__footer">
				<?php justread_posted_on(); ?>
			</footer><!-- .entry-footer -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
