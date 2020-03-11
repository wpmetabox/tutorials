<?php
/**
 * Integrates Meta Box custom fields with FacetWP
 *
 * @package    Meta Box
 * @subpackage MB FacetWP Integrator
 */

/**
 * Integration class.
 */
class MB_FacetWP_Integrator {
	/**
	 * Indexer from FacetWP.
	 *
	 * @var FacetWP_Indexer
	 */
	protected $indexer;

	public function __construct() {
		add_filter( 'facetwp_facet_sources', array( $this, 'add_source' ) );
		add_filter( 'facetwp_indexer_post_facet', array( $this, 'index' ), 1, 2 );
	}

	/**
	 * Add Meta Box fields to the Data Sources dropdown
	 *
	 * @param array $sources Array of sources.
	 *
	 * @return array
	 */
	public function add_source( $sources ) {
		$sources['meta-box'] = array(
			'label'   => 'Meta Box',
			'choices' => array(),
			'weight'  => 5,
		);

		$fields = $this->get_fields();
		foreach ( $fields as $post_type => $list ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( ! $post_type_object ) {
				continue;
			}
			$post_type_label  = $post_type_object->labels->singular_name;
			foreach ( $list as $field ) {
				if ( in_array( $field['type'], array( 'heading', 'divider', 'custom_html', 'button' ), true ) ) {
					continue;
				}
				$field_label = $field['name'] ? $field['name'] : $field['id'];

				$sources['meta-box']['choices']["meta-box/{$field['id']}"] = "[{$post_type_label}] {$field_label}";
			}
		}

		return $sources;
	}

	/**
	 * Index Meta Box field data
	 *
	 * @param bool  $bypass Bypass default indexing.
	 * @param array $params Extra helper data.
	 *
	 * @return bool
	 */
	public function index( $bypass, $params ) {
		$this->indexer = FWP()->indexer;
		$defaults      = $params['defaults'];
		$facet         = $params['facet'];
		if ( ! isset( $facet['source'] ) || 'meta-box/' !== substr( $facet['source'], 0, 9 ) ) {
			return $bypass;
		}
		$field_id = substr( $facet['source'], 9 );
		$field    = rwmb_get_field_settings( $field_id, array(), $defaults['post_id'] );
		$value    = rwmb_get_value( $field_id, array(), $defaults['post_id'] );

		if ( $field['clone'] ) {
			foreach ( $value as $clone_value ) {
				if ( $field['multiple'] ) {
					foreach ( $clone_value as $sub_value ) {
						$this->index_field_value( $sub_value, $field, $defaults );
					}
				} else {
					$this->index_field_value( $clone_value, $field, $defaults );
				}
			}
		} else {
			if ( $field['multiple'] ) {
				foreach ( $value as $sub_value ) {
					$this->index_field_value( $sub_value, $field, $defaults );
				}
			} else {
				$this->index_field_value( $value, $field, $defaults );
			}
		}

		return $bypass;
	}

	/**
	 * Get all fields, grouped by post type.
	 *
	 * @return array
	 */
	protected function get_fields() {
		return rwmb_get_registry( 'field' )->get_by_object_type( 'post' );
	}

	/**
	 * Index field value.
	 *
	 * @param mixed $value  Field value.
	 * @param array $field  Field settings.
	 * @param array $params Extra parameters.
	 */
	protected function index_field_value( $value, $field, $params ) {
		// Choices.
		if ( in_array( $field['type'], array( 'checkbox_list', 'radio', 'select', 'select_advanced' ), true ) ) {
			$params['facet_value']         = $value;
			$params['facet_display_value'] = $field['options'][ $value ];
			$this->indexer->index_row( $params );
		} // Post
		elseif ( 'post' === $field['type'] ) {
			$post                          = get_post( $value );
			$params['facet_value']         = $value;
			$params['facet_display_value'] = $post->post_title;
			$this->indexer->index_row( $params );
		} // User.
		elseif ( 'user' === $field['type'] ) {
			$user = get_userdata( $value );
			if ( false !== $user ) {
				$params['facet_value']         = $value;
				$params['facet_display_value'] = $user->display_name;
				$this->indexer->index_row( $params );
			}
		} // Taxonomy
		elseif ( in_array( $field['type'], array( 'taxonomy', 'taxonomy_advanced' ), true ) ) {
			if ( null !== $value ) {
				$params['facet_value']         = $value->slug;
				$params['facet_display_value'] = $value->name;
				$params['term_id']             = $value->term_id;
				$this->indexer->index_row( $params );
			}
		} // Checkbox.
		elseif ( 'checkbox' === $field['type'] ) {
			$display_value                 = ( 0 < (int) $value ) ? __( 'Yes', 'mb-facet-integrator' ) : __( 'No', 'mb-facet-integrator' );
			$params['facet_value']         = $value;
			$params['facet_display_value'] = $display_value;
			$this->indexer->index_row( $params );
		} // Google Maps.
		elseif ( 'map' === $field['type'] ) {
			list( $lat, $lng ) = explode( ',', $value . ',,' );
			if ( $lat && $lng ) {
				$params['facet_value']         = "$lat,$lng";
				$params['facet_display_value'] = "$lat,$lng";
				$this->indexer->index_row( $params );
			}
		} // File, image
		elseif ( in_array( $field['type'], array(
			'file',
			'file_advanced',
			'file_upload',
			'image',
			'image_advanced',
			'image_upload',
			'plupload_image',
			'thickbox_image',
		), true ) ) {
			$params['facet_value']         = $value['ID'];
			$params['facet_display_value'] = $value['title'];
			$this->indexer->index_row( $params );
		} // Others.
		else {
			$params['facet_value']         = $value;
			$params['facet_display_value'] = apply_filters( 'facetwp_meta_box_display_value', $value, $params );
			$this->indexer->index_row( $params );
		}
	}
}
