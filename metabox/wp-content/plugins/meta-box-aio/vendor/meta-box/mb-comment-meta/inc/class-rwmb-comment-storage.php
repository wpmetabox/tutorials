<?php
/**
 * Comment storage
 *
 * @package    Meta Box
 * @subpackage MB Comment Meta
 */

if ( class_exists( 'RWMB_Base_Storage' ) ) {
	/**
	 * Class RWMB_Comment_Storage
	 */
	class RWMB_Comment_Storage extends RWMB_Base_Storage {
		/**
		 * Object type.
		 *
		 * @var string
		 */
		protected $object_type = 'comment';
	}
}
