<?php

namespace ThingyCore;

require_once 'thingy.config.php';
require_once 'autoload.php';

$thingy = Thingy::single( $GLOBALS['config'] );

$thingy->main();

?>
