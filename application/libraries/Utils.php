<?php
class Utils {
    
    public static function slugger($strString) {
        setlocale(LC_ALL, 'en_US.UTF8');
        $strString = iconv('UTF-8', 'ASCII//TRANSLIT', $strString);
        $strString = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $strString);
        $strString = strtolower(trim($strString, '-'));
        $strString = preg_replace("/[\/_|+ -]+/", '-', $strString);
        return $strString;
    }
}
