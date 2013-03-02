<?php

use ThingyCore\Debug;

require_once $config['coreDir'] . 'doctrine/lib/Doctrine/ORM/Tools/Setup.php';

$lib = $config['coreDir'] . 'doctrine/';
\Doctrine\ORM\Tools\Setup::registerAutoloadGit($lib);

function thingyAutoload($className) {
  
    // ignore certain regexs specified in the config
    foreach( $GLOBALS['config']['ignoreOnAutoload'] as $expression ) {
        if( preg_match( $expression, $className ) ) {
            return;
        }
    }
    
    // All forward slashes
    $relativePath = str_replace ( '\\', '/', $className ) . '.php';
    // Put it all together and...
    $fullPath = $GLOBALS['config']['coreDir'] . "classes/$relativePath";

    // ...dish it out
    if (file_exists ( $fullPath )) {
        require $fullPath;
    } else {
        Debug::error( "Could not load $fullPath." );
    }
}


spl_autoload_register( 'thingyAutoload' );


?>
