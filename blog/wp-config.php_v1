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
$config=require_once(dirname(__FILE__).'/../protected/config/main.php');
$DevideHost = explode("=",$config["components"]["db"]["connectionString"]);
$HostName = explode(";",$DevideHost[1]);
define('DB_NAME', $DevideHost[2]);

/** MySQL database username */
define('DB_USER', $config["components"]["db"]["username"]);

/** MySQL database password */
define('DB_PASSWORD', $config["components"]["db"]["password"]);

/** MySQL hostname */
define('DB_HOST', $HostName[0]);

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
define('AUTH_KEY',         'G0Wdj-!6#K2+:_/gr3>yGGy!|U[cB!nD>#+ o+rXD?73YDP~hnr5l | kj$#Fm.L');
define('SECURE_AUTH_KEY',  'zgF-t2Xd|Cgb9|<=B>js?$A=?n;vG=|2A-W|=qB,QwQEtY|9w1^d(5R)brt^%XVX');
define('LOGGED_IN_KEY',    'T{69M@KB:]-iZLPDSZfgW,o|#)a-7<tsvl0b_ELd:R#(7F&.jc[gad/h9|,>0vs:');
define('NONCE_KEY',        '2gU}P[1S$X*v4a.w*i`DU;+lTRa2=BCrn^%B}{,7r_zBCkR[DY{8U<m5Dgp+]gEN');
define('AUTH_SALT',        '1i(pqkB4M6!^wuE+>;^6i7!4r-BCzE^(A>Ok($<RVu|g@Rw()%!|He;T4X$-ky%q');
define('SECURE_AUTH_SALT', 'ql *ra;&<e=;se.-)NZ4EU50{%-u:NS8iK<qP}a4jAL=/<%AX%|<q:86qi=.^B_s');
define('LOGGED_IN_SALT',   'Kj1emU`.7(vCFn99Ptz$mu%XAsmJ;]{0saM!FqHUCAzB#efIbA[+Ip9<|R0s)vA@');
define('NONCE_SALT',       'A[8Scs3hbQ.:+H}oH9u4mgn6DO 4l<-ZNd I$!<^q?o[2)]sp?c:tVtsxaXm:`o-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'souwp_';

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
