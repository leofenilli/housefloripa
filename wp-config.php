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
define('DB_NAME', 'ft5_original');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('DISALLOW_FILE_EDIT', TRUE); // Sucuri Security: Fri, 21 Apr 2017 15:23:01 +0000


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'la(}<B<oTCbAZ|FxI10b,bI0,/i|8(h$YnPC)Zg.99Pil8a8CcoNr*c)O1kNzI3S');
define('SECURE_AUTH_KEY',  'tZXNd-{5#uMGiHC|@;zhC7[3i.?elw]LRo0f^M-JXGRg<,!sMvi5kfhzX>G sPDL');
define('LOGGED_IN_KEY',    '_Qs?HohKe6A|DPyQ+~9/~4]Myz|6)HJfz#V@3>Uc -1DJ#iYU EH?kR [Au+$qIh');
define('NONCE_KEY',        '*Bvx+r6I3D0@dvJl|gL85w;#ufE}HA;UW|UQAy6bG2t2O({v@F:1yrLU2Sk&]In3');
define('AUTH_SALT',        'DAHFQN!D,aT$><=L($EK9o@8e-nRa(#Du:=|YnQyyA-y?IkO&&QxWmiLd&h=T;,P');
define('SECURE_AUTH_SALT', '!u]6;uc {AMSQpXN:;Iyy8~dD-k7}V#7;lY<vep}fOLrq7}l-v)vvctUK 6]0lGv');
define('LOGGED_IN_SALT',   'u-M6.!.-##7L:IUZdc.$!6s$]5skY>u@DH2tLa:hJFgcy/@<.=u:mFCiUd<KX|,7');
define('NONCE_SALT',       '?2#Gdu-dBCmZr5?@eNp3OZS![GQhmx(gjmW[kVLv!liwq/vB2~[lrB,C*^~pO)em');

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
