<?php
/**
 * Table API class
 *
 * @package    Meta Box
 * @subpackage MB Custom Table
 */

/**
 * Class MB_Custom_Table_API
 */
class MB_Custom_Table_API {

	/**
	 * Create table, use dbDelta() function.
	 *
	 * @param string $table_name Table name without prefix.
	 * @param array  $columns    Table columns, is an array with key is column name
	 *                           and value is column structure.
	 * @param array  $keys       Table keys, is a numeric array contain key name and
	 *                           column. Example: post_name (post_name).
	 */
	public static function create( $table_name, $columns, $keys = array() ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$sql = self::get_table_schema( $table_name, $columns, $keys );
		dbDelta( $sql );
	}

	/**
	 * Get table schema.
	 *
	 * @param string $table_name Table name.
	 * @param array  $columns    Table columns, is an array with key is column name
	 *                           and value is column structure.
	 * @param array  $keys       Table keys, is a numeric array contain key name and
	 *                           column. Example: post_name (post_name).
	 *
	 * @return string
	 */
	protected static function get_table_schema( $table_name, $columns, $keys = array() ) {
		if ( ! $columns ) {
			return false;
		}

		global $wpdb;
		
		$charset_collate = $wpdb->get_charset_collate();

		$lines   = [];
		$lines[] = '`ID` bigint(20) unsigned NOT NULL';
		foreach ( $columns as $name => $value ) {
			$lines[] = "`$name` $value";
		}

		$lines[] = 'PRIMARY KEY  (`ID`)';
		foreach ( $keys as $key ) {
			$lines[] = "KEY `$key` (`$key`)";
		}

		$lines = implode( ",\n", $lines );

		$sql = "
			CREATE TABLE $table_name (
				$lines
			) $charset_collate;
		";

		return $sql;
	}
}
