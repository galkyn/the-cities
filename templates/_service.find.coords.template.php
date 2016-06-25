<?php

$timeout = rand(2, 6) * 1000;


foreach($result as $key => $val)
{
    echo "<pre>";
    
    print_r($val);
    
    echo "</pre>";
}

    echo "<script>";
        //echo "setTimeout('top.location=\"".Route::$prefix."service/find-coords\";', ".$timeout.");";
    echo "</script>";

?>