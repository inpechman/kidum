<?php
define('WP_CACHE', false); // Added by WP Rocket
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
define('DB_NAME', 'kidum105_wpkidum');
//define('DB_NAME', 'kidum105_wp153');

/** MySQL database username */
define('DB_USER', 'kidum105_wpkidum');
//define('DB_USER', 'kidum105_wp153');

/** MySQL database password */
define('DB_PASSWORD', 'HiLeLvErInA*#613');
//define('DB_PASSWORD', '(w-54SsPb3');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'vxtbbjifpn83qyudjklvd69anmx1zmko0ym8s9izxtkwuaenwthkrtcyrvo2jpyg');
define('SECURE_AUTH_KEY',  'bawzzbm12jko6nssz17lf3knzw19sljsuyoromtuvrsycmxmac00vz1ndywphi6m');
define('LOGGED_IN_KEY',    '8kctpoxyamxtkjykoemqfcqp93nhlcfnvqa0kyphmjtcs53sdqz8opn9nsc2nhio');
define('NONCE_KEY',        'f7ead3jqodksyhr2qglfjcfkgi1hhocuyo8ac6vqxebqef5fxb9rvtfhgqxlds8a');
define('AUTH_SALT',        '37plpjnucvf7pcdeaznhlsmpqz9etwyqi1xdrp4zoni9ppztjc8yf8esemrzqpom');
define('SECURE_AUTH_SALT', '73ypr0er7ihkofcz5niecvojsbdzixz4xo4vx17pkqyhzioswxit1scts0epffmd');
define('LOGGED_IN_SALT',   'ut2ktqtq4q0dcmp9i82dzulhujr8vsflfx6hvjm8xqk57lxny2tqi8fpscxhigm3');
define('NONCE_SALT',       'pcyiqhnrxjv32v9kgxpkqrckqzeul3fmg0s7bsxkq4v6zbref7wh7lnogxrky7zr');

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
//define('WP_DEBUG_LOG',true);
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_AUTO_UPDATE_CORE', false );
define('RELOCATE', false );
define('WP_HOME','http://www.kidum10.co.il');
define('WP_SITEURL','http://www.kidum10.co.il');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');/* define( 'WP_MEMORY_LIMIT', '512M' ); */
