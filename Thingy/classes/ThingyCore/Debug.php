<?php

namespace ThingyCore;

class Debug {
    
    const LEVEL_ERROR = 0;
    const LEVEL_DEBUG = 1;
    
    static protected $levels = array(
        self::LEVEL_DEBUG => 'Debug', 
        self::LEVEL_ERROR => 'Error', 
    );
  
    static $messages;
    
    static function out( $message, $level = self::LEVEL_DEBUG ) {
        
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
        
        if( ! empty(self::$messages) ) {
            asort( self::$messages );
//            $trace = var_export( $trace, true );
//            echo '<pre>' . $trace . '</pre>';
            echo '<div id="debugFooter"'
                . 'style="font-size:0.8em;background:#EEE;">';
            
            echo '<h1>Debug Output:</h1>';
            
            foreach( self::$messages as $level => $messages ) {
                
                $heading = self::$levels[$level];
                echo "<h2>$heading</h2><table>";
                foreach ( $messages as $message ) {
                    $trace = debug_backtrace(false);
                    $trace = $trace[1];
                    
                    echo '<tr>';
                    echo '<td>';
                    //echo $trace['file'] . ':' . $trace['line'];
                    echo '</td>';
                    echo '<td>' . $message . '</td>';
    //                echo '<td><pre>' . var_export( $trace, true ) . $message . '</pre></td>';
                    echo '</tr>';
                }
                echo '</table>';
            
            }
            
        } else {
            echo '<p>No debug info</p>';
        }
        
        echo '</div>';
    }
}

?>
