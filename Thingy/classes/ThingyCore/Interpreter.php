<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Interpreter {
    
    const DEFAULT_INTERPRETER_CLASS = 'ThingyCore\Interpreter';
    const DEFAULT_CONTROLLER_CLASS = 'ThingyCore\Controllers\Controller';
        
    protected $request;
    protected static $pieces;
    
    public static function create( Request $request ) {
        $class = defined( 'THINGY_INTERPRETER_CLASS')
            ? THINGY_INTERPRETER_CLASS
            : self::DEFAULT_INTERPRETER_CLASS;
            
        return new $class( $request );
    }

    /**
     * @param Request $request
     */
    protected function __construct( Request $request ) {
        $this->request = $request;
    }

    public function interpret() {
        $pieces = $this->request->getPath();
        list( $controllerClass, $pieces ) = static::parseHierarchy(
            $pieces, $GLOBALS['scheme'] );

        if( ! class_exists( $controllerClass) ) {
            Debug::out( "$controllerClass not found: defaulting" );
            $controllerClass = self::DEFAULT_CONTROLLER_CLASS;
        }

        $controller = new $controllerClass();
        $controller->execute( $pieces );
    }

    public static function parseHierarchy( $pieces, $stack ) {
        
        $first = $pieces[0];
        
        if( isset( $stack[$first] ) ) {
            if( is_string( $stack[$first] ) ) {
                $pieces = array_slice( $pieces, 1 );
                return array( $stack[$first], $pieces );
            } else {
                return static::parseHierarchy(
                    array_slice( $pieces, 1 ), $stack[$first] );
            }
        } else {
            return array( $stack['*'], $pieces );
        }
    }
}

?>
