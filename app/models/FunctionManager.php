<?php

namespace App\models;

class FunctionManager {

    public static function cutText($text, $limit)
    {
       if(strlen($text) > $limit)
           echo rtrim(mb_substr($text, 0, $limit, 'UTF-8'), "!,.-") .' ...';
           else {echo $text;}
    }

    public function removeItemArray($needle, $array, $column)
    {
        $key = array_search($needle, array_column($array, $column));
        unset($array[$key]);
        return $array;
    }

}