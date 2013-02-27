<?php 

namespace ThingyCore;

class Configuration extends \ArrayObject {
    
    public function __construct( $config ) {
        $this->arr = $config;
    }
    
    public function offsetGet( $index ) {
        if( isset( $this->arr[$index] ) ) {
            return $this->arr[$index];
        } else {
            Debug::error( "Attempting to access null index in config: $index" );
            return null;
        }
    }
}

?>