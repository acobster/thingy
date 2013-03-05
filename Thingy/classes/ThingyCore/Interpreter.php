<?php

namespace ThingyCore;

class Interpreter {

    protected static $blah = 0;
    
    const DEFAULT_INTERPRETER_CLASS = 'ThingyCore\Interpreter';
    const DEFAULT_CONTROLLER_CLASS = 'ThingyCore\Controllers\Controller';
        
    protected $request;
    protected static $path;
    
    public static function create() {
        $class = Thingy::single()->interpreterClass;
        return new $class( $request );
    }

    public function interpret( Request $request ) {
        $path = $request->getPath();
        list( $controllerClass, $untrodden ) = static::parseHierarchy(
            $path, Thingy::single()->controllers );

        if( ! class_exists( $controllerClass) ) {
            throw new \RunTimeException( "Bad controller: $controllerClass" );
        }

        $controller = new $controllerClass();
        $controller->execute( $untrodden );
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

        // We've somehow run out of steps on the path. Default.
        if( empty( $pieces[0] ) ) {
            return $default;
        }

        $first = $pieces[0];
        
        if( isset( $tree[$first] ) ) {

            $step = $tree[$first];

            // A value for this level of the tree was specified.
            // Return it or recurse if it's more Thingy tree.
            if( is_string( $step ) ) {
                $pieces = array_slice( $pieces, 1 );
                return array( $step, $pieces );
            } else {
                return static::parseHierarchy(
                    array_slice( $pieces, 1 ), $step, $default );
            }

        } else {
            // Can't get any more specific, so return the default.
            return array( $default, $pieces );
        }
    }
}

?>
