<?php
namespace MBB\Fields;

class Video extends ImageAdvanced {
	public function register_fields() {
		parent::register_fields();
		unset( $this->basic['image_size'] );
    }
}
