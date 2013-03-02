<?php

/*
 * Config file for Thingy installation.
 *
 * Unless otherwise noted, directories without leading forward slashes
 * are relative to coreDir.
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
    'modelDirs' => array(
        'classes/ThingyCore/Models/',
    ),
    'controllers' => array(
        '*' => 'ThingyCore\Controllers\Controller',
        'posts' => 'ThingyCore\Controllers\PostController',
        'login' => 'ThingyCore\Controllers\LoginController',
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
    ),
    'ignoreOnAutoload' => array(
        '/^Twig/',
    ),
);

?>