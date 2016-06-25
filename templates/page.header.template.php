<?php

header('Content-Type: text/html; charset=utf-8');

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="<?=Route::$prefix?>css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=Route::$prefix?>css/common.css" />
    <link type="text/css" rel="stylesheet" href="<?=Route::$prefix?>css/TimeCircles.css" />
    <script type="text/javascript">
        var prefix = "<?=Route::$prefix?>";
        <?if(class_exists('GameController')){?>var gameMode = "<?=GameController::$gameMode?>";<?}?>
    </script>
    <script type="text/javascript" src="<?=Route::$prefix?>js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?=Route::$prefix?>js/TimeCircles.js"></script>
    <script type="text/javascript" src="<?=Route::$prefix?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=Route::$prefix?>js/common.js"></script>
    <?if((class_exists('GameController')) && (GameController::$gameMode == 'group')){?><script type="text/javascript" src="<?=Route::$prefix?>js/group.mode.js"></script><?}?>
</head>
<body>