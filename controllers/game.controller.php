<?php

class GameController
{
    
    public static $gameMode;
    
    private $gameModeTitle;
    private $gameModeDescFull;
    private $gameModeDescShort;
    
    public function InitializeSingleGame()
    {
        self::$gameMode = 'single';
        
	$this->gameModeTitle = 'Одиночная игра';
	$this->gameModeDescFull = 'Игрок соревнуется с компьютером. Города компьютер выбирает случайным образом. Игра прекращается, когда игрок закрывает браузер, количество ходов не ограничено, информация о набранных игроком очках, после закрытия игровой сессии, не сохраняется. В этом, тренировочном режиме, игра поможет игроку освоится с функционалом и понять правила.';
	$this->gameModeDescShort = 'Игрок соревнуется с компьютером. Города компьютер выбирает случайным образом. Игра прекращается, когда игрок закрывает браузер, количество ходов не ограничено, информация о набранных игроком очках не сохраняется.';
	
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
        include './templates/playground.template.php';
	
	include './templates/page.footer.template.php';
    }
    
    public function InitializeGroupGame()
    {
        self::$gameMode = 'group';
        
	$this->gameModeTitle = 'Игра с друзьями';
	$this->gameModeDescFull = 'Режим "Hot Seat/Горячий стул". В этом режиме игра предлагает пользователю создать соревнование, указав игроков и количество ходов. Каждый из игроков отвечает заданное количество раз. Игрок, набравший большее количество очков, считается победителем. Время на ход ограниченно.';
	$this->gameModeDescShort = 'Режим "Hot Seat/Горячий стул". В этом режиме игра предлагает пользователю создать соревнование, указав игроков и количество ходов. Игрок, набравший большее количество очков, считается победителем.';
	
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
        include './templates/playground.template.php';
	
	include './templates/page.footer.template.php';
    }
    
    public function InitializeWorldGame()
    {
        self::$gameMode = 'world';
        
	$this->gameModeTitle = 'Игра против всех';
	$this->gameModeDescFull = 'В этом режиме игрок соревнуется с другими такими же игроками по всему миру. Указав логин и пароль, игрок получает доступ к глобальному рейтингу. Рейтинг отображается по трем параметрам: количеству набранных очков, количеству сыгранных игровых сессий, среднему количеству очков, набранных за одну игровую сессию.';
	$this->gameModeDescShort = 'В этом режиме игрок соревнуется с другими такими же игроками по всему миру. Указав логин и пароль, игрок получает доступ к глобальному рейтингу.';
	
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
        include './templates/playground.template.php';
	
	include './templates/page.footer.template.php';
    }
    
}

?>