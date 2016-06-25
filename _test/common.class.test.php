<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

header('Content-Type: text/html; charset=utf-8');

require_once '../classes/dbase.class.php';
require_once '../classes/common.class.php';
require_once '../classes/cities.class.php';


$result = Common :: getCoordsByAddress('Москва');

//var_dump($result);

echo "<pre>"; print_r($result); echo "</pre>";



?>