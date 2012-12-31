<?php

/*
 * Config file for Thingy installation
 */

/*
 * DB Connection info 
 */
define('THINGY_DB_DRIVER', 'pdo_mysql');
define('THINGY_DB_HOST', 'localhost');
define('THINGY_DB_NAME', 'thingytest');
define('THINGY_DB_USER', 'coby');
define('THINGY_DB_PW', 'uL2YcVJPseU5XBBC');

define('THINGY_DB_DSN', 'mysql:dbname=thingytest;host=localhost');

define('THINGY_CORE_DIR', '/Users/acobster/Sites/Thingy/Thingy/');

define('THINGY_WEB_DIR', '~acobster/Thingy/public/');

define('THINGY_DEBUG', true);
define('THINGY_DEVEL', true);

/*
 * Define site specific directories. The following THINGY_SITE_DIR_*
 * constants MUST be defined:
 * 
 * TEMPLATE
 * CLASSES
 * 
 * THINGY_SITE_DIR_* constants are relative to WEB_ROOT_DIR
 */

// Where your templates live
define('THINGY_SITE_DIR_TEMPLATE', 'templates/default/');
// Where your classes live
define('THINGY_SITE_DIR_CLASSES', 'classes/');





/* Optional specs */

// Enable caching
//define('THINGY_CACHE', true);
// Where your cache files are stored, relative to the 
//define('THINGY_SITE_DIR_CACHE', 'cache/');
// Template engine
//define('THINGY_TEMPLATE_ENGINE', 'ThingyCore\Templates\TwigWrapper');
// Default definition of a Request
//define('THINGY_REQUEST_CLASS', 'Blah\RequestBlah');
// Default method of "interpreting" a Request into a Controller
//define('THINGY_INTERPRETER_CLASS', 'Blah\InterpreterBlah');
// Only allow logins from IPs from the whitelist file defined in 
//define('THINGY_RESTRICT_IPS', true);
//define('THINGY_LOGIN_WHITELIST', 
// The path to the IP whitelist. Relative to the core directory.
//define('THINGY_IP_WHITELIST', 'security/login_whitelist');
// Allow parent pages
define( 'THINGY_ALLOW_PARENT_PAGES', true );

$GLOBALS['scheme'] = array(
    '*' => 'ThingyCore\Controllers\Controller',
    'posts' => 'ThingyCore\Controllers\PostController',
);

$GLOBALS['connections'] = array(
    'default' => array(
        'driver'   => THINGY_DB_DRIVER,
        'user'     => THINGY_DB_USER,
        'password' => THINGY_DB_PW,
        'dbname'   => THINGY_DB_NAME,
    )
);

?>
