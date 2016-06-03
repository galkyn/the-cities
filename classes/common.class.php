<?php

class Common {
    
    
    /* Возвращает массив с координатами места по его адресу используя API Google Maps */
    public static function getCoordsByAddress ($address) 
    {
        
        /*
         
         @address  - текстовое написание адреса, например: г. Москва, ул. Ленина 5
         
        */
 
        $address = urlencode($address);
         
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
         
        $response = file_get_contents($url);
         
        $json = json_decode($response,TRUE); 
        
        $arr['lat'] = $json['results'][0]['geometry']['location']['lat'];
        $arr['lon'] = $json['results'][0]['geometry']['location']['lng'];
         
        return $arr;

    }
    
    /* Возвращает расстояние между двумя точками */
    public static function getDistance ($start_point, $end_point)
    {
        /*
        
         используется формула гаверсинусов
         
         @start_point   - начальная точка: ассоциативный массив координат или строка с адресом
         @end_point     - конечная точка: ассоциативный массив координат или строка с адресом
         
        */
        
        $start_point = (is_array($start_point) === TRUE) ? $start_point : self :: getCoordsByAddress($start_point);
        $end_point = (is_array($end_point) === TRUE) ? $end_point : self :: getCoordsByAddress($end_point);
        
        $R = 6371;
        $fi_1 = deg2rad($start_point['lat']);
        $fi_2 = deg2rad($end_point['lat']);
        $delta_fi = deg2rad($end_point['lat'] - $start_point['lat']);
        $delta_l =  deg2rad($end_point['lon'] - $start_point['lon']);
        
        $a = sin($delta_fi / 2) * sin($delta_fi / 2) + cos($fi_1) * cos($fi_2) * sin($delta_l / 2) * sin($delta_l / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $R * $c;
        
        //$distance = acos(sin($start_point['lat']) * sin($end_point['lat']) + cos($start_point['lat']) * cos($end_point['lat']) * cos($start_point['lon'] - $end_point['lon'])) * 6371; //формула для сферической теоремы косинусов
        
        $distance = round($distance, 1);
        
        return $distance;
        
    }
    
    public static function getCartesian($input)
    {
        $result = array();
    
        while (list($key, $values) = each($input)) {
            // If a sub-array is empty, it doesn't affect the cartesian product
            if (empty($values)) {
                continue;
            }
    
            // Seeding the product array with the values from the first sub-array
            if (empty($result)) {
                foreach($values as $value) {
                    $result[] = array($key => $value);
                }
            }
            else {
                // Second and subsequent input sub-arrays work like this:
                //   1. In each existing array inside $product, add an item with
                //      key == $key and value == first item in input sub-array
                //   2. Then, for each remaining item in current input sub-array,
                //      add a copy of each existing array inside $product with
                //      key == $key and value == first item of input sub-array
    
                // Store all items to be added to $product here; adding them
                // inside the foreach will result in an infinite loop
                $append = array();
    
                foreach($result as &$product) {
                    // Do step 1 above. array_shift is not the most efficient, but
                    // it allows us to iterate over the rest of the items with a
                    // simple foreach, making the code short and easy to read.
                    $product[$key] = array_shift($values);
    
                    // $product is by reference (that's why the key we added above
                    // will appear in the end result), so make a copy of it here
                    $copy = $product;
    
                    // Do step 2 above.
                    foreach($values as $item) {
                        $copy[$key] = $item;
                        $append[] = $copy;
                    }
    
                    // Undo the side effecst of array_shift
                    array_unshift($values, $product[$key]);
                }
    
                // Out of the foreach, we can add to $results now
                $result = array_merge($result, $append);
            }
        }
    
        return $result;
    }
    
}

?>