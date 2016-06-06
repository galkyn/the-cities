<?php

class GameController
{
    
    public function InitializeWorldGame()
    {
        
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
	include './templates/world.game.template.php';
	
	include './templates/page.footer.template.php';
    }
    
}

?>