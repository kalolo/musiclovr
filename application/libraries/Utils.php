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
    
    public static function fileZise($strFile) {
        if (file_exists($strFile)) {
            $bytes = filesize($strFile);
            if ($bytes < 1048576) {
                return round($bytes / 1024, 2) . ' Kb';
            } else {
                return round($bytes / 1048576, 2) . ' M';
            }
        }
        return 0;
    }
    
    public static function createZip($strZipName, $arrFiles) {
        $oZip       = new ZipArchive();
        $strZipName = self::slugger($strZipName).'.zip';
        $strZipPath = ALBUMS_FOLDER.$strZipName;
        if ($oZip->open($strZipPath, ZipArchive::CREATE)) {
            foreach ($arrFiles as $file) {
                $oZip->addFile($file);
            }
            $oZip->close();
            return $strZipName;
        } else {
            throw new Exception('No se pudo crear el archivo zip :(');
        }
    }
}
