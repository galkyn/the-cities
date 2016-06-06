<?php

class Route
{
    
    private $url_namespace = array(
	'main' => 'main.controller',
	'ajax' => 'ajax.controller',
	'game' => 'game.controller'
    );
    
    private $url_method = array(
	'main' => array(
	    'start' => 'DefaultPage'
	),
	'ajax' => array(
	    'ai-turn' => 'AITurn',
	    'step' => 'Step',
	    'game-log' => 'ShowGameLog'
	),
	'game' => array(
	    'single' => '',
	    'group' => '',
	    'world' => 'InitializeWorldGame'
	)
    );
    
    private static $instance = null;
    private $controller = 'main';
    private $action = 'start';
    
    public static $prefix = './';

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
	
        $url_arr = (strpos($_SERVER['REQUEST_URI'], '?') !== false) ? substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')) : $_SERVER['REQUEST_URI'];
        
        $url_buff = explode('/', $url_arr);
        
        if ( !empty($url_buff[4]) )
	{	
	    $this->controller = $url_buff[4];
            self::$prefix .= '../';
	}
		
	if ( !empty($url_buff[5]) )
	{
	    $this->action = $url_buff[5];
	}
        
	$controller_path = './controllers/'.$this->url_namespace[$this->controller].'.php';
	$controller_name = ucfirst($this->controller)."Controller";
	$method = $this->url_method[$this->controller][$this->action];
	
        if((array_key_exists($this->controller, $this->url_namespace)) && (is_file($controller_path))) {
            
	    include $controller_path;
	    
	    $controller = new $controller_name;
	    
	    if((array_key_exists($this->action, $this->url_method[$this->controller])) && (method_exists($controller, $this->url_method[$this->controller][$this->action]))){
		$controller->$method();
	    }
	    else {
		self::ErrorPage404();
	    }
	    
        }
	else {
	    self::ErrorPage404();
	}
        
    }
    
    private function __clone() {}
    private function __wakeup() {}
    
    private function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
	header("Status: 404 Not Found");
	header('Location:'.$host.'404');
    }
    
}

?>