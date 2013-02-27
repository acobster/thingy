<?php

namespace ThingyCore;

require 'thingy.config.php';
require 'autoload.php';

$thingy = Thingy::single( $GLOBALS['config'] );

$thingy->main();

?>
