<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Thingy {

    const DEFAULT_TEMPLATE_ENGINE = 'ThingyCore\Templates\TwigWrapper';
    
    public static $DEBUG;
    public static $DEFAULT_MODEL_DIR;
    
    public $config;
    
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
        $this->templateClass = isset( $this->config['templateClass'] )
            ? $this->config['templateClass']
            : self::DEFAULT_TEMPLATE_ENGINE;
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

        try {
            // Build the request
            $this->request = Request::create();
            $this->request->initPath();
            
            // Get our method of parsing the request from config
            $this->interpreter = Interpreter::create();
            
            // Get a shiny new controller object
            $this->interpreter->interpret( $this->request );

        } catch( \RunTimeException $e ) {
            Debug::error( $e->getMessage() );
            Debug::writeFooter();
        }
    }
}

?>
