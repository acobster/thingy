<?php

namespace ThingyCore\Templates;

require_once THINGY_CORE_DIR . 'templates/engine/Twig/Autoloader.php';

class TwigWrapper extends Template {
    
    protected $loader;
    protected $twig;
    protected $templateFileName;
    
    public function __construct( $name ) {
        $file = static::getTemplateFile ( $name );
        \Twig_Autoloader::register ();
        $this->loader = new \Twig_Loader_Filesystem ( dirname ( $file ) );
        $this->twig = new \Twig_Environment ( $this->loader );
        $this->templateFileName = basename( $file );
    }
    
    public function getOutput( array $data, $edit = false ) {
        return $this->twig->render($this->templateFileName, $data);
    }
}

?>
