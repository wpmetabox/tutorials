<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Justread
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function justread_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		/* translators: %s: post author. */
		'%s <span class="author vcard"><a class="url fn n" href="%s">%s</a></span>',
		get_avatar( get_the_author_meta( 'user_email' ), 24 ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function justread_posted_on_single() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		'<span class="on">' . esc_html_x( 'on', 'post date', 'justread' ) . '</span>%s',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators: %s: post author. */
		'%s <span class="author vcard"><a class="url fn n" href="%s">%s</a></span>',
		get_avatar( get_the_author_meta( 'user_email' ), 32 ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		/* translators: %s: post title */
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'justread' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			false,
			false,
			'comments-link'
		);
	}
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function justread_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'justread' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links"><span class="cat-links__title">' . esc_html__( 'Categories', 'justread' ) . '</span>%1$s</span>', $categories_list ); // WPCS: XSS OK.
		}

		$tags_list = get_the_tag_list( '', '' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links"><span class="tags-links__title">' . esc_html__( 'Tags', 'justread' ) . '</span>%1$s</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'justread' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
