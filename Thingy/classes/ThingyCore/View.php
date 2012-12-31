<?php

namespace ThingyCore;

use ThingyCore\Debug;

abstract class View {
    
    const HEAD_TEMPLATE_VAR = 'thingy_head';
    const DEFAULT_TEMPLATE = 'index.html';
    
    protected $data;
    protected $template;
    
    public function View( $data, $template = false ) {
        $this->data = $data;
        
        $template = $template ? $template : $this::DEFAULT_TEMPLATE;
        
        $this->setTemplate( $template );
    }
    
    public function display() {
        
        $this->template->display( $this->data );
    }
    
    public function registerScript( $script, $customPath = false ) {
        $dir = $customPath ? '' : '/Users/acobster/Sites/Thingy/public/js/';
        
        $source = $dir . $script;
        
        if( ! $this->data[$this::HEAD_TEMPLATE_VAR] ) {
            $this->data[$this::HEAD_TEMPLATE_VAR] = '';
        }
        
        $this->data[$this::HEAD_TEMPLATE_VAR]
            .= '<script type="text/javascript" src="'
        	. $source . '"></script>';
        	
    }
    
    public function setTemplate( $file ) {
        $path = Template::getFullPath($file);
        $this->template = Template_Factory::create($path);
    }
    
    public function setEditable( $editable ) {
        $this->editable = $editable;
    }
}

?>
