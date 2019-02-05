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
define('DB_NAME', 'techycompanydb');

/** MySQL database username */
define('DB_USER', 'techycompanyuser');

/** MySQL database password */
define('DB_PASSWORD', '=k}[md62)lP5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', 'utf8_turkish_ci');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|;Pz@xwp=D=6q/MD!EI>bezT-ct-*8;@.0:/B#6=3c;P[FKkmwjkWscvJ{Z-60UQ');
define('SECURE_AUTH_KEY',  ' R;*pdK=;N$wh{e>6*}i;7J,-Pb=9S{T?Bg;JdYaNmz.d%]V]5A)2bZqa;lkf_}#');
define('LOGGED_IN_KEY',    'UrO=+E+Bve):I Sl)]D>&wOM(^.}k?z&3.{1PC2A~;6Ep)-E8%qx79E8<-2P+Z*R');
define('NONCE_KEY',        ' p!U5k2e~|R-Z>)iJMf~{H=?TF&6=<?fiupZ8wd~`b@29-b+r]`Z(92,L`<F:5Q:');
define('AUTH_SALT',        '1/P|blzy{x}0+2]/Fy?!~,0}Zek!dfWlKN=,;9YC4y&+Q]p1MIWVbZQOe }FhZ5n');
define('SECURE_AUTH_SALT', 'Cw~nwXS^^)Oo?a5.AKf?WhMVM3 a&pB#@4`0ec>;78TF-GBnZV?hPBKtY{M :_ii');
define('LOGGED_IN_SALT',   'aha,biu6@|nE7JrCw6[@>}Js.h#qvC?C:f<0|E&z-dRV<08uJJ~M~8-.%1j_PG{z');
define('NONCE_SALT',       '+.mvHmo]=Ou smZ_A||>I|[o9 Ovt=z%/x?+=@Oh[4Hi=| {7G,~UcZ)Xmz)~UsG');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
