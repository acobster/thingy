<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Thingy {
    
    public static $DEBUG;
    public static $DEFAULT_MODEL_DIR;
    public static $config;
    
    protected static $single;
    
    protected $request;
    protected $interpreter;
    
    public static function single( $config = false ) {
        if( empty( self::$single ) ) {
            self::$single = new Thingy( $config );
        }
        return self::$single;
    }

    protected function __construct( $config ) {
        
        $this->config = $config;
        
        self::$DEBUG = defined( 'THINGY_DEBUG' )
            ? THINGY_DEBUG
            : false;
            
        $modelPath = defined( 'THINGY_DEFAULT_MODEL_DIR' )
          ? THINGY_DEFAULT_MODEL_DIR
          : 'classes/ThingyCore/Models/';
        self::$DEFAULT_MODEL_DIR = THINGY_CORE_DIR . $modelPath;
    }
    
    public function __get( $index ) {
        if( isset( $this->config[$index] ) ) {
            return $this->config[$index];
        }
    }
    
    /**
     * The main event. Parse the request and delegate determining which 
     * controller to use to the interpreter. Execute the controller.
     */
    public function main() {
        
        // Build the request
        $this->request = Request::create();
        $this->request->initPath();
        
        // Get our method of parsing the request from config
        $this->interpreter = Interpreter::create( $this->request );
        
        // Get a shiny new controller object
        $this->interpreter->interpret();
    }
}

?>
