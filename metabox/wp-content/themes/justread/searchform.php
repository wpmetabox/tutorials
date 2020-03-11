<?php
/**
 * The template for displaying the search form
 *
 * @package Justread
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'justread' ); ?></span>
		<input class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'justread' ); ?>" value="<?php the_search_query(); ?>" name="s" type="search">
	</label>
</form>
