<?php
define('WP_CACHE', false); // By Speed Optimizer by SiteGround

define('WP_ENVIRONMENT_TYPE', 'local');
define('VITE_DEV_SERVER_URL', 'http://localhost:5173');
define('GOOGLE_MAPS_API_KEY', '');

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
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default)
	{
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		} else if (($val = getenv($env)) !== false) {
			return $val;
		} else {
			return $default;
		}
	}
}



// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

// Development
define('DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'worthingaccomodationv2'));
define('DB_USER', getenv_docker('WORDPRESS_DB_USER', 'root'));
define('DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'root'));

// LIVE
// define('DB_NAME', 'dbuu7ygkawk4s9');
// define('DB_USER', 'uo6s5qt3jjxbg');
// define('DB_PASSWORD', 'geigulniabuv');






/**
 * Docker image fallback values above are sourced from the official WordPress installation wizard:
 * https://github.com/WordPress/WordPress/blob/1356f6537220ffdc32b9dad2a6cdbe2d010b7a88/wp-admin/setup-config.php#L224-L238
 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)
 */

/** Database hostname */
define('DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'localhost'));

/** Database charset to use in creating database tables. */
define('DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8'));


define('DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', ''));

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
define('AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         '2bd1c49dda6e3842b444d2e3fbe614f31f9f46cd'));
define('SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  '1832a21506a5e8cfcbb51317349c971194406752'));
define('LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    '482d17d564226bfc159e08fd6b45eb1ab1bc9f6e'));
define('NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'e238071a7d42390c75d0ad9d407a46b74dfca2ce'));
define('AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '89fb0351f1faf9fb0db26b8dd6549d3c87657571'));
define('SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'fe7dd062e9cc3296ece7bdebcc5c976818454e08'));
define('LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'f8fe792e9abb2424018bd7ba5b1ffaa89d450866'));
define('NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'b0fc0d75b8d3eaeb2330873a2595c08e0b23bd8c'));
// (See also https://wordpress.stackexchange.com/a/152905/199287)

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'ps_');

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', false));

/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
