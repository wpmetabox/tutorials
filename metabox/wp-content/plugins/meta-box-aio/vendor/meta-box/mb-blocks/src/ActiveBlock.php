<?php
namespace MBBlocks;

class ActiveBlock {
	private static $block_name;

	public static function set_block_name( $block_name ) {
		self::$block_name = $block_name;
	}

	public static function get_block_name() {
		return self::$block_name;
	}
}