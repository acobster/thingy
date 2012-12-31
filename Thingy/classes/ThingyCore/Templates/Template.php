<?php

namespace ThingyCore\Templates;

use ThingyCore\Debug;

abstract class Template {
    
    protected static $DEFAULT = 'index.html';
    
    abstract function getOutput( array $data );
    
    public static function getFullPath( $file ) {
        $path = THINGY_CORE_DIR . THINGY_SITE_DIR_TEMPLATE . $file;
        return $path;
    }
    
    public function display( array $data, $edit = false ) {
        echo $this->getOutput($data);
    }
    
    public static function getTemplateFile( $name ) {
        
        $path = THINGY_CORE_DIR . 'templates/default/';
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
