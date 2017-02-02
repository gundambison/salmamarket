<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache




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
define('DB_NAME', 'salma_front');

/** MySQL database username */
define('DB_USER', 'salma_tx5r');

/** MySQL database password */
define('DB_PASSWORD', 'cca5T34d');

/** MySQL hostname */
define('DB_HOST', '93.188.164.21');

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
define('AUTH_KEY',         'tCzLJEh1iUG9hUhrmkjnOUsQxWyGWumrWPOMt8FXIlA2cIcTUlJ9Lk3H168aLyrD');
define('SECURE_AUTH_KEY',  's1zWr1zF9zk7MkhDhsQyEllIBl5jMFjxpXj9IlkEaFzlD0ewziPLmKxZwbBbsLaL');
define('LOGGED_IN_KEY',    'Jo7C2yHMm62zKw2qRwsUtv3T6i91SUYdn4175SZcKG7WLUoz6zXeEUApLjz8Mgc7');
define('NONCE_KEY',        'bkVvNhHzxRD7UlkdSDCAV6fpQ2s3OmUHInSJqrB4Jjbc4cnzP93AY5ToqO7Xv1QP');
define('AUTH_SALT',        'cPrbRHQA5onk3sS7QpFKFmWwY7O2I23vsK0C849N8RtldlyYYpmcZDNw6CXYLu1H');
define('SECURE_AUTH_SALT', 'QKK7qAzx6RCkmEMDohvJdZwhJ1SGhyTaj10dY0B7eerJh20kx4ZghDvpTLGPKv6o');
define('LOGGED_IN_SALT',   'j5GUjtjNpTyeR8SoeDAHNgcb1e6KVRMdgSI1wEyOrUPng8yLdUIt2BMuzWsOjxKC');
define('NONCE_SALT',       '1CII03VDvRAZ1M0Dy6Z2IL8MTemEOurtqD2IlWaMhvfo48VCPoshIfdnTTVf0OX0');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ysa4_';

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
