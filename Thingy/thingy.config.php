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
        'classes/ThingyCore/Models/',
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
    'cache' => array(
        'enabled' => true,
        'dir' => 'cache',
    )
);

?>