<?php

class AjaxController
{
    public function AITurn()
    {
        
        require_once './classes/dbase.class.php';
	require_once './classes/common.class.php';
        require_once './classes/cities.class.php';
        
	if (!empty($_POST)) {
            
	    
	    $city = new Cities();
	    $db = new Dbase();
	    
	    if($city->CheckCityExist($_POST['answer']) === true) {
		$LastLetter = $city->GetLastLetterOfCity($_POST['answer']);
		$FisrtCityInfo = $city->GetCityInfo($_POST['answer']);
		
		if((intval($FisrtCityInfo['lat']) == 0) && (intval($FisrtCityInfo['lon']) == 0)) {
		    $fCityCoords = Common :: getCoordsByAddress($FisrtCityInfo['name']);
		    $update_arr = array('lat' => $fCityCoords['lat'], 'lon' => $fCityCoords['lon']);
		    $param_arr = array('city_id' => $FisrtCityInfo['city_id']);
		    if($db->updateData('city', $update_arr, $param_arr)) {
			$FisrtCityInfo['lat'] = $fCityCoords['lat'];
			$FisrtCityInfo['lon'] = $fCityCoords['lon'];
		    }
		} else {
		    $fCityCoords['lat'] = $FisrtCityInfo['lat'];
		    $fCityCoords['lon'] = $FisrtCityInfo['lon'];
		}
		
		$NextCity = $city->FindNextCity($LastLetter);
		
		if((intval($NextCity['lat']) == 0) && (intval($NextCity['lon']) == 0)) {
		    $nCityCoords = Common :: getCoordsByAddress($NextCity['name']);
		    $_update_arr = array('lat' => $nCityCoords['lat'], 'lon' => $nCityCoords['lon']);
		    $_param_arr = array('city_id' => $NextCity['city_id']);
		    if($db->updateData('city', $_update_arr, $_param_arr)) {
			$NextCity['lat'] = $nCityCoords['lat'];
			$NextCity['lon'] = $nCityCoords['lon'];
		    }
		} else {
		    $nCityCoords['lat'] = $NextCity['lat'];
		    $nCityCoords['lon'] = $NextCity['lon'];
		}
		
		$distance = Common :: getDistance($fCityCoords, $nCityCoords);
		
		echo $distance;
		
		//$aiAnswer = array('message' => $NextCity['name']." (".$distance.")");
	    }
	    else {
		$aiAnswer = array('message' => 'Такого города ('.$_POST['answer'].') не найдено');
	    }
	    
	    echo "<pre>"; print_r($fCityCoords); print_r($FisrtCityInfo); print_r($NextCity); echo "</pre>";
	    
            //echo json_encode($aiAnswer);
            
        }
	
    }
}

?>