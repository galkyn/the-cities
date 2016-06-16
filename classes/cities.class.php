<?php

class Cities {
    
    private $dbase;
    
    public function __construct()
    {
        $this->dbase = new Dbase();
    }
    
    /* Возвращает последнюю букву в названии города */
    public function GetLastLetterOfCity($cityName)
    {
        $cityName =  preg_replace('/[^a-zA-Zа-яА-Я-_ ]/ui', '', $cityName); 
        $result = (mb_substr(mb_strtolower($cityName, 'UTF-8'), -1, 1, 'UTF-8') != 'ь') ? mb_substr($cityName, -1, 1, 'UTF-8') : mb_substr($cityName, -2, 1, 'UTF-8');
        return $result;
    }
    
    /* Возвращает первую букву в названии города */
    public function GetFirstLetterOfCity($cityName)
    {
        $cityName =  preg_replace('/[^a-zA-Zа-яА-Я-_ ]/ui', '', $cityName); 
        $result = mb_substr(mb_strtolower($cityName, 'UTF-8'), 0, 1, 'UTF-8');
        return $result;
    }
    
    /* Проверяет, существует ли такой город в БД */
    public function CheckCityExist($cityName)
    {
        $arr = array('name' => $cityName);
        $result = $this->dbase->getOneRecord('city', 'city_id', $arr);
        $result = ($result !== NULL) ? true : false;
        return $result; 
    }
    
    /* Проверяет, существует ли такой город в стэке последних названных городов */
    public function CheckCityInStack($cityName)
    {
        $arr = array('name' => $cityName);
        $result = $this->dbase->getOneRecord('stack', 't_stamp', $arr);
        $result = ($result !== NULL) ? true : false;
        return $result; 
    }
    
    /* Возвращает последний город из стэка названных городов */
    public function GetLastCityFromStack()
    {
        $query = $this->dbase->prepare("SELECT * FROM stack ORDER BY t_stamp DESC LIMIT 1");
	$query->execute();
	$result = $query->fetch();
        return $result; 
    }
    
    /* Возвращает массив с записью ходов */
    public function GetStackRecords($kolvo = 20)
    {
        $sql = "SELECT * FROM stack ORDER BY t_stamp DESC LIMIT :kolvo";
        $query = $this->dbase->prepare($sql);
        $query->bindParam(':kolvo', $kolvo, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetchAll();
        return $result;
    }
    
    /* Возвращает строку с данными города по его названию, так то лишний редирект ф-ии, но для единообразия пусть будет */
    public function GetCityInfo($cityName)
    {
        $arr = array('name' => $cityName);
        $result = $this->dbase->getRowRecord('city', $arr);
        return $result; 
    }
    
    /* Случайным образом находит в БД город по первой букве */
    public function FindNextCity($letter)
    {
        
        $letter = mb_strtoupper($letter, 'UTF-8').'%';
        
        $sql = "SELECT * FROM city WHERE name LIKE :letter ORDER BY RAND() LIMIT 1";
        
        $query = $this->dbase->prepare($sql);
        $query->bindParam(':letter', $letter, PDO::PARAM_STR);
        $query->execute();
        
        $result = $query->fetch();
        //$result['sql'] = $sql;
        //$result['letter'] = $letter;
        
        return $result;    
    }
    
    /* возвращает расстояние между двумя городами */
    public function GetDistanceBetweenCities($cityA, $cityB)
    {
	$cityA_info = $this->GetCityInfo($cityA);
	$cityB_info = $this->GetCityInfo($cityB);
	
	if((intval($cityA_info['lat']) == 0) && (intval($cityA_info['lon']) == 0)) {
	    $cityA_coords = Common :: getCoordsByAddress($cityA);
	    $update_arr = array('lat' => $cityA_coords['lat'], 'lon' => $cityA_coords['lon']);
	    $param_arr = array('city_id' => $cityA_info['city_id']);
	    if($this->dbase->updateData('city', $update_arr, $param_arr)) {
		$cityA_info['lat'] = $cityA_coords['lat'];
		$cityA_info['lon'] = $cityA_coords['lon'];
	    }
	} else {
	    $cityA_coords['lat'] = $cityA_info['lat'];
	    $cityA_coords['lon'] = $cityA_info['lon'];
	}
			    
	if((intval($cityB_info['lat']) == 0) && (intval($cityB_info['lon']) == 0)) {
	    $cityB_coords = Common :: getCoordsByAddress($cityB);
	    $_update_arr = array('lat' => $cityB_coords['lat'], 'lon' => $cityB_coords['lon']);
	    $_param_arr = array('city_id' => $cityB_info['city_id']);
	    if($this->dbase->updateData('city', $_update_arr, $_param_arr)) {
		$cityB_info['lat'] = $cityB_coords['lat'];
		$cityB_info['lon'] = $cityB_coords['lon'];
	    }
	} else {
	    $cityB_coords['lat'] = $cityB_info['lat'];
	    $cityB_coords['lon'] = $cityB_info['lon'];
	}
			    
	$distance = Common :: getDistance($cityA_coords, $cityB_coords);
   
	return $distance;
   
    }
    
}


?>