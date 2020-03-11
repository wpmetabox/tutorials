<?php
namespace MBB\Fields;

class ImageAdvanced extends Base {
	public function register_fields() {
		$fields = [
			'max_file_uploads' => ['type' => 'number', 'label' => __( 'Maximum number of files', 'meta-box-builder' ) ],
			'image_size'       => ['type' => 'custom'],
			'max_status'       => ['type' => 'checkbox'],
			'force_delete'     => ['type' => 'checkbox'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
	}
}
