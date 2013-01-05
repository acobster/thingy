<?php

/*
 * Config file for Thingy installation
 */

$config = array(
    'coreDir' => '/Users/acobster/Sites/Thingy/Thingy/',
    'webDir' => '~acobster/Thingy/public/',
    'debug' => true,
    'environment' => 'devel',
    'db' => array(
        'default' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'thingytest',
            'user' => 'coby',
            'password' => 'uL2YcVJPseU5XBBC',
        ),
    ),
    'controllers' => array(
        '*' => 'ThingyCore\Controllers\Controller',
        'posts' => 'ThingyCore\Controllers\PostController',
    ),
    'templates' => array(
        '*'	=> 'index.html',
        'one' => array(
            '*' => 'index.html',
            'two' => array(
                '*' => 'index.html',
                'eels' => 'fancy.html',
            ),
        ),
    ),
    'allowParentPages' => true,
);

define('THINGY_DB_DRIVER', 'pdo_mysql');
define('THINGY_DB_NAME', 'thingytest');
define('THINGY_DB_USER', 'coby');
define('THINGY_DB_PW', 'uL2YcVJPseU5XBBC');

define('THINGY_CORE_DIR', '/Users/acobster/Sites/Thingy/Thingy/');

define('THINGY_WEB_DIR', '~acobster/Thingy/public/');

define('THINGY_DEBUG', true);
define('THINGY_DEVEL', true);





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

$GLOBALS['templates'] = array(
    '*'	=> 'index.html',
    'one' => array(
        '*' => 'index.html',
        'two' => array(
            '*' => 'index.html',
            'eels' => 'fancy.html',
        ),
    ),
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
