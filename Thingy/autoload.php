<?php

use ThingyCore\Debug;

require_once THINGY_CORE_DIR . 'doctrine/lib/Doctrine/ORM/Tools/Setup.php';

$lib = THINGY_CORE_DIR . 'doctrine/';
\Doctrine\ORM\Tools\Setup::registerAutoloadGit($lib);

function thingyAutoload($className) {
  
    // Don't load twig stuff
    if( strpos($className, 'Twig') === 0 ) {
        return;
    }
        
    // Convert backslashes to directory-friendly forward slashes
    $className = str_replace ( '\\', '/', $className );
    
    // Isolate the namespace
    $namespaceDir = dirname ( $className );
    
    // Isolate class name
    $className = basename ( $className );
    
    // The root dir of where all our classes are
    $classPath = THINGY_CORE_DIR . THINGY_SITE_DIR_CLASSES . $namespaceDir . '/';
    
    // The path of this class, relative to the root class directory:
    $classPath .= str_replace ( '_', '/', $className );
    // The containing directory, relative to the root class directory:
    $classDir = dirname ( $classPath ) . '/';
    // Just the filename:
    $fileName = basename ( $classPath );
    
    // If the class file has the same name as the directory it's in,
    // put that directory name in the path.
    $classFolder = (is_dir ( $classDir . '/' . $fileName )) ? $fileName . '/' : '';
    
    // Put it all together and dish it out...
    $filePath = $classDir . $classFolder . $fileName . '.php';
    if (file_exists ( $filePath )) {
        require $filePath;
    } else {
        Debug::out( "Shit. Could not load $filePath." );
    }
}


spl_autoload_register( 'thingyAutoload' );


?>
