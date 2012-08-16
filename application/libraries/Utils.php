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
    
    public static function moveSong($fileName, $currentPath, $folderSlug) {
        $fileName = str_replace('.mp3','',$fileName);
        $fileName = self::slugger(date('Ymd_His_').$fileName);
        $fileName .= '.mp3';
        $newPath  = MP3_FOLDER.$folderSlug;
        if (!file_exists($newPath)) {
            mkdir($newPath);
        }
        move_uploaded_file($currentPath, $newPath.'/'.$fileName);
        return $folderSlug.'/'.$fileName;
    }
}
