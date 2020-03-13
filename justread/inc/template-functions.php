<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Justread
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function justread_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	} elseif ( justread_is_sharing_icons_enabled() ) {
		$classes[] = 'sticky-sharing';
	}

	return $classes;
}

add_filter( 'body_class', 'justread_body_classes' );

/**
 * Check if sharing icons enabled for singular pages and has icon style.
 *
 * @return bool
 */
function justread_is_sharing_icons_enabled() {
	if ( ! class_exists( 'Sharing_Service' ) ) {
		return false;
	}
	if ( ! is_singular() ) {
		return false;
	}
	$sharer  = new Sharing_Service();
	$options = $sharer->get_global_options();
	if ( 'icon' !== $options['button_style'] ) {
		return false;
	}
	return ( is_single() && in_array( 'post', $options['show'], true ) ) || ( is_page() && in_array( 'page', $options['show'], true ) );
}

/**
 * Change output of adjacent post links.
 *
 * @param  string  $output        The adjacent post link.
 * @param  string  $format        Link anchor format.
 * @param  string  $link          Link permalink format.
 * @param  WP_Post $adjacent_post The adjacent post.
 *
 * @return string
 */
function justread_adjacent_post_link( $output, $format, $link, $adjacent_post ) {
	if ( empty( $adjacent_post ) ) {
		return $output;
	}
	global $post;
	$post = $adjacent_post;
	setup_postdata( $post );

	ob_start();
	get_template_part( 'template-parts/content', 'adjacent' );
	wp_reset_postdata();

	return ob_get_clean();
}

add_filter( 'previous_post_link', 'justread_adjacent_post_link', 10, 4 );
add_filter( 'next_post_link', 'justread_adjacent_post_link', 10, 4 );

/**
 * Change excerpt length.
 *
 * @return int
 */
function justread_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 20;
}

add_filter( 'excerpt_length', 'justread_excerpt_length' );

/**
 * Change excerpt more.
 *
 * @return int
 */
function justread_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}

add_filter( 'excerpt_more', 'justread_excerpt_more' );

/**
 * Remove Category: and Tag: in the archive page title.
 *
 * @param  string $title Archive page title.
 *
 * @return string
 */
function justread_category_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	}
	if ( is_tag() ) {
		$title = single_tag_title( '', false );
	}
	return $title;
}

add_filter( 'get_the_archive_title', 'justread_category_title' );

/**
 * Change the tag could args
 *
 * @param array $args Widget parameters.
 *
 * @return mixed
 */
function justread_tag_cloud_args( $args ) {
	$args['largest']  = 1; // Largest tag.
	$args['smallest'] = 1; // Smallest tag.
	$args['unit']     = 'em'; // Tag font unit.

	return $args;
}

add_filter( 'widget_tag_cloud_args', 'justread_tag_cloud_args' );
