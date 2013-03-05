<?php

/*
 * Config file for Thingy installation.
 *
 * Unless otherwise noted, directories without leading forward slashes
 * are relative to coreDir.
 */

$config = array(
    'debug' => true,
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
);

?>