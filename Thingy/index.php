<?php

require 'thingy.config.php';
require 'autoload.php';

$thingy = ThingyCore\Thingy::single( $GLOBALS['config'] );

$thingy->main();

?>
