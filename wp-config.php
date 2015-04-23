<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'safeway_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'b6eUGuf6Dh+,:fhS&]&avCt8rZ9ihfs+MZ%By-1N(8&F9$)ga6ELQ)l-NGoR>i%V');
define('SECURE_AUTH_KEY',  '~trF`;,WwI>]niRhwd#<F[jVUr95hT:<;W4iK@Q-eid5r5I>-zrFK+{oodK,@03%');
define('LOGGED_IN_KEY',    'TQxa^/k6&th@v(tAR)719Vi#DUE-Dx{cxc)R4Azw#qr;]3:^=F;|:H4fJN8Z#_FI');
define('NONCE_KEY',        '3l+$Jd]I~%jK+wVWB#fGM_I};1pSV^5tfQiF[nI-7er.Me>Hb(!xs}UJ<s@L3wTX');
define('AUTH_SALT',        'a>dN]H]QgU[}zR55|e~?(>w+%e[+GeOudp+M|+Ct?UU#`~FmUkq[t>=~AO&5x};i');
define('SECURE_AUTH_SALT', 'tBsi!rVFS7M+]L=:,&.X&mn/(ZBf+qL111^y-1T-[AsN|klo0C&+U$Q=fqeEYT})');
define('LOGGED_IN_SALT',   'JwjJmEp+1 B (HV|JTE-Mg(7mk~d{z{FrU2VX64:kLqCWZ,J1|&W0&F+.8MoJO~S');
define('NONCE_SALT',       '0r+/ucX;LGEWmA.+I<Gr+jo>VKpiYX[KQi@cT:l_7Ik/),|0_+9B.l0WTaBK5Il{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
