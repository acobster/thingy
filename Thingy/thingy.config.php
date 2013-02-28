<?php

/*
 * Config file for Thingy installation
 */

$config = array(
    'debug' => true,
    'devel' => true,
    'coreDir' => '/Users/acobster/Sites/thingy/thingy/',
    'webDir' => '/Users/acobster/Sites/thingy/public/',
    'db' => array(
        'default' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'thingytest',
            'user' => 'coby',
            'password' => 'uL2YcVJPseU5XBBC',
        ),
    ),
    // paths are relative to coreDir 
    'modelDirs' => array(
        'Models/',
    ),
    'controllers' => array(
        '*' => 'ThingyCore\Controllers\Controller',
        'posts' => 'ThingyCore\Controllers\PostController',
    ),
    'templates' => array(
        '*'	=> 'index.html',
        'one' => array(
            'two' => array(
                'eels' => 'fancy.html',
            ),
        ),
    ),
    'templateEngine' => 'ThingyCore\Templates\TwigWrapper',
    'requestClass' => 'ThingyCore\Request',
    'interpreterClass' => 'ThingyCore\Interpreter',
    'enableParentPages' => true,
);


define('THINGY_DEBUG', true);


/* Optional specs */

// Enable caching
//define('THINGY_CACHE', true);
// Where your cache files are stored, relative to the 
//define('THINGY_SITE_DIR_CACHE', 'cache/');
// Default definition of a Request
//define('THINGY_REQUEST_CLASS', 'Blah\RequestBlah');
// Default method of "interpreting" a Request into a Controller
//define('THINGY_INTERPRETER_CLASS', 'Blah\InterpreterBlah');
// Only allow logins from IPs from the whitelist file defined in 
//define('THINGY_RESTRICT_IPS', true);
//define('THINGY_LOGIN_WHITELIST', 
// The path to the IP whitelist. Relative to the core directory.
//define('THINGY_IP_WHITELIST', 'security/login_whitelist');


?>
