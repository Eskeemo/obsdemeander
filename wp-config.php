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
define('DB_NAME', 'obsdemeander');

/** MySQL database username */
define('DB_USER', 'OBS#1');

/** MySQL database password */
define('DB_PASSWORD', 'OBS_xs@2012');

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
define('AUTH_KEY',         '0bwBy=}4Vyqdx1dJ-c285}<f(2gc|}xb7TvT?%u:2pqCU38_#TGg_f0vIHsEo~c+');
define('SECURE_AUTH_KEY',  'H>kst+9HSweW1`c;ETHg$5p^&IR=<=,OCR4bFUMugD%VW;bq|nKK{:t}3_C$/SfY');
define('LOGGED_IN_KEY',    '-?v~cI`2|a4s1Ph%M8$ YWk}X#2 ~{Pp:L?l8)fFo*j!u?VcF7Z1<@e&)ZZTv&d]');
define('NONCE_KEY',        '<2GbE++c6uTj%]E7go:>eN+@&?]i1nTr3.R@Y%OmWCRHhD?xYc_a*y*}Qc=Y|0zB');
define('AUTH_SALT',        'mv;x.0>NWxW gbL%BgpO-  3PT^[Y! }elMD(U3_H,T+U FT}Fuxx(@TVwEbQ%AS');
define('SECURE_AUTH_SALT', 'GK!:1;R&)fY|>0q=rw6sG7&+o__.Q]7H8pw,Xhky5z?rH9DHd+I[Yh3p2>-Hvdh;');
define('LOGGED_IN_SALT',   'KsvLNg!z+!Q+Rouv[dGTr]g~7I!*!ttXj@a3<xOm^+(N.7D2<>WCv(M9+40KFE}l');
define('NONCE_SALT',       ']=-38pVI}99-kgTft)?X#;RPS7!PfhLVDR1jy@|Tu-hLSj7<2xQqI+Deu5+]YF3L');

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
define('WPLANG', 'nl_NL');

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
