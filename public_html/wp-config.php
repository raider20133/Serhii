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
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '=kdlNY&A:hy7 )VrO%Pk[8BP9 vQsoYf<IjX;|qz0E!5gGqF1SAQ[41Wd3aW? sM' );
define( 'SECURE_AUTH_KEY',  '6=r!v|xJOT;EVAaxpzaeK13l66T2Kml:]O;f3oj6O5^K2mS{hh0e549k!2NGWTI9' );
define( 'LOGGED_IN_KEY',    'l_T5rrO~g.(v94F/%lbT2z62/ 5q1A`DT~OcJ157mNZ-?/qN StJp+cF7:qV}`/#' );
define( 'NONCE_KEY',        'ym[eh8q~itd03;TZ7b>@#WH|ry6s&GzUT3JG7.=>wdM[Nbt&ov<UukqxZX/GVpoY' );
define( 'AUTH_SALT',        'hwIE/Q<J9[hDlyAY:{%^C(!o(L]`0=`@a!Gda1J,TN(KS|3B^aD&} A }E5u)l9b' );
define( 'SECURE_AUTH_SALT', 'kj7OTp`~$IwK~XE~ZA_vI.+$wk*c}UV!n4VOJX>P3 v5r+G?T=+|4_,B-*Jn8aHw' );
define( 'LOGGED_IN_SALT',   '+%2Y3 %Zat8:q]1H-=<t2UDiiu4pm^7tBD2:|$/hjKF5-Ue$8;F7iF22y|[Ovz/c' );
define( 'NONCE_SALT',       'G|P7&%U*vvC%V?wQJlG;Q_yh9RnVeVkKJC}nZLl2ne>a]_P@(;vd^WyHrX (-[=^' );

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
