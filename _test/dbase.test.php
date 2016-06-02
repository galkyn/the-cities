<?php

error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

require_once '../classes/dbase.class.php';
//require_once '../classes/common.class.php';
require_once '../classes/cities.class.php';

/*
$cafe_coords = Common :: getCoordsByAddress("Калининград, ул. Воздушная 50");

var_dump($cafe_coords);

echo "<br><Br><br>";

$e_point = array('lat' => '54.720806', 'lon' => '20.501304');
$distance = Common :: getDistance("Калининград, ул. Воздушная 50", "Калининград, ул. Воздушная 38");

var_dump($distance);
*/
echo "<br><Br><br>";

$db = new Dbase();

$arr = array('city_id' => '4400');
$data = $db->getRowRecord('city', $arr);

var_dump($data);

echo "<br><br>";

$city = new Cities();
$city_name = 'Моздок';


$letter = $city->GetLastLetterOfCity($city_name);

var_dump($letter);
echo "<br>";

$check = $city->CheckCityExist($city_name);
var_dump($check);
echo "<br>";

$new_city = $city->FindNextCity($letter);
echo "<pre>"; print_r($new_city); echo "</pre>";
echo "<br>";


/*
echo "<br><Br><br>";

$arr = array('lat' => '54.720806', 'lon' => '20.501304');
$data = $db->getOneRecord('Cafe', 'phone', $arr);

var_dump($data);

$arr = array('lCode' => 'ITA');
$lang_data = $db->getRowRecord('LangTypes', $arr);

echo "<br><br><br>";

var_dump($lang_data);

unset($arr);
echo "<br><br><br>";
*/
//$arr['cafeName'] = 'Кафе Сырок';
//$arr['cafeAbout'] = 'Все виды молочной и сырной продукции, у нас даже шашлыки из творога';
//$arr['cafeAdr'] = 'Балтийск, ул. Садовая 4';
//$arr['lang'] = 'RUS';
/*
$arr['phone'] = '33-33-33';
$arr['email'] = 'майл-хуейл';
$arr['site'] = 'хуйсайт.бля';

$insert_data = $db->insertData('Cafe', $arr);

echo "<br><br><br>";

echo "<pre>";
print_r($insert_data);
echo "</pre>";
*/
/*
$update_data = array('phone' => '785-55-34', 'site' => 'under constraction', 'tue_open' => '12');
$param = array('mon_open' => 5);

if($update_check = $db->updateData('Cafe', $update_data, $param)) echo "UPDATE COMPLETE";

echo "<pre>";
print_r($update_check);
echo "</pre>";

$param = array('id' => 17);

if($delete_check = $db->deleteData('Cafe', $param)) echo "DELETE COMPLETE";

echo "<pre>";
print_r($delete_check);
echo "</pre>";


$arr = array(
    'cafeFeatureID' => array(1, 2, 5, 6),
    'cafeID' => array(16)
);

$result = $db->insertMultipleData('FeaturesVsCafes', $arr);

echo "<pre>";
print_r($result);
echo "</pre>";
*/

?>