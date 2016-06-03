<?php

class AjaxController
{

    private $city;
    private $dbase;
    private $cityName;
    private $lastLetter;
    private $error = '';
    private $message = '';
    
    public function __construct()
    {
        $this->dbase = new Dbase();
	$this->city = new Cities();
    }
    
    public function Engine($cityName)
    {
	
	$this->cityName = $cityName;
	    
	/* Проверка - есть ли такой город в БД */
	if($this->city->CheckCityExist($this->cityName) === true) {
		
	    /* Проверка - есть ли такой город в стеке последних названных */
	    if($this->city->CheckCityInStack($this->cityName) === false) {
		    
		$lastStack = $this->city->GetLastCityFromStack(); /* Выборка последней записи из стека */
		$LS_cityInfo = $this->city->GetCityInfo($lastStack['name']);
		$cityInfo = $this->city->GetCityInfo($this->cityName);
		    
		/* Если стек не пустой */
		if($lastStack !== false){
		    $LastStack_LastLetter = $this->city->GetLastLetterOfCity($lastStack['name']);
		    $cityName_FirstLetter = $this->city->GetFirstLetterOfCity($this->cityName);
			
		    /* Проверка - совпадает ли буквы начала и конца */
		    if($LastStack_LastLetter == $cityName_FirstLetter) {
		    /* Вычисляем дистанцию до города и записываем в стек, проверяем, если количество рядов больше заданного, стираем лишнии */
			    
			if((intval($cityInfo['lat']) == 0) && (intval($cityInfo['lon']) == 0)) {
			    $cityCoords = Common :: getCoordsByAddress($cityInfo['name']);
			    $update_arr = array('lat' => $cityCoords['lat'], 'lon' => $cityCoords['lon']);
			    $param_arr = array('city_id' => $cityInfo['city_id']);
			    if($this->dbase->updateData('city', $update_arr, $param_arr)) {
				$cityInfo['lat'] = $cityCoords['lat'];
				$cityInfo['lon'] = $cityCoords['lon'];
			    }
			} else {
			    $cityCoords['lat'] = $cityInfo['lat'];
			    $cityCoords['lon'] = $cityInfo['lon'];
			}
			    
			if((intval($LS_cityInfo['lat']) == 0) && (intval($LS_cityInfo['lon']) == 0)) {
			    $LS_cityCoords = Common :: getCoordsByAddress($LS_cityInfo['name']);
			    $_update_arr = array('lat' => $LS_cityCoords['lat'], 'lon' => $LS_cityCoords['lon']);
			    $_param_arr = array('city_id' => $LS_cityInfo['city_id']);
			    if($this->dbase->updateData('city', $_update_arr, $_param_arr)) {
				$LS_cityInfo['lat'] = $LS_cityCoords['lat'];
				$LS_cityInfo['lon'] = $LS_cityCoords['lon'];
			    }
			} else {
			    $LS_cityCoords['lat'] = $LS_cityInfo['lat'];
			    $LS_cityCoords['lon'] = $LS_cityInfo['lon'];
			}
			    
			$distance = Common :: getDistance($cityCoords, $LS_cityCoords);
			    
			$insData = array('t_stamp' => time(), 'city_id' => $cityInfo['city_id'], 'name' => $cityInfo['name'], 'distance' => $distance);
			if($ins = $this->dbase->insertData('stack', $insData)) $this->message .= " Город ".$cityInfo['name']." добавлен в стек";
			    
		    } else {
			$this->error = "Введенный вами город (".$this->cityName.") не подходит к последнему названному городу (".$lastStack['name'].")";
		    }
		} else {
		    /* Записываем город в стек, дистанцию ставим 0 - это первая запись в стеке */
			
		    $insData = array('t_stamp' => time(), 'city_id' => $cityInfo['city_id'], 'name' => $cityInfo['name'], 'distance' => 0);
		    if($ins = $this->dbase->insertData('stack', $insData)) $this->message .= " Город ".$cityInfo['name']." добавлен в стек";
			
		}
			
	    } else {
		$this->error = "Такой город был совсем недавно!";   
	    }
	} else {
	    $this->error = "К сожалению, мы не знаем такого города.";
	}
	    

	$result['message'] = $this->message;
	$result['error'] = $this->error;
	
	return $result;
	
    }
    
    public function Step()
    {
	if(!empty($_POST))
	{
	    $result = $this->Engine($_POST['answer']);
	    
	    echo json_encode($result);
	}
    }
    
    public function AITurn()
    {
            
	$LastStack = $this->city->GetLastCityFromStack();
	$LastLetter = $this->city->GetLastLetterOfCity($LastStack['name']);
	$NextCity = $this->city->FindNextCity($LastLetter);
	
	$result = $this->Engine($NextCity['name']);
	
	echo json_encode($result);
	
    }
    
    public function ShowGameLog()
    {
	
	$log = $this->city->GetStackRecords();
	$result = array();
	
	foreach($log as $val)
	{
	    $result[$val['name']] = $val['distance'];
	}
	
	echo json_encode($result);
	
    }
}

?>