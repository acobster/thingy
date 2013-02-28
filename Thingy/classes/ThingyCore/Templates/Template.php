<?php

namespace ThingyCore\Templates;

use ThingyCore\Thingy;
use ThingyCore\Debug;

abstract class Template {

    const DEFAULT_DIR = 'templates/default/';
    
    protected static $DEFAULT = 'index.html';
    
    abstract function getOutput( array $data );
    
    public static function getFullPath( $file ) {
        $path = Thingy::single()->coreDir . THINGY_SITE_DIR_TEMPLATE . $file;
        return $path;
    }
    
    public function display( array $data, $edit = false ) {
        echo $this->getOutput($data);
    }
    
    public static function getTemplateFile( $name ) {
        
        $thingy = Thingy::single();

        $path = $thingy->coreDir
            . ( isset( $thingy->templateDir )
                ? $thingy->templateDir
                : static::DEFAULT_DIR );

        $template = $path . $name;
        
        if( file_exists( $template ) ) {
            return $template;
        } else {
            $default = $path . static::$DEFAULT;
            Debug::error( "$template does not exist. Defaulting to $default" );
            return $default;
        }
    }
}

?>
