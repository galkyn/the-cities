<?php

class GameController
{
    
    public static $gameMode;
    
    public function InitializeWorldGame()
    {
        self::$gameMode = 'world';
        
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
        include './templates/playground.template.php';
	
	include './templates/page.footer.template.php';
    }
    
}

?>