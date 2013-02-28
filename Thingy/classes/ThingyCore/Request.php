<?php

namespace ThingyCore;

class Request {
    
    protected $uriString;
    protected $path;
    
    public static function create() {
        $class = Thingy::single()->requestClass;
        
        return new $class();
    }
    
    /**
     * 
     * Enter description here ...
     */
    public function getPath() {
        return $this->path;
    }
    
    /**
     * 
     * Enter description here ...
     */
	public function initPath() {
    
        $this->setURIString();
        
        // Strip leading slashes
        $path = preg_replace( '|^\/*|', '', $this->uriString );
        // Strip the protocol/domain stuff; it doesn't tell us anything new
        $path = str_replace( THINGY_WEB_DIR, '', $path );
        // Strip the query string; we can worry about it in the Controller
        $path = preg_replace( '/\?.*/', '', $path );
        // Put segments into an array
        $path = explode( '/', $path );
        // Make all strings lowercase
        $path = array_map( 'strtolower', $path );
        
        // If 'index.php' is part of the path,
        // throw out that segment; it doesn't tell us anything
        if( $path[0] == 'index.php' ) {
            array_shift( $path );
        }
        
        // Get rid of empty elements
        $path = array_filter( $path );
        
        $this->path = $path;
    }
    
    /**
     * 
     * Enter description here ...
     */
    protected function setURIString() {
        $this->uriString = $_GET['r'];
    }
}

?>
