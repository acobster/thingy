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
    
    public function execute( $pieces ) {
        $this->doAction( $pieces );
        if( Thingy::$DEBUG ) {
            Debug::writeFooter();
        }
    }
    
    public function doAction( $pieces ) {
        $first = isset( $pieces[0] ) ? $pieces[0] : 'index';
        
        $reflection = new \ReflectionClass( $this );
        if( $reflection->hasMethod( $first ) ) {
            $this->$first( array_slice( $pieces, 1 ) );
        } else {
            $this->index( $pieces );
        }
    }
    
    public function index( $pieces ) {
        
        $name = empty( $pieces[0] ) ? 'home' : $pieces[0];
        
        if( count( $pieces ) > 1 ) {
            if( Thingy::single()->enableParentPages ) {
                $model = $this->initModel( $pieces );
            } else {
                $this->error404();
                return;
            }
        } else {
            $model = $this->initModel( $name );
        }
        
        $template = $this->initTemplate( $pieces );
        
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
    
    protected function initTemplate( $pieces ) {
        $file = Interpreter::create()->parseHierarchy( 
            pieces, Thingy::single()->templates );
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