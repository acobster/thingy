<?php

namespace ThingyCore\Controllers;

use ThingyCore\Thingy;
use ThingyCore\Interpreter;
use ThingyCore\Templates;
use ThingyCore\Debug;

class Controller {
    
    const DEFAULT_MODEL_CLASS = '\ThingyCore\Models\Page';
    
    public function execute( $path ) {
        $this->doAction( $path );
        if( thingy()->debug ) {
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
            if( thingy()->enableParentPages ) {
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
        
        // If we weren't passed a model class name, default
        if( empty( $modelClass ) ) {
            $modelClass = $this::DEFAULT_MODEL_CLASS;
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
            $path, thingy()->templates );
        $file = $file[0];
        $templateClass = Thingy::single()->templateClass;
        return new $templateClass( $file );
    }
    
    protected function error404() {
        $template = new Templates\TwigWrapper( '404.html' );
        $template->display( array() );
    }
}

?>