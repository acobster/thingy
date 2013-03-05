<?php

require $config['coreDir'] . 'classes/ThingyCore/Thingy.php'; 

require_once $config['coreDir'] . 'doctrine/lib/Doctrine/ORM/Tools/Setup.php';

use ThingyCore\Debug;

$lib = $config['coreDir'] . 'doctrine/';
\Doctrine\ORM\Tools\Setup::registerAutoloadGit($lib);

/**
 * Autoload a fully-qualified class
 * @param  string $className the fully-qualified class name
 * @return void
 */
function thingyAutoload($className) {

    // ignore certain regexs specified in the config
    foreach( thingy()->ignoreOnAutoload as $expression ) {
        if( preg_match( $expression, $className ) ) {
            return;
        }
    }
    
    // All forward slashes
    $relativePath = str_replace ( '\\', '/', $className ) . '.php';
    // Put it all together and...
    $fullPath = thingy()->coreDir . "classes/$relativePath";

    // ...dish it out
    if (file_exists ( $fullPath )) {
        require $fullPath;
    } else {
        Debug::error( "Could not load $fullPath." );
    }
}

spl_autoload_register( 'thingyAutoload' );

/**
 * Get the Thingleton
 * @return ThingyCore\Thingy the Thingy singleton, or "Thingleton"
 */
function thingy() {
    return ThingyCore\Thingy::single();
}


?>
