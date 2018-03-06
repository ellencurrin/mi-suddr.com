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
define('DB_NAME', 'misuddrc_sandbox_local');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Qwq,33jd}8Zz~3|EYh}{j>jp(s+h C4U^Klpdlla>a^(~t& 1PB;ZFK;KLFhiQN{');
define('SECURE_AUTH_KEY',  '^D!=nPM]3)n/;P#bQQ?z#Oz)cr!hHd#d$T~%q7jQj/1x.EjTbf*OX,yf)g8?D9u9');
define('LOGGED_IN_KEY',    'yCP{hPPm}/}@)0~nWsc8jV-ys`;4pWnn~vY^[zap,:(VN/rJ-zPa8KxGgDg@f.Ew');
define('NONCE_KEY',        'e})OP3.`+&8B+y91X;:1]zaPB$YWV|b?`vc86[gH$%VDRB^s+`)rR5W<RynI_T_t');
define('AUTH_SALT',        'i@?=aE];xljui]sxoj-1SrDUP3Z;ha+N6)}]BgMmdcH9zBpfeZbsef[np;,+i2.e');
define('SECURE_AUTH_SALT', '_*z.vW{]#Y)/0Bh3@t5`oG}68Lh0?yB7/|Iy?IthR[ARe}yqYR4sd5:lID_+L-qR');
define('LOGGED_IN_SALT',   'o=^$%Y1$^_joZM0. }}*r8gAih/`mm8=P0NJr8M!_d4C_,dI8 DXGC9]o7$]n[np');
define('NONCE_SALT',       'Oa(bF7,@U=_<yuECs`jY*;>glS.)(~<]SUP{L>xr:` 7z51(8HbwJC7.`c^&L:_5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'edo_';

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
