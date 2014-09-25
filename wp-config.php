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
define('DB_NAME', 'bpdcom_tria');

/** MySQL database username */
define('DB_USER', 'bpdcom_tria');

/** MySQL database password */
define('DB_PASSWORD', 'S@2io4]64P');

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
define('AUTH_KEY',         'g25lwlkvrdn6hwnobqibfkdlklh7cnu2nalmgdobwqwybhxphjgjtcxe6jo7nljs');
define('SECURE_AUTH_KEY',  'gbc7hihyxaw2rh1lpsb4kooto0fhf7szilel1dfqtbdag4tmhxzeifmztuqfsdet');
define('LOGGED_IN_KEY',    'yncmofm5vyzmiizf35qxnix3ipwkr3pl0xoysmytolvu3kkfi5laknsecwxt6ztl');
define('NONCE_KEY',        'ths06s8tv9ydhmhhmnhfbgedivdtx1rbful2mhgr8qkzahyye281uiyuvd6r2zsi');
define('AUTH_SALT',        'asbjzubigjhr0aommkrrkcelunyt6glp3nrvauikesu8kzn709z2oxeigjxwpiqu');
define('SECURE_AUTH_SALT', 'jtasvmmpovf05pdqkgyvo59t4iveoftutem69bvh4pb3ij5ydyqp5hci2b2iqfki');
define('LOGGED_IN_SALT',   'wc0mq9iicdhkrgzb3fmaf0kx3gjzm94ec3rw7wrzsvct6l6my97x2hpn76c1cyzv');
define('NONCE_SALT',       'r2rqiw5uqxqay32ok7ruxvxjpglmi6tzkcmzk0uxghaqrdpkuplbv5zemz73yedv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tr_';

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
