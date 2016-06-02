<?php
    
class Dbase extends PDO {
    
    private $db_serv = 'mysql:host=localhost;dbname=cities_llg';
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'cities_llg';
    
    
    private $pdo_options = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    
    public function __construct()
    {
        parent::__construct($this->db_serv, $this->db_user, $this->db_pass, $this->pdo_options);
    }
    
    /* Возвращает одно значение из таблицы по произвольному запросу */
    public function getOneRecord ($table, $n_field, $keyVal)
    {
        
        /*
         
         @table   - таблица в БД
         @n_field - поле, которое необходимо выбрать
         @keyVal  - ассоциативный массив параметров выборки: название поля => значение
         
        */
        
        $table = str_replace("`", "``", $table);
        $n_field = str_replace("`", "``", $n_field);
        $params = array();
        
        $sql = "SELECT $table.$n_field FROM $table WHERE";
        
        foreach($keyVal as $key => $val)
        {
            $sql .= " ".$table.".".str_replace("`", "``", $key)." = ? AND";
            $params[] = str_replace("`", "``", $val);
        }
        
        $sql = substr($sql, 0, -4);
        
        //$db = $this->dbase;
        
        $query = $this->prepare($sql);
        $query->execute($params); 
        $output = $query->fetch();
        
        $output = $output[$n_field];
        
        return $output;
        
    }
    
    /* Возвращает ряд из таблицы по произвольному запросу */
    public function getRowRecord ($table, $keyVal)
    {
        
        /*
         
         @table  - таблица в БД
         @keyVal - ассоциативный массив параметров выборки: название поля => значение
         
        */
        
        $table = str_replace("`", "``", $table);
        $params = array();
        
        $sql = "SELECT * FROM $table WHERE";
        
        foreach($keyVal as $key => $val)
        {
            $sql .= " ".$table.".".str_replace("`", "``", $key)." = ? AND";
            $params[] = str_replace("`", "``", $val);
        }
        
        $sql = substr($sql, 0, -4);
        
        $query = $this->prepare($sql);
        $query->execute($params); 
        $output = $query->fetch();
        
        return $output;
        
    }
    
    /* Вставляет строку данных в таблицу по произвольному запросу */
    public function insertData($table, $insertData)
    {
        /*
        
         @table        - таблица в БД
         @insertData   - ассоциативный массив значений вставки: название поля => значение
        
         вставка осуществляется через именованные плейсхолдеры
        
        */
        
        $table = str_replace("`", "``", $table);
        $v_name = "";
        $v_value = "";
        $values = array();
        
        $sql = "INSERT INTO $table";
        
        foreach($insertData as $key => $val)
        {
            $v_name .= str_replace("`","``",$key).", ";
            $v_value .= ":".str_replace("`","``",$key).", ";
            $values[$key] = $val;
        }
        
        $v_name = substr($v_name, 0, -2);
        $v_value = substr($v_value, 0, -2);
        
        $sql .= " ($v_name) VALUES ($v_value)";
        
        $query = $this->prepare($sql);
        $query->execute($values);
        
        return true;
        
    }
    
    /* Вставляет массивы данных в таблицу по произвольному запросу */
    public function insertMultipleData($table, $insertData)
    {
        /*
        
         @table        - таблица в БД
         @insertData   - массив значений вставки: название поля => массив значений
                {$key => array($val1, $val2, $val3...)}
        
        */
        
        $table = str_replace("`", "``", $table);
        
        $v_name = "";
        $v_value = "";
        
        $values = array();
        
        $sql = "INSERT INTO $table";
        
        foreach($insertData as $key => $val)
        {
            $v_name .= str_replace("`","``",$key).", ";
            $v_value .= "?, ";
        }
        
        $v_name = substr($v_name, 0, -2);
        $v_value = substr($v_value, 0, -2);
        
        $sql .= " ($v_name) VALUES ($v_value)";
        
        $values = Common :: getCartesian($insertData);
        
        $query = $this->prepare($sql);
        
        foreach($values as $key => $val)
        {
            $_tmp = array();
            foreach($val as $k => $v)
            {
                $_tmp[] = $v;
            }
            $query->execute($_tmp);
            unset($_tmp);
        }
        
        
        //$values['sql'] = $sql;
        
        return true;
        
    }
    
    /* Обновляет данные в таблице по произвольному запросу */
    public function updateData($table, $keyValInsert, $keyValParam)
    {
        /*
        
         @table        - таблица в БД
         @keyValInsert - ассоциативный массив значений вставки: название поля => значение
         @keyValParam  - ассоциативный массив параметров запроса: название поля => значение
        
        */
        
        $table = str_replace("`", "``", $table);
        $values = array();
        $_tmp = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
        $point = 0;
        
        $sql = "UPDATE $table SET ";
        
        foreach($keyValInsert as $key => $val)
        {
            if(!isset($values[$key])) {
                $values[$key] = $val;
                $sql .= str_replace("`","``",$key)." = :$key, ";
            } 
        }
        
        $sql = substr($sql, 0, -2)." WHERE "; 
        
        foreach($keyValParam as $key => $val)
        {
            if(!isset($values[$key])) {
                $values[$key] = $val;
                $sql .= str_replace("`","``",$key)." = :$key AND ";
            } else {
                $tmp = $key.$_tmp[$point];
                $values[$tmp] = $val;
                $sql .= str_replace("`","``",$key)." = :$tmp AND ";
                $point++;
            }
        }
        
        $sql = substr($sql, 0, -5);
        
        $query = $this->prepare($sql);
        $query->execute($values);
        
        return true;
        
    }
    
    /* Удаляет данные из таблицы по произвольному запросу */
    public function deleteData($table, $keyValParam)
    {
        
        /*
        
         @table        - таблица в БД
         @keyValParam  - ассоциативный массив параметров запроса: название поля => значение
        
        */
        
        $table = str_replace("`", "``", $table);
        $values = array();
        $_tmp = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
        $point = 0;
        
        $sql = "DELETE FROM $table WHERE ";
        
        foreach($keyValParam as $key => $val)
        {
            if(!isset($values[$key])) {
                $values[$key] = $val;
                $sql .= str_replace("`","``",$key)." = :$key AND ";
            } else {
                $tmp = $key.$_tmp[$point];
                $values[$tmp] = $val;
                $sql .= str_replace("`","``",$key)." = :$tmp AND ";
                $point++;
            }
        }
        
        $sql = substr($sql, 0, -5);
        
        $query = $this->prepare($sql);
        $query->execute($values);
        
        return true;
    
    }
    
    public function pdoSet($allowed, &$values, $source = array())
    {
        $set = '';
        $values = array();
        if (!$source) $source = &$_POST;
        foreach ($allowed as $field) {
          if (isset($source[$field])) {
            $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
            $values[$field] = $source[$field];
          }
        }
        return substr($set, 0, -2); 
    }
    
    
    /*
    try {
        $PDO = new PDO ($db_serv, $db_user, $db_pass, $pdo_options);
    }
    catch ( PDOException $e ) {
        print( "Error connecting to SQL Server." );
        die(print_r($e));
    }
*/
}
?>