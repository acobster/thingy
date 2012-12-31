<?php

namespace ThingyCore;

use ThingyCore\Debug;

class Thingy {
    
    public static $DEBUG;
    public static $DEFAULT_MODEL_DIR;
    
    protected $request;
    protected $interpreter;
    protected $settings;
    protected $user;
    
    public function Thingy() {
        self::$DEBUG = defined( 'THINGY_DEBUG' )
            ? THINGY_DEBUG
            : false;
            
        $modelPath = defined( 'THINGY_DEFAULT_MODEL_DIR' )
          ? THINGY_DEFAULT_MODEL_DIR
          : 'classes/ThingyCore/Models/';
        self::$DEFAULT_MODEL_DIR = THINGY_CORE_DIR . $modelPath;
    }
    
    public function main() {
        
        ThingySettings::init();
        
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
