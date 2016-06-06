<?php

error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

require_once '../classes/dbase.class.php';
require_once '../classes/common.class.php';
require_once '../classes/cities.class.php';

require_once '../controllers/ajax.controller.php';


$ajax = new AjaxController();

$result = $ajax->Engine('Аделаида');

//var_dump($result);

echo "<pre>"; print_r($result); echo "</pre>";



?>