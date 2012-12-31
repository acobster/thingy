<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Interpreter {
    
    const DEFAULT_INTERPRETER_CLASS = 'ThingyCore\Interpreter';
    const DEFAULT_CONTROLLER_CLASS = 'ThingyCore\Controllers\Controller';
        
    protected $request;
    protected $pieces;
    
    public static function create( Request $request ) {
        $class = defined( 'THINGY_INTERPRETER_CLASS')
            ? THINGY_INTERPRETER_CLASS
            : self::DEFAULT_INTERPRETER_CLASS;
            
        return new $class( $request );
    }

    /**
     * 
     * Enter description here ...
     * @param array $request
     */
    protected function Interpreter( Request $request ) {
        $this->request = $request;
    }

    public function interpret() {
        $pieces = $this->request->getPath();
        $controllerClass =
            // Get scheme from serialized array
            $this->getControllerFromPieces( $pieces, $GLOBALS['scheme'] );

        if( ! class_exists( $controllerClass) ) {
            Debug::out( "$controllerClass not found: defaulting" );
            $controllerClass = self::DEFAULT_CONTROLLER_CLASS;
        }

        $controller = new $controllerClass();
        $controller->execute( $this->pieces );
    }

    protected function getControllerFromPieces( $pieces, $stack ) {
        
        $first = $pieces[0];
        
        if( isset( $stack[$first] ) ) {
            if( is_string( $stack[$first] ) ) {
                $this->pieces = array_slice( $pieces, 1 );
                return $stack[$first];
            } else {
                return $this->getControllerFromPieces(
                    array_slice( $pieces, 1 ), $stack[$first] );
            }
        } else {
            $this->pieces = $pieces;
            return $stack['*'];
        }
    }
}

?>
