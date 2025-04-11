<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_laviedesplantes' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         ']9NjR*_fPjSqLk~]yQaZY/Bbm-=)SmbO,XTWu}kZ&nGtBX&tCI+/K4bz>b;X.)Se' );
define( 'SECURE_AUTH_KEY',  '4k/G1KJ[4(Oy&1 {LcGml3[[V_%FfsKztC#}d&X;tZbZ#uNY;5NEp:l/@@Z,|tMm' );
define( 'LOGGED_IN_KEY',    'T;ca7*`ViPe*{`gsS;NiB:-%.HRucC<rx.u?X0lT5M=f-?oNKGUuV0xL0>QqB?R`' );
define( 'NONCE_KEY',        '69lSPjFL9(<34QmW.cHyC+7}p4:vB/~_UmM_QA)mPbV_C[)K>~o(#o2t*P<tvdt[' );
define( 'AUTH_SALT',        'N|]a]E_6g_yy^d>koP$_4CywX:(qnj0N,S4nyrgipIC3^B`P 8^ram(~1%yUmr2B' );
define( 'SECURE_AUTH_SALT', '/4tm><i$3%,nNR>PKo$_|4LjY x),bXsECfFWG)LS*D&CYW1T1uZWQX}J:<D4um%' );
define( 'LOGGED_IN_SALT',   'z1s1h3a!+VhaaKo~0f.g|mYgcyor=2xm1%Uv5_j:RxJLqv#2ZHMk_[WLMp;x}P=V' );
define( 'NONCE_SALT',       'G,%#6V2#rOCYB&1OslBF$o%z!)>PGn$KF3*dK1SbZiUle&76W3=h8}!A(W6O#DUc' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
