<?php

namespace ThingyCore\Controllers;

use ThingyCore\Thingy;
use ThingyCore\Interpreter;
use ThingyCore\Templates;
use ThingyCore\Debug;

class Controller {
    
    const DEFAULT_MODEL = '\ThingyCore\Models\Page';
    const DEFAULT_TEMPLATE_ENGINE = 'ThingyCore\Templates\TwigWrapper';
    
    public function __construct() {
        $thingy = Thingy::single();
        $this->templateClass = isset ( $thingy->templateEngine )
            ? $thingy->templateEngine
            : $this::DEFAULT_TEMPLATE_ENGINE;
    }
    
    public function execute( $path ) {
        $this->doAction( $path );
        if( Thingy::$DEBUG ) {
            Debug::writeFooter();
        }
    }
    
    public function doAction( $path ) {
        $first = isset( $path[0] ) ? $path[0] : 'index';
        
        $reflection = new \ReflectionClass( $this );
        if( $reflection->hasMethod( $first ) ) {
            $this->$first( array_slice( $path, 1 ) );
        } else {
            $this->index( $path );
        }
    }
    
    public function index( $path ) {
        
        $name = empty( $path[0] ) ? 'home' : $path[0];
        
        if( count( $path ) > 1 ) {
            if( Thingy::single()->enableParentPages ) {
                $model = $this->initModel( $path );
            } else {
                $this->error404();
                return;
            }
        } else {
            $model = $this->initModel( $name );
        }
        
        $template = $this->initTemplate( $path );
        
        if( ! empty( $model ) ) {
            $data = $model->prepare();
            $template->display( $data );
        } else {
            $this->error404();
        }
    }
    
    protected function initModel( $ident, $modelClass = false ) {
        
        // If we weren't passed a model class name...
        if( empty( $modelClass ) ) {
            // get it from the config...
            $modelClass = Thingy::single()->defaultModel;
            if( empty( $modelClass ) )
            {
                // ...or just default.
                $modelClass = $this::DEFAULT_MODEL;
            }
        }
        $model = new $modelClass();
        
        if( is_array( $ident ) ) {
            return $model->findByNameAndAncestors( $ident );
        } else {
            return $model->findByName( $ident );
        }
    }
    
    protected function initTemplate( $path ) {
        $file = Interpreter::parseHierarchy(
            $path, Thingy::single()->templates );
        $file = $file[0];
        $templateClass = $this->templateClass;
        return new $templateClass( $file );
    }
    
    protected function error404() {
        $template = new Templates\TwigWrapper( '404.html' );
        $template->display( array() );
    }

    public function findByName( $name ) { echo "<p>find by name: $name</p>"; }
}

?>