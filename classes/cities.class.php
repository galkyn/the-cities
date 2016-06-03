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
    
}


?>