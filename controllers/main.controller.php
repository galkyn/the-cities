<?php

class MainController
{
    public function DefaultPage()
    {
        
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
	include './templates/main.template.php';
	
	include './templates/page.footer.template.php';
        
    }
}

?>