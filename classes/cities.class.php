<?php

class Cities {
    
    private $dbase;
    
    public function __construct()
    {
        $this->dbase = new Dbase();
    }
    
    public function GetLastLetterOfCity($cityName)
    {
        $cityName =  preg_replace('/[^a-zA-Zа-яА-Я-_ ]/ui', '', $cityName); 
        
        $last_letter = (mb_substr(mb_strtolower($cityName, 'UTF-8'), -1, 1, 'UTF-8') != 'ь') ? mb_substr($cityName, -1, 1, 'UTF-8') : mb_substr($cityName, -2, 1, 'UTF-8');
        
        return $last_letter;
        
    }
    
    public function CheckCityExist($cityName)
    {
        $db = $this->dbase;
        $arr = array('name' => $cityName);
        
        $result = $db->getOneRecord('city', 'city_id', $arr);
        $result = ($result !== NULL) ? true : false;
        
        return $result; 
    }
    
    public function CheckCityInBuffer($cityName)
    {
        $db = $this->dbase;
        $arr = array('name' => $cityName);
        
        $result = $db->getOneRecord('buffer', 't_stamp', $arr);
        $result = ($result !== NULL) ? true : false;
        
        return $result; 
    }
    
    public function GetCityInfo($cityName)
    {
        $db = $this->dbase;
        $arr = array('name' => $cityName);
        
        $result = $db->getRowRecord('city', $arr);
        
        return $result; 
    }
    
    public function FindNextCity($letter)
    {
        
        $letter = mb_strtoupper($letter, 'UTF-8').'%';
        
        $db = $this->dbase;
        
        $sql = "SELECT * FROM city WHERE name LIKE :letter ORDER BY RAND() LIMIT 1";
        
        $query = $db->prepare($sql);
        $query->bindParam(':letter', $letter, PDO::PARAM_STR);
        $query->execute();
        
        $result = $query->fetch();
        //$result['sql'] = $sql;
        //$result['letter'] = $letter;
        
        return $result;    
    }
    
}


?>