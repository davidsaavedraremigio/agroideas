<?php
header('Content-Type: application/json');
require_once((dirname(__DIR__)) . "/vendor/autoload.php");

$curl = new \jossmp\navigate\Curl();
$curl->post('https://rest.softdatamen.com/v1/d3fac5071ac65b337ba5c29bede33617/sunat/tipo-cambio', array(
	'anio' => '2019',
	'mes' => '02'
));

if ($curl->error) {
	echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
} else {
	echo 'Response:' . "\n";
	var_dump($curl->response);
}
