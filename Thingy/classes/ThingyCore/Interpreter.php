<?php

namespace ThingyCore;

class Interpreter {

    protected static $blah = 0;
    
    const DEFAULT_INTERPRETER_CLASS = 'ThingyCore\Interpreter';
    const DEFAULT_CONTROLLER_CLASS = 'ThingyCore\Controllers\Controller';
        
    protected $request;
    protected static $pieces;
    
    public static function create() {
        $class = Thingy::single()->interpreterClass;
        return new $class( $request );
    }

    public function interpret( Request $request ) {
        $pieces = $request->getPath();
        list( $controllerClass, $pieces ) = static::parseHierarchy(
            $pieces, Thingy::single()->controllers );

        if( ! class_exists( $controllerClass) ) {
            throw new RunTimeException( "Bad controller: $contollerClass" );
        }

        $controller = new $controllerClass();
        $controller->execute( $pieces );
    }

    public function parseHierarchy( $pieces, $stack ) {
        
        Debug::out( self::$blah ); self::$blah++;
        Debug::dump( $pieces );

        // get the 
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
