<?php

//echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

//echo ini_get('display_errors');

error_reporting(E_ALL);

require_once './controllers/route.php';

$route = Route::getInstance();

?>
