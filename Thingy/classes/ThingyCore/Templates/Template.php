<?php

namespace ThingyCore\Templates;

use ThingyCore\Debug;

abstract class Template {
    
    protected static $EXTENSION = '.html';
    protected static $DEFAULT = 'index';
  
    abstract function getOutput( array $data );
    
    public static function getFullPath( $file ) {
        $path = THINGY_CORE_DIR . THINGY_SITE_DIR_TEMPLATE . $file;
        return $path;
    }
    
    public function display( array $data, $edit = false ) {
        echo $this->getOutput($data);
    }
    
    public static function getTemplateFile( $name ) {
        $extension = defined( THINGY_TEMPLATE_EXTENSION )
            ? THINGY_TEMPLATE_EXTENSION
            : static::$EXTENSION;
        
        $path = THINGY_CORE_DIR . THINGY_SITE_DIR_TEMPLATE;
        $template = $path . $name . $extension;
        
        if( file_exists( $template ) ) {
            return $template;
        } else {
            $default = $path . static::$DEFAULT . $extension;
            Debug::error( "$template does not exist. Defaulting to $default" );
            return $default;
        }
    }
}

?>
