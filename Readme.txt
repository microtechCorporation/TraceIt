<?php
require_once 'app/configs/routes.php';
$url = $_SERVER['REQUEST_URI'];
route($url);
?>