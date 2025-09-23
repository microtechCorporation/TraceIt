<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'dbsistema_tracemz');
define('DB_USER', 'root');
define('DB_PASS', 'elihudcl777');

function getConnection(){
    try{
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }

}



