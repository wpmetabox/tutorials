<?php
namespace MBB\Fields;

class Switcher extends Checkbox {
	public function register_fields() {
		parent::register_fields();

		$style = '<label for="{{field.id}}_style">Style</label>
			<select ng-model="field.style" class="widefat" id="{{field.id}}_style">
				<option value="rounded">Rounded</option>
				<option value="square">Square</option>
			</select>
		';

		$fields = [
			'style' => ['type' => 'custom', 'content' => $style],
			'on_label' => [
				'type' => 'text',
				'label' => __( 'Label for ON status', 'meta-box-builder' ) . mbb_tooltip( __( 'Leave empty to use iOS style', 'meta-box-builder' ) ),
			],
			'off_label' => [
				'type' => 'text',
				'label' => __( 'Label for OFF status', 'meta-box-builder' ) . mbb_tooltip( __( 'Leave empty to use iOS style', 'meta-box-builder' ) ),
			],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
	}
}
