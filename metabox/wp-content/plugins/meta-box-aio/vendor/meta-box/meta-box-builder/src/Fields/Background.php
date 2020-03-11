<?php
namespace MBB\Fields;

class Background extends Base {
    public function register_fields() {
		unset( $this->basic['required'] );
		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
