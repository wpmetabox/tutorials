<?php
namespace MBB;

/**
 * Make all functions available via function builder.function.
 *
 * @link https://inchoo.net/dev-talk/wordpress/twig-wordpress-part2/
 */
class TwigProxy {
	public function __call( $function, $arguments ) {
		return function_exists( $function ) ? call_user_func_array( $function, $arguments ) : null;
	}
}