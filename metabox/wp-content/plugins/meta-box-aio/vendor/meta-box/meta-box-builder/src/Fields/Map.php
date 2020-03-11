<?php
namespace MBB\Fields;

class Map extends Base {
	public function register_fields() {
		$fields = [
			'std'          => [
				'type'  => 'text',
				'label' => __( 'Default location', 'meta-box-builder' ) . mbb_tooltip( __( 'Format: latitude,longitude', 'meta-box-builder' ) ),
			],
			'api_key'      => [
				'type'  => 'text',
				'label' => '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">' . __( 'Google Maps API key', 'meta-box-builder' ) . '</a><span class="required">*</span>',
			],
			'address_field' => ['type' => 'custom'],
			'language'      => ['type' => 'custom'],
			'region'        => [
				'type'  => 'text',
				'label' => '<a href="https://en.wikipedia.org/wiki/List_of_Internet_top-level_domains#Country_code_top-level_domains" target="_blank">' . __( 'Region code', 'meta-box-builder' ) . '</a>' . mbb_tooltip( __( 'The region code, specified as a country code top-level domain. This parameter returns autocompleted address results influenced by the region (typically the country) from the address field.', 'meta-box-builder' ) ),
			],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
		unset( $this->basic['required'] );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
	}
}
