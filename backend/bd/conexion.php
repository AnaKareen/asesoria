<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

// Define database
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'asesoriapi');
define('DB_USER', 'admin');
define('DB_PASSWORD', 'admin123');
define('DB_PORT', '3306');
// Connecting database
try {
    $connect = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $connect->query("set names utf8;");
    // $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    //$connect->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
//---------------


class Config
{
    function getImageSize(){
        return 1024000;
    }

    function getImageType() {
        return array('image/png', 'image/jpeg');
    }
}
?>