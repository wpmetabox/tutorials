<?php
namespace MBB\Fields;

class Tab extends Base {
	public function register_fields() {
		$dashicons = mbb_get_dashicons();

		$select_icon = '<div class="icon-panel">';
		foreach ( $dashicons as $icon ) {
			$select_icon .= '<label class="icon-single {{active.icon == \'dashicons-' . esc_attr( $icon ) . '\'}}">
				<i class="wp-menu-image dashicons-before dashicons-' . esc_attr( $icon ) . '"></i>
				<input type="radio" ng-model="active.icon" value="dashicons-' . esc_attr( $icon ) . '" class="hidden" name="icon">
			</label>';
		}
		$select_icon .= '</div>';

		$this->basic = [
			'id'    => true,
			'label' => [
				'type' 	=> 'text',
				'label' => __( 'Label', 'meta-box-builder' ),
			],
			'icon' => [
				'type' 	=> 'text',
				'label' => __( 'Icon', 'meta-box-builder' ),
			],
			'select_icon' => [
				'type'    => 'custom',
				'content' => $select_icon,
			],
		];
	}
}
