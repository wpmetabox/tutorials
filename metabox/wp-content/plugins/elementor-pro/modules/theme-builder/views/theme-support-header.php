<?php
use ElementorPro\Modules\ThemeBuilder\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$location_manager = Module::instance()->get_locations_manager();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title>
			<?php echo wp_get_document_title(); ?>
		</title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php $location_manager->do_location( 'header' ); ?>
