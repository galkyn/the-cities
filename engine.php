<?php

//echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '0');
}

//echo ini_get('display_errors');

error_reporting(0);

//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once './classes/dbase.class.php';
require_once './classes/common.class.php';
require_once './classes/cities.class.php';

require_once './controllers/route.php';

$route = Route::getInstance();

?>
