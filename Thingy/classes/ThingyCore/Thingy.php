<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Thingy {
    
    /**
     * The Thingy singleton, or "Thingleton"
     * @var ThingyCore\Thingy
     */
    protected static $single;
    
    /**
     * The user-defined configuration
     * @var array
     */
    protected $config;
    
    /**
     * Default configuration values
     * @var array
     */
    protected $defaults = array(
        'debug' => false,
        'templateClass' => 'ThingyCore\Templates\TwigWrapper',
        'requestClass' => 'ThingyCore\Request',
        'interpreterClass' => 'ThingyCore\Interpreter',
        'modelDirs' => array(
            'classes/ThingyCore/Models/',
        ),
        'controllers' => array(
            '*' => 'ThingyCore\Controllers\Controller',
            'posts' => 'ThingyCore\Controllers\PostController',
            'login' => 'ThingyCore\Controllers\LoginController',
        ),
        'templates' => array(
            '*' => 'index.html',
            'one' => array(
                'two' => array(
                    'eels' => 'fancy.html',
                ),
            ),
        ),
        'enableParentPages' => true,
        'cache' => array(
            'enabled' => true,
            'dir' => 'cache',
        ),
        'ignoreOnAutoload' => array(
            '/^Twig/',
        ),
    );
    
    /**
     * The Request object
     * @var ThingyCore\Request
     */
    protected $request;
    
    /**
     * The Interpreter object, which maps a request to a Controller
     * @var ThingyCore\Interpreter
     */
    protected $interpreter;
    
    /**
     * Get the Thingleton
     * @param Only required the first time you call  $config
     * @return ThingyCore\Thingy the Thingleton
     */
    public static function single( $config = false ) {
        if( empty( self::$single ) ) {
            self::$single = new Thingy( $config );
        }
        return self::$single;
    }

    /**
     * Constructor is protected, after the Singleton pattern.
     * @param array $config the Thingy configuration
     */
    protected function __construct( $config ) {
        $this->config = $config;
    }
    
    public function __get( $index ) {
        if( isset( $this->config[$index] ) ) {
            return $this->config[$index];
        } elseif( isset( $this->defaults[$index] ) ) {
            return $this->defaults[$index];
        } else {
            Debug::error( "Attempting to access undefined config: $index" );
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
            
            // Get a shiny new controller object and execute it
            $this->interpreter->interpret( $this->request );

        } catch( \RunTimeException $e ) {
            Debug::error( $e->getMessage() );
            Debug::writeFooter();
        }
    }

    /**
     * Gets the value of request.
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Gets the value of interpreter.
     *
     * @return mixed
     */
    public function getInterpreter()
    {
        return $this->interpreter;
    }
}

?>
