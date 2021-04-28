<?php
require_once((dirname(__DIR__)) . "/vendor/autoload.php");

$test = new \jossmp\response\obj(array(
	'success'=>true,
	'message'=>'Message...',
));

var_dump($test);

var_dump($test->json());

