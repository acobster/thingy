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
        list( $controllerClass, $unconsumedPieces ) = static::parseHierarchy(
            $pieces, $GLOBALS['scheme'] );

        if( ! class_exists( $controllerClass) ) {
            Debug::out( "$controllerClass not found: defaulting" );
            $controllerClass = self::DEFAULT_CONTROLLER_CLASS;
        }

        $controller = new $controllerClass();
        $controller->execute( $unconsumedPieces );
    }

    /**
     * Parse a Thingy tree and get the most specific class/template applicable
     * to the path.
     * 
     * @param array $pieces the URI path
     * @param array $tree the Thingy tree
     * @param boolean $default the wildcard value for the current level of the
     * Thingy tree
     */
    public static function parseHierarchy( $pieces, $tree, $default = false ) {
        
        // If the current level of the tree does not specify a wildcard, and no
        // default was specified, that's bad. This should only happen at the top
        // of the heirarchy, as any recursive call will pass a default down, so
        // we can assume it's a config error.
        if( ! $default and empty( $tree['*'] ) ) {
            throw new \RunTimeException(
                'configuration error: top level wildcard not set' );
        }
        // If a wildcard is specified at this level, use it as the default
        if( ! empty( $tree['*'] ) ) {
            $default = $tree['*'];
        }

        $first = $pieces[0];
        
        if( isset( $tree[$first] ) ) {

            $node = $tree[$first];

            // A value for this level of the tree was specified.
            // Return it or recurse if it's more Thingy tree.
            if( is_string( $node ) ) {
                $pieces = array_slice( $pieces, 1 );
                return array( $node, $pieces );
            } else {
                return static::parseHierarchy(
                    array_slice( $pieces, 1 ), $node, $default );
            }

        } else {
            // Can't get any more specific, so return the default.
            return array( $default, $pieces );
        }
    }
}

?>
