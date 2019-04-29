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
define( 'DB_NAME', 'bundl' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'aPZ@f9&d' );

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
define( 'AUTH_KEY',         '<v#7w _7>mFcc9dX)1Hqw;?mJ%9[hNTB D|GQr1]W88u2oegxL$,mB7QD6icKzR{' );
define( 'SECURE_AUTH_KEY',  '?Vhn]^5L@G]J/UlQ723-)Sm/(uD(|x8-EiL_mXVe*z0 (k#Gt5]qBr>vVfEd4k6_' );
define( 'LOGGED_IN_KEY',    'Vnto%K,Iddc9_>6bi2j )=Tf_=4XLr>5r#Y?5)jS|yOqp:RT6)OrCLmnlXOdsa2>' );
define( 'NONCE_KEY',        ' v:o<vnt[ rZ5l-dkii}$g)|~NYd@v3Aepnlu$Afdn>Zv*DxT7}zOXcbZ-$d!t)@' );
define( 'AUTH_SALT',        'rW,J<Ffb{}|QMm4pyvlbM4V@d&RUvaU9Y`OwzoD|Xu<tB^hjw}Wh/>(d2?U`y~iM' );
define( 'SECURE_AUTH_SALT', 'gen?{i}0o=x{V{%xntBCO5O#!W{a}j%H-6gS>Lql6a&E#cKP&ct[<>Jm%+$q8XgX' );
define( 'LOGGED_IN_SALT',   'Xh~WRdNG:ovi_axGTt=H&NNBrLM?_<_eTZPsMD{nv=O:e0#>NCpQ9f_1xZd]pv~>' );
define( 'NONCE_SALT',       'W0S <Z_VCt0ipo`P6Off}.A+X!D,Ghnyv#8q673?h$eS,~xaJA!EU4DA;jt T1;b' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
