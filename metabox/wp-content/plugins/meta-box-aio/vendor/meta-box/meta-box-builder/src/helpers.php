<?php
/**
 * Get field edit content
 *
 * @param  string $type Input Type
 *
 * @return string html
 */
function mbb_get_field_edit_content( $type ) {
	if ( 'switch' === $type ) {
		$class = 'Switcher';
	} else {
		$class = str_replace( ' ', '', ucwords( str_replace( '_', ' ', $type ) ) );
	}
	$class = "MBB\Fields\\$class";
	new $class;
}

function mbb_get_attribute_content( $attribute, $param = '', $label = '', $add_button = '', $extra_params = []) {
	$attribute = str_replace( '_', '-', $attribute );

	$default_label = MBB\Attribute::has_label( $param ) ? MBB\Attribute::get_label( $param ) : str_title( $param );
	$label         = $label ?: $default_label;

	ob_start();
	include MBB_DIR . "views/attributes/$attribute.php";
	return ob_get_clean();
}

/**
 * Get post type for displaying on Meta Box Settings
 *
 * @return array Post types
 */
function mbb_get_post_types() {
	$unsupported = [
		// WordPress built-in post types.
		'revision',
		'nav_menu_item',
		'customize_changeset',
		'oembed_cache',
		'custom_css',
		'user_request',
		'wp_block',

		// Meta Box post types.
		'meta-box',
		'mb-post-type',
		'mb-taxonomy',
	];
	$post_types  = get_post_types( [], 'objects' );
	$post_types  = array_diff_key( $post_types, array_flip( $unsupported ) );
	$post_types  = array_map( function( $post_type ) {
		return [
			'slug'         => $post_type->name,
			'name'         => $post_type->labels->singular_name,
			'hierarchical' => $post_type->hierarchical,
			'block_editor' => function_exists( 'use_block_editor_for_post_type' ) && use_block_editor_for_post_type( $post_type->name ),
		];
	}, $post_types );

	return array_values( $post_types );
}

/**
 * Get taxonomies for displaying dropdown for taxonomy and taxonomy_advanced fields
 *
 * @return array
 */
function mbb_get_taxonomies() {
	$unsupported = ['link_category', 'nav_menu', 'post_format'];
	$taxonomies  = get_taxonomies( '', 'objects' );
	$taxonomies  = array_diff_key( $taxonomies, array_flip( $unsupported ) );
	$taxonomies  = array_map( function( $taxonomy ) {
		return [
			'slug'         => $taxonomy->name,
			'name'         => $taxonomy->labels->singular_name,
			'hierarchical' => $taxonomy->hierarchical,
		];
	}, $taxonomies );

	return array_values( $taxonomies );
}

function mbb_get_page_templates() {
	$templates = get_page_templates();

	return $templates;
}

function mbb_get_templates() {
	$post_types = mbb_get_post_types();

	$templates = [];
	foreach ( $post_types as $post_type ) {
		$post_type_templates = get_page_templates( null, $post_type['slug'] );
		foreach ( $post_type_templates as $name => $file ) {
			$templates[] = [
				'name'           => $name,
				'file'           => $file,
				'post_type'      => $post_type['slug'],
				'post_type_name' => $post_type['name'],
				'id'             => "{$post_type['slug']}:{$file}",
			];
		}
	}

	return $templates;
}

function mbb_get_post_formats() {
	if ( ! current_theme_supports( 'post-formats' ) ) {
		return [];
	}
	$post_formats = get_theme_support( 'post-formats' );

	return is_array( $post_formats[0] ) ? $post_formats[0] : [];
}

function mbb_get_setting_pages() {
	$pages = array();
	$settings_pages = apply_filters( 'mb_settings_pages', array() );
	foreach ( $settings_pages as $settings_page ) {
		$title = '';
		if ( ! empty( $settings_page['menu_title'] ) ) {
			$title = $settings_page['menu_title'];
		} elseif ( ! empty( $settings_page['page_title'] ) ) {
			$title = $settings_page['page_title'];
		}
		$pages[$settings_page['id']] = array(
			'id'    => $settings_page['id'],
			'title' => $title,
		);
	}
	return $pages;
}

function mbb_get_categories() {
	$categories = get_categories();

	$cats = array();

	foreach ( $categories as $cat ) {
		$cats[ $cat->term_id ] = $cat->name;
	}

	return $cats;
}

/**
 * Array of Menu item on builder GUI
 *
 * Todo: Remove it and use default field type and field value
 *
 * @return array Menu structure
 */
function mbb_get_builder_menu() {
	$menu = array(
		__( 'Basic', 'meta-box-builder' ) => [
			'button'          => __( 'Button', 'meta-box-builder' ),
			'button_group'    => __( 'Button Group', 'meta-box-builder' ),
			'checkbox'        => __( 'Checkbox', 'meta-box-builder' ),
			'checkbox_list'   => __( 'Checkbox List', 'meta-box-builder' ),
			'email'           => __( 'Email', 'meta-box-builder' ),
			'hidden'          => __( 'Hidden', 'meta-box-builder' ),
			'number'          => __( 'Number', 'meta-box-builder' ),
			'password'        => __( 'Password', 'meta-box-builder' ),
			'radio'           => __( 'Radio', 'meta-box-builder' ),
			'range'           => __( 'Range', 'meta-box-builder' ),
			'select'          => __( 'Select', 'meta-box-builder' ),
			'select_advanced' => __( 'Select Advanced', 'meta-box-builder' ),
			'text'            => __( 'Text', 'meta-box-builder' ),
			'textarea'        => __( 'Textarea', 'meta-box-builder' ),
			'url'             => __( 'URL', 'meta-box-builder' ),
		],

		__( 'Advanced', 'meta-box-builder' ) => [
			'autocomplete'  => __( 'Autocomplete', 'meta-box-builder' ),
			'background'    => __( 'Background', 'meta-box-builder' ),
			'color'         => __( 'Color Picker', 'meta-box-builder' ),
			'custom_html'   => __( 'Custom HTML', 'meta-box-builder' ),
			'date'          => __( 'Date', 'meta-box-builder' ),
			'datetime'      => __( 'Date Time', 'meta-box-builder' ),
			'fieldset_text' => __( 'Fieldset Text', 'meta-box-builder' ),
			'map'           => __( 'Google Maps', 'meta-box-builder' ),
			'key_value'     => __( 'Key Value', 'meta-box-builder' ),
			'image_select'  => __( 'Image Select', 'meta-box-builder' ),
			'oembed'        => __( 'oEmbed', 'meta-box-builder' ),
			'osm'           => __( 'Open Street Map', 'meta-box-builder' ),
			'slider'        => __( 'Slider', 'meta-box-builder' ),
			'switch'        => __( 'Switch', 'meta-box-builder' ),
			'text_list'     => __( 'Text List', 'meta-box-builder' ),
			'time'          => __( 'Time', 'meta-box-builder' ),
			'wysiwyg'       => __( 'WYSIWYG', 'meta-box-builder' ),
		],

		__( 'WordPress', 'meta-box-builder' ) => [
			'post'              => __( 'Post', 'meta-box-builder' ),
			'sidebar'           => __( 'Sidebar', 'meta-box-builder' ),
			'taxonomy'          => __( 'Taxonomy', 'meta-box-builder' ),
			'taxonomy_advanced' => __( 'Taxonomy Advanced', 'meta-box-builder' ),
			'user'              => __( 'User', 'meta-box-builder' ),
		],

		__( 'Upload', 'meta-box-builder' ) => [
			'file'           => __( 'File', 'meta-box-builder' ),
			'file_advanced'  => __( 'File Advanced', 'meta-box-builder' ),
			'file_upload'    => __( 'File Upload', 'meta-box-builder' ),
			'file_input'     => __( 'File Input', 'meta-box-builder' ),
			'image'          => __( 'Image', 'meta-box-builder' ),
			'image_advanced' => __( 'Image Advanced', 'meta-box-builder' ),
			'image_upload'   => __( 'Image Upload', 'meta-box-builder' ),
			'single_image'   => __( 'Single Image', 'meta-box-builder' ),
			'video'          => __( 'Video', 'meta-box-builder' ),
		],

		__( 'Layout', 'meta-box-builder' ) => [
			'divider' => __( 'Divider', 'meta-box-builder' ),
			'heading' => __( 'Heading', 'meta-box-builder' ),
		],
	);

	if ( mbb_is_extension_active( 'meta-box-group' ) ) {
		$menu[__( 'Layout', 'meta-box-builder' )]['group'] = __( 'Group', 'meta-box-builder' );
	}
	if ( mbb_is_extension_active( 'meta-box-tabs' ) ) {
		$menu[__( 'Layout', 'meta-box-builder' )]['tab'] = __( 'Tab', 'meta-box-builder' );
	}

	return $menu;
}

if ( ! function_exists( 'str_title' ) ) {
	/**
	 * Convert snake case or normal case to title case
	 *
	 * @param  String $str String to be convert
	 *
	 * @return String As Title
	 */
	function str_title( $str ) {
		$str = str_replace( '_', ' ', $str );

		return ucwords( $str );
	}
}

if ( ! function_exists( 'array_unflatten' ) ) {
	/**
	 * Convert flatten collection (with dot notation) to multiple dimmensionals array
	 *
	 * @param  Collection $collection Collection to be flatten
	 *
	 * @return Array
	 */
	function array_unflatten( $collection ) {
		$collection = (array) $collection;

		$output = array();

		foreach ( $collection as $key => $value ) {
			array_set( $output, $key, $value );

			if ( is_array( $value ) && ! strpos( $key, '.' ) ) {
				$nested = array_unflatten( $value );

				$output[ $key ] = $nested;
			}
		}

		return $output;
	}
}


if ( ! function_exists( 'array_set' ) ) {
	function array_set( &$array, $key, $value ) {
		if ( is_null( $key ) ) {
			return $array = $value;
		}

		// Do not parse email value.
		if ( is_email( $key ) ) {
			$array[ $key ] = $value;
			return;
		}

		$keys = explode( '.', $key );

		while ( count( $keys ) > 1 ) {
			$key = array_shift( $keys );

			// If the key doesn't exist at this depth, we will just create an empty array
			// to hold the next value, allowing us to create the arrays to hold final
			// values at the correct depth. Then we'll keep digging into the array.
			if ( ! isset( $array[ $key ] ) || ! is_array( $array[ $key ] ) ) {
				$array[ $key ] = array();
			}

			$array =& $array[ $key ];
		}

		$array[ array_shift( $keys ) ] = $value;
	}
}

if ( ! function_exists( 'ends_with' ) ) {
	/**
	 * Determine if a given string ends with a given substring.
	 *
	 * @param  string       $haystack
	 * @param  string|array $needles
	 *
	 * @return bool
	 */
	function ends_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( (string) $needle === substr( $haystack, - strlen( $needle ) ) ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Get All WP Dashicon for displaying in Tab or Tooltip
 *
 * @return Array List of WP Dashicon
 */
function mbb_get_dashicons() {
	return array(
		'admin-appearance',
		'admin-collapse',
		'admin-comments',
		'admin-generic',
		'admin-home',
		'admin-links',
		'admin-media',
		'admin-network',
		'admin-page',
		'admin-plugins',
		'admin-post',
		'admin-settings',
		'admin-site',
		'admin-tools',
		'admin-users',
		'album',
		'align-center',
		'align-left',
		'align-none',
		'align-right',
		'analytics',
		'archive',
		'arrow-down-alt2',
		'arrow-down-alt',
		'arrow-down',
		'arrow-left-alt2',
		'arrow-left-alt',
		'arrow-left',
		'arrow-right-alt2',
		'arrow-right-alt',
		'arrow-right',
		'arrow-up-alt2',
		'arrow-up-alt',
		'arrow-up',
		'art',
		'awards',
		'backup',
		'book-alt',
		'book',
		'building',
		'businessman',
		'calendar-alt',
		'calendar',
		'camera',
		'carrot',
		'cart',
		'category',
		'chart-area',
		'chart-bar',
		'chart-line',
		'chart-pie',
		'clipboard',
		'clock',
		'cloud',
		'controls-back',
		'controls-forward',
		'controls-pause',
		'controls-play',
		'controls-repeat',
		'controls-skipback',
		'controls-skipforward',
		'controls-volumeoff',
		'controls-volumeon',
		'dashboard',
		'desktop',
		'dismiss',
		'download',
		'editor-aligncenter',
		'editor-alignleft',
		'editor-alignright',
		'editor-bold',
		'editor-break',
		'editor-code',
		'editor-contract',
		'editor-customchar',
		'editor-distractionfree',
		'editor-expand',
		'editor-help',
		'editor-indent',
		'editor-insertmore',
		'editor-italic',
		'editor-justify',
		'editor-kitchensink',
		'editor-ol',
		'editor-outdent',
		'editor-paragraph',
		'editor-paste-text',
		'editor-paste-word',
		'editor-quote',
		'editor-removeformatting',
		'editor-rtl',
		'editor-spellcheck',
		'editor-strikethrough',
		'editor-textcolor',
		'editor-ul',
		'editor-underline',
		'editor-unlink',
		'editor-video',
		'edit',
		'email-alt',
		'email',
		'excerpt-view',
		'exerpt-view',
		'external',
		'facebook-alt',
		'facebook',
		'feedback',
		'flag',
		'format-aside',
		'format-audio',
		'format-chat',
		'format-gallery',
		'format-image',
		'format-links',
		'format-quote',
		'format-standard',
		'format-status',
		'format-video',
		'forms',
		'googleplus',
		'grid-view',
		'groups',
		'hammer',
		'heart',
		'id-alt',
		'id',
		'images-alt2',
		'images-alt',
		'image-crop',
		'image-flip-horizontal',
		'image-flip-vertical',
		'image-rotate-left',
		'image-rotate-right',
		'index-card',
		'info',
		'leftright',
		'lightbulb',
		'list-view',
		'location-alt',
		'location',
		'lock',
		'marker',
		'media-archive',
		'media-audio',
		'media-code',
		'media-default',
		'media-document',
		'media-interactive',
		'media-spreadsheet',
		'media-text',
		'media-video',
		'megaphone',
		'menu',
		'microphone',
		'migrate',
		'minus',
		'money',
		'nametag',
		'networking',
		'no-alt',
		'no',
		'palmtree',
		'performance',
		'phone',
		'playlist-audio',
		'playlist-video',
		'plus-alt',
		'plus',
		'portfolio',
		'post-status',
		'post-trash',
		'pressthis',
		'products',
		'randomize',
		'redo',
		'rss',
		'schedule',
		'screenoptions',
		'search',
		'share1',
		'share-alt2',
		'share-alt',
		'share',
		'shield-alt',
		'shield',
		'slides',
		'smartphone',
		'smiley',
		'sort',
		'sos',
		'star-empty',
		'star-filled',
		'star-half',
		'store',
		'tablet',
		'tagcloud',
		'tag',
		'testimonial',
		'text',
		'tickets-alt',
		'tickets',
		'translation',
		'trash',
		'twitter',
		'undo',
		'universal-access-alt',
		'universal-access',
		'update',
		'upload',
		'vault',
		'video-alt2',
		'video-alt3',
		'video-alt',
		'visibility',
		'welcome-add-page',
		'welcome-comments',
		'welcome-edit-page',
		'welcome-learn-more',
		'welcome-view-site',
		'welcome-widgets-menus',
		'welcome-write-blog',
		'wordpress-alt',
		'wordpress',
	);
}

function mbb_get_current_tab() {
	return filter_input( INPUT_GET, 'tab' ) ?: 'fields';
}

function mbb_is_extension_active( $extension ) {
	$functions = [
		'mb-blocks'                  => 'mb_blocks_load',
		'mb-comment-meta'            => 'mb_comment_meta_load',
		'mb-custom-table'            => 'mb_custom_table_load',
		'mb-frontend-submission'     => 'mb_frontend_submission_load',
		'mb-settings-page'           => 'mb_settings_page_load',
		'mb-term-meta'               => 'mb_term_meta_load',
		'mb-user-meta'               => 'mb_user_meta_load',
		'meta-box-columns'           => 'mb_columns_add_markup',
		'meta-box-conditional-logic' => 'mb_conditional_logic_load',
	];
	$classes = [
		'meta-box-group'           => 'RWMB_Group',
		'meta-box-include-exclude' => 'MB_Include_Exclude',
		'meta-box-show-hide'       => 'MB_Show_Hide',
		'meta-box-tabs'            => 'MB_Tabs',
	];

	if ( isset( $functions[ $extension ] ) ) {
		return function_exists( $functions[ $extension ] );
	}
	if ( isset( $classes[ $extension ] ) ) {
		return class_exists( $classes[ $extension ] );
	}
	return false;
}

function mbb_tooltip( $content ) {
	return '<button type="button" class="mbb-tooltip" data-tippy-content="' . esc_attr( $content ) . '"><span class="dashicons dashicons-editor-help"></span></button>';
}

/**
 * Parse post content to meta box settings array.
 * Try JSON decode first, then unserialize for backward-compatibility.
 *
 * @param  string $data Encoded post content.
 * @return array
 */
function mbb_parse_meta_box_settings( $data ) {
	$settings = json_decode( $data, true );
	return json_last_error() === JSON_ERROR_NONE ? $settings : @unserialize( $data );
}
