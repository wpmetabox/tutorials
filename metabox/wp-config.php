<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define( 'DB_NAME', 'metabox' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A]E`dX%U6GFNqcAE2d%5?}U:_!VlG m|0flS9^8F4.0IcAM[%(5-+Wtu7.o=1L7e' );
define( 'SECURE_AUTH_KEY',  '3ORt%uLLnIu4E|`JQ|fz@kFmmG^R0$~F5|nLJuThCG/yvCUm&.&H#DqC?T~R8}z2' );
define( 'LOGGED_IN_KEY',    '!*xcq/KPB{5lXL%fBJ?FqJ+)Be6jbwK7yGF-ts-o[PQL88WNj{%3 |0x(pD] h^F' );
define( 'NONCE_KEY',        'e(3Etj[DeTA9>gjJexc/Ls{IO{qy!^*O!QFqt/={F+8_zaAXZ6>na`|n;K Fy]LV' );
define( 'AUTH_SALT',        ',OUTZI1nEe2l3`Fs(HxXI%lIir4H CQMX[O~ Z>1C4iKq)?^/I39*lxs37(z/WiB' );
define( 'SECURE_AUTH_SALT', 'oq?]J`86|z`Iw}+Y`9<z?Q|GfVZk*IjT<>mYKt3-UX0ardg$KcsXqktk_d}o$5K2' );
define( 'LOGGED_IN_SALT',   '-ND8ub`B]aTcS}glj_wr);DmFV)H11]iNgCH?WQ3]Bo9p%l9t<:PLz0SkR{vsn]<' );
define( 'NONCE_SALT',       'v? 9Fj^Ndn}B&nwnmOX7{t!hEMJcI$ zap~,qf(!,$a=t}(}0J5]U[kAcvn9H@@C' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
define('SCRIPT_DEBUG', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
