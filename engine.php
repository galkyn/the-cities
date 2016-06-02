<?php

//echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

//echo ini_get('display_errors');

error_reporting(E_ALL);

require_once './classes/dbase.class.php';
require_once './classes/common.class.php';
require_once './classes/cities.class.php';

require_once './controllers/route.php';

$route = Route::getInstance();

?>
