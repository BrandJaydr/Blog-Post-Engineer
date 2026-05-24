<?php



//Begin Really Simple Security key
define('RSSSL_KEY', 'l0vYYesumhMXZ5fp8iGGarcWWJMkS8o6ciC8UDSSy86cFEpRDPrunWWzTDUCkxvZ');
//END Really Simple Security key





/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u626791262_gLTn1' );

/** Database username */
define( 'DB_USER', 'u626791262_HWBxw' );

/** Database password */
define( 'DB_PASSWORD', '9R0HgRdjQb' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** Database collate type. Don't change this if in doubt. */
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
define( 'AUTH_KEY',          '~fuYk=+ CX!H&:o3 WxJvZ-<I>(QO4E90ToR]nXP?z>mm*v@V$U$/$vcd~`N%E#5' );
define( 'SECURE_AUTH_KEY',   '1dOr3GmPB2k{JmU7Xy,Q*R3;]%##GlAj)o=B2b@y8nHbD}cd=Bm2B,hj@Nv/%if9' );
define( 'LOGGED_IN_KEY',     'lSFX:QZ4.dpTGt0eUhYxrSAD^U~cf2hDHaLCIBTh}{NQMk0whx&]Y^pdIw~-MZFP' );
define( 'NONCE_KEY',         '~6;,c(=[t1qM{b|t:{{/3/dCp~L3hky|RMj^Np,!],97xUU*0OS+!C_@upnEVUNn' );
define( 'AUTH_SALT',         '{dQ{44=n<*Qux7bcm%@Th]O9LOE}Wufmvpek;vKpT)Ac5|r(W_R|%@?T#-Z6,6T)' );
define( 'SECURE_AUTH_SALT',  '/e]ChLwP(&<Xb{<WbSq@%cb~ 8R&R~95Yw+/OJay3Q>d$a_P?Ac,D2K5c~(Ie6Ff' );
define( 'LOGGED_IN_SALT',    'cyRT#dLfS%6(&928lAVE]G]?Jh}y,Lm^;?)znt5miM/[K|1BEH[ fxG.;bPulJxa' );
define( 'NONCE_SALT',        'EP7*TP|P&_AYI:<y{t}3?$;h1e;o!T}|p$R66QtB`_a,i&5&ERz=ZlQO)yJ6w?ou' );
define( 'WP_CACHE_KEY_SALT', 'hMFq}{6K#JnzW+*lz=tEOp{NN>nqdEK 8aV2+< 5{]|8eBj<:#B myS!y%{:nABk' );


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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'WP_MEMORY_LIMIT', '512M' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
