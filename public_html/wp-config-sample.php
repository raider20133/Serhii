<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'admin_raider' );

/** MySQL database username */
define( 'DB_USER', 'admin_raider' );

/** MySQL database password */
define( 'DB_PASSWORD', 'N4bTx7pepL' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ')#HjQi@:8wHJlmr_<+!.xy[KPZC-P52o_x|/ v[[8msP$h<P*M|{>FQOJv8j<ydL');
define('SECURE_AUTH_KEY',  'PwvMBd /;[pqP]85ym.E$(L:zNSbFOnh JH8SrRTh`2J.6t=4AP,EV)pV=_M3~uq');
define('LOGGED_IN_KEY',    '~|/Knd`_qs!ilO-Y t_XNg]U}E~ffjK@q+~rt>4<XC?A7~GPuNrD!F8qKui;{nyM');
define('NONCE_KEY',        'E~(:IHognW|VscE]MpmIEft})Isj[Cvy$H;!$hj|]BdlVaO|nTs3+pw5V>U<L_L%');
define('AUTH_SALT',        ' G)74I4M-wRj%bUwhVF36#J3$AR$=9uDRXe<l)KTh0GH7~V+f1[UuYg|N8l5<bG-');
define('SECURE_AUTH_SALT', 'qS<2n9I7Ff{:sT:^8|R_vbE{0=+*#E-WvuG*0c-2LP{S0G:vnJb.Iq`yqjwFYSw(');
define('LOGGED_IN_SALT',   'Pm^K^^z8qlvt(s[z8e$Xm.z+/@Yi(+V,;U?/KT#O[i!$5x3LywY{]_j[IoO0./dF');
define('NONCE_SALT',       'U]>*[[NCbiGjH+)*-g^O*%yBdf:wNCC@tn.O[-;K[q#v,?=C+,Y!wz2{~qS,hH_=');

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
