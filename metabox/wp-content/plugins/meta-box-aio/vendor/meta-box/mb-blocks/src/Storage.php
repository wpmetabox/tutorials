<?php
namespace MBBlocks;

class Storage {
	private $data;

	public function set_data( $data ) {
		$this->data = $data;
	}

	public function get( $object_id, $name, $args = [] ) {
		return isset( $this->data[$name] ) ? $this->data[$name] : false;
	}
}