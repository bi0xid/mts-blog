<?php
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
define('DB_NAME', 'mytinyse_secretcircle');

/** MySQL database username */
define('DB_USER', 'mytiuser');

/** MySQL database password */
define('DB_PASSWORD', 'Q2w3e4r5t');

/** MySQL hostname */
define('DB_HOST', '10.30.200.51');

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
define('AUTH_KEY',         'bN}sRuIj_+L9%3N$~z?@~ &8Q)2eP1.AGLc|+[kK!lbjGhs(`VkV-%64eJNy6Vtw');
define('SECURE_AUTH_KEY',  'SFw()hB|.O[lKgkS27~Ske,x0UI;[3V`:E{#Hj}i/P8BO(-hUvEJ:^&N80LC3-F+');
define('LOGGED_IN_KEY',    'b4XwAvoU%y~%+T2ptl]W0]%)Vo;_u[j- a_uf+%pM//nOC5-PSG1mY.M-.f|,@-r');
define('NONCE_KEY',        'Q`%[Z<Z(@Jq <0+B^-@QvP|Yn{q>`|Z_l$.+Ocmz9*57Gop9o{B~2A0ThHXv9T+4');
define('AUTH_SALT',        'Vu2Jmf+.<l[w|c^7lq:KVG>AHha}+t>yQ-Y=K3U=Nb,j-C_Yk##W@Nn}-MFEA/-[');
define('SECURE_AUTH_SALT', 'Ni4R^oJhK7C^0%LV^Nzg}ezn+u99It}|bgO),KUR5`wkG~S]o#PC(ikPVv` |(0u');
define('LOGGED_IN_SALT',   'Ua=@NnFFzvw Z6o}g[|c:!WDU?Idi8Aw$,G]w?r;1G/M,fI{<jka.w&r-,g*vMzD');
define('NONCE_SALT',       'q1j1:E>Of+$JBP?_iXii>{f)>,4hmg8h_X~x.H_Y#h_@(aZ5{bCNVm-.rhOCpnbc');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
