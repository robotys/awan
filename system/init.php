<?php

require_once('import.php');

// do composer autoload too later here

// Run the Request cycle
use Awan\Request;

$request = new Request;
$request->run();