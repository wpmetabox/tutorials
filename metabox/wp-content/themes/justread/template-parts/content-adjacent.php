<?php
/**
 * Template part for adjacent posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Justread
 */

?>

<article class="adjacent">
	<div class="card">
		<?php if ( has_post_thumbnail() ) : ?>
			<a class="card__media" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'justread-adjacent' ); ?>
			</a>
		<?php endif; ?>
		<div class="card__body">
			<header class="card__header">
				<?php if ( 'post' === get_post_type() ) : ?>
					<?php
					$category = get_the_category();
					$category = reset( $category );
					?>
					<a class="card__subtitle" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endif; ?>
				<?php the_title( '<h3 class="card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
			</header>

			<div class="card__content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</div>
	</div>
</article>
