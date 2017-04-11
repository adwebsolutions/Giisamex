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
define('DB_NAME', 'giisamex');

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
define('AUTH_KEY',         'u%!dg!3{@- 0WHk7jlBypyBv&9Qm9|.qnUtuI},d%j|iT3U[C @H}-<=en5T?yVF');
define('SECURE_AUTH_KEY',  'Z}q0p+g=Y?R%(;P}V_rOxz>)FOs 64V_N(q ,=(e~#,S88W^~}50YL>3(fJI@v}5');
define('LOGGED_IN_KEY',    'H8Hm>P`gj_dvMo+qIGSRU%V7C9HF<,m8|8h^GrKuZfh+>9x{3~<Cqy)qU0@,YL>O');
define('NONCE_KEY',        '@qc.R]]|Wof yu}O[9zc8(^957@bOo>El3UJ6okuK{|=lm%[3/+39DPrKHomcD--');
define('AUTH_SALT',        'iJ@;rhb;SJ|i +!$DFKEGtdRnc.sZd>iS8)rd_N_GM_Nor)J)+5_v&^EaO#$zJqR');
define('SECURE_AUTH_SALT', 'LGP$/8yXB2q^TAbI{V1[e<@](g}!HB+w{4W/qgrl?e5hY?T.k}F8n[P8:6Q{z|xC');
define('LOGGED_IN_SALT',   'ZS7=RIAY8SC& 4KA{ +Ib8BlP*@VD(QG$g&!07p9&o`qSKPI#E(ZISSfRAqat)x#');
define('NONCE_SALT',       '9,XB7A7~Y,Yx]W#_++wltLvFSBua`;aV{pMCq.@vS1oW~1w{nhlqpKF:m8Z9H=F#');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
