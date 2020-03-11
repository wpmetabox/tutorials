<?php
namespace MBB\Parsers;

use RWMB_Helpers_Array;

class MetaBox extends Base {
	public function parse() {
		$this->parse_boolean_values()
			->parse_numeric_values()
			->remove_angular_keys()
			->parse_location()
			->parse_block()
			->parse_custom_attributes()
			->parse_conditional_logic()
			->parse_tabs()
			->set_fields_tab()
			->parse_toggle_rules( 'showhide' )
			->parse_toggle_rules( 'includeexclude' )
			->parse_custom_table();

		if ( isset( $this->settings['fields'] ) && is_array( $this->settings['fields'] ) ) {
			$this->parse_fields( $this->settings['fields'] );
		}

		unset( $this->prefix );
		unset( $this->is_id_modified );

		$this->remove_empty_values();
	}

	private function parse_location() {
		$for = $this->for ? $this->for : 'post_types';
		unset( $this->for );

		$objects = array( 'post_types', 'taxonomies', 'settings_pages', 'user', 'comment', 'attachments' );
		foreach ( $objects as $object ) {
			if ( $for !== $object ) {
				unset( $this->$object );
			}
		}

		if ( 'post_types' !== $for ) {
			unset( $this->context );
			unset( $this->priority );
			unset( $this->style );
			unset( $this->default_hidden );
		}

		if ( in_array( $for, ['user', 'comment', 'block'], true ) ) {
			unset( $this->{$for} );
			$this->type = $for;
		}
		if ( 'attachments' === $for ) {
			$this->post_types = 'attachment';
			unset( $this->attachments );
		} else {
			unset( $this->media_modal );
		}

		if ( $this->showhide ) {
			$this->showhide = array_filter( (array) $this->showhide );
		}

		unset( $this->pages );

		return $this;
	}

	private function parse_block() {
		// Remove block settings.
		if ( 'block' !== $this->type ) {
			$params = [
				'description', 'category', 'keywords', 'supports', 'block_context',
				'icon', 'icon_type', 'icon_svg', 'icon_background', 'icon_foreground',
				'render_with', 'render_template', 'render_callback', 'render_code',
				'enqueue_style', 'enqueue_script', 'enqueue_assets'
			];
			foreach ( $params as $param ) {
				unset( $this->{$param} );
			}
			return $this;
		}

		$this->keywords = RWMB_Helpers_Array::from_csv( $this->keywords );

		// Icon.
		if ( 'dashicons' === $this->icon_type ) {
			if ( $this->icon_background || $this->icon_foreground ) {
				$this->icon = [
					'background' => $this->icon_background,
					'foreground' => $this->icon_foreground,
					'src'        => $this->icon,
				];
			}
		}
		if ( 'svg' === $this->icon_type ) {
			$this->icon = $this->icon_svg;
		}
		unset( $this->icon_svg );
		unset( $this->icon_background );
		unset( $this->icon_foreground );
		unset( $this->icon_type );

		// Render options.
		if ( 'callback' === $this->render_with ) {
			unset( $this->render_template );
		}
		if ( 'template' === $this->render_with ) {
			unset( $this->render_callback );
			$this->render_template = $this->replace_variables( $this->render_template );
		}
		if ( 'code' === $this->render_width ) {
			unset( $this->render_template );
			unset( $this->render_callback );
		}
		$this->enqueue_style = $this->replace_variables( $this->enqueue_style );
		$this->enqueue_script = $this->replace_variables( $this->enqueue_script );

		unset( $this->render_with );

		// Context.
		$this->context = $this->block_context;
		unset( $this->block_context );

		return $this;
	}

	private function parse_custom_table() {
		if ( $this->table ) {
			$this->storage_type = 'custom_table';
		}
		return $this;
	}

	private function parse_tabs() {
		$this->tabs = array();
		foreach ( $this->fields as $field ) {
			if ( empty( $field['type'] ) || 'tab' !== $field['type'] ) {
				continue;
			}

			$label = isset( $field['label'] ) ? $field['label'] : '';
			$icon  = isset( $field['icon'] ) ? $field['icon'] : '';

			$this->settings['tabs'][ $field['id'] ] = compact( 'label', 'icon' );
		}

		if ( empty( $this->tabs ) ) {
			unset( $this->tab_style );
			unset( $this->tab_wrapper );
		}

		return $this;
	}

	private function set_fields_tab() {
		$tab = ! empty( $this->settings['fields'][0]['type'] ) ? $this->settings['fields'][0]['type'] : '';
		if ( 'tab' !== $tab ) {
			return $this;
		}

		$previous_tab = 0;

		foreach ( $this->settings['fields'] as $index => $field ) {
			if ( 'tab' === $field['type'] ) {
				$previous_tab = $index;
			} else {
				$this->settings['fields'][ $index ]['tab'] = $this->settings['fields'][ $previous_tab ]['id'];
			}
		}

		return $this;
	}

	private function parse_toggle_rules( $key ) {
		if ( 'showhide' === $key ) {
			unset( $this->settings['show'], $this->settings['hide'] );
		} else {
			unset( $this->settings['include'], $this->settings['exclude'] );
		}

		if ( ! isset( $this->{$key} ) ) {
			return $this;
		}

		// Skip if users use show hide or include exclude but set it to off.
		if ( 'off' === $this->{$key}['type'] ) {
			unset( $this->{$key} );
			return $this;
		}

		$action = $this->{$key}['type'];

		$this->{$action} = $this->{$key};
		unset( $this->{$key} );

		// Todo: Check this if it compatibility with PHP7.
		unset( $this->settings[ $action ]['type'] );

		// Now we have $meta_box[$action] with raw data.
		foreach ( $this->settings[ $action ] as $key => $value ) {

			if ( empty( $value ) ) {
				continue;
			}

			if ( is_string( $value ) && strpos( $value, ',' ) !== false ) {
				$value = array_map( 'trim', explode( ',', $value ) );
			}

			$this->settings[ $action ][ $key ] = $value;
		}

		return $this;
	}

	private function parse_fields( &$fields ) {
		array_walk( $fields, array( $this, 'parse_field' ) );
		$fields = array_filter( $fields ); // Make sure to remove empty (such as empty groups) or "tab" fields.
	}

	private function parse_field( &$field ) {
		$parser = Field::from_array( $field );
		$parser->parse();
		$field = $parser->get_settings();

		if ( $this->prefix ) {
			$field['id'] = $this->prefix . $field['id'];
		}

		if ( isset( $field['fields'] ) ) {
			$this->parse_fields( $field['fields'] );
		}
	}

	private function replace_variables( $string ) {
		return strtr( $string, [
			'{{ site.path }}'  => wp_normalize_path( ABSPATH ),
			'{{ site.url }}'   => untrailingslashit( home_url( '/' ) ),
			'{{ theme.path }}' => wp_normalize_path( get_stylesheet_directory() ),
			'{{ theme.url }}'  => get_stylesheet_directory_uri(),
		] );
	}
}
