<?php

class ServiceController
{
   
    private $dbase;
    
    public function __construct()
    {
        $this->dbase = new Dbase();
    }
    
    public function FindCoords()
    {
        $sql = "SELECT city_id, name FROM city WHERE lat = 0 AND lon = 0 LIMIT 10";
        $query = $this->dbase->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        
        foreach($result as $key => $val)
        {
            $result[$key]['coords'] = Common :: getCoordsByAddress($val['name']);
            $_update_arr = array('lat' => $result[$key]['coords']['lat'], 'lon' => $result[$key]['coords']['lon']);
	    $_param_arr = array('city_id' => $val['city_id']);
            
            
            if($this->dbase->updateData('city', $_update_arr, $_param_arr)) { $result[$key]['error'] = 0; }
            else { $result[$key]['error'] = 'not found'; }
            
        }
        
        include './templates/page.header.template.php';//Подключаем шаблон с заголовками сайта: скрипты, стили, тайтлы и т.д.
	
        include './templates/_service.find.coords.template.php';
	
	include './templates/page.footer.template.php';
        
    }
    
}

?>