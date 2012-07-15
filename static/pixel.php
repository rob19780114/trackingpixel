<?php

// require class for tracking
// you might want to add "lib" into your php include path and
// change the information below
require_once '../lib/Tracking.php';

// extract parameter from request
// you can use $_GET or $_POST or whatever, if you need something
// more special
if (isset($_REQUEST['log'])) {
    $log = $_REQUEST['log'];
} else {
    $log = '';
}

// init tracker
$tracking = new Tracking(Tracking::TYPE_PNG);

// deliver pixel
echo $tracking->getPixel($log);