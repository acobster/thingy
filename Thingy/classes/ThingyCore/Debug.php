<?php

namespace ThingyCore;

class Debug {
    
    const LEVEL_ERROR = 0;
    const LEVEL_DEBUG = 1;
    
    static protected $levels = array(
        self::LEVEL_ERROR => 'Errors',
        self::LEVEL_DEBUG => 'Debug Statements',  
    );
  
    static $messages;
    
    static function out( $message, $code = self::LEVEL_DEBUG ) {
        
        $level = static::$levels[$code];

        if( empty(self::$messages) ) {
            self::$messages = array();
        }
        if( empty( self::$messages[$level] ) )
        {
          self::$messages[$level] = array();
        }
        
        self::$messages[$level][] = $message;
    }
    
    static function dump( $object ) {
        $object = var_export( $object, true );
        self::out( "<pre>$object</pre>" );
    }
    
    static function error( $message ) {
        self::out( $message, self::LEVEL_ERROR );
    }
    
    static function writeFooter() {

        if( ! empty( static::$messages ) ) {
            asort( static::$messages );
        }

        $templateClass = thingy()->templateClass;
        $template = new $templateClass( 'debug.html' );
        $template->display( array( 'messages' => static::$messages ) );
        
    }
}

?>
