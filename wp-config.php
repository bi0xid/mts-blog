<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

define('COOKIE_DOMAIN', false); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
 //Added by WP-Cache Manager
 //Added by WP-Cache Manager

# mysql -umytiuser -p -h10.30.200.51
define('FORCE_SSL_ADMIN', false);

#define('FORCE_SSL_LOGIN', true);

define('DB_NAME', getenv('WP_DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('WP_DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('WP_DB_PASS'));

/** MySQL hostname */
define('DB_HOST', getenv('WP_DB_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('DISABLE_WP_CRON', 'true');
define('WP_MEMORY_LIMIT', '1024M');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'yue6ool5wwnbp68cqqtw7qfhjd9fmycaxlm2wsaigqpn0urynabhqcigzjrglrpt');
define('SECURE_AUTH_KEY',  'ytw3oie6holjlcnk7c3krkrwyfkjcrm1mlmbqpg4773vopavtmpxonr0fepblmsc');
define('LOGGED_IN_KEY',    'dcr5xhim3kxgrt06zq816ndahdqgan1uejptreppbv9xobztbuyoxkwvkrjzeol3');
define('NONCE_KEY',        'psodx7zatifpu6kvlijch9ki97wd798bidull7cfx1v1m8arowls2x9rc2qiuq71');
define('AUTH_SALT',        '8uamdxzs32sxb8ldukunysuqwcm29f9nbcun5a9efegqjp1ietdmy1mqzkmll19x');
define('SECURE_AUTH_SALT', 'z3a07nno3zhnrvytizvfdknwg30wlqcubg44v1wkpij9nnkijlcsq5fjz3bebahz');
define('LOGGED_IN_SALT',   'd3spzgnpyejv5ixl9t6wwfga6r079cgunzxxqryzhgddi6rprgtkfc9dw4hfkehv');
define('NONCE_SALT',       'zamdjnnfpfwfhccwqxvfpsdo4qdfrzok5l4w3gebvpnnoeq2bf118q7h1oe3gmr5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
#error_reporting(E_ALL); ini_set('display_errors', 1);
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
