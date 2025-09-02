<?php
require 'app/configs/routes.php';

//procesar as rotas
$request_uri = str_replace('/TraceMz', '', $_SERVER['REQUEST_URI']);
$request_uri = explode('?', $request_uri)[0]; 

// Verificar se a rota existe
if (array_key_exists($request_uri, $routes)) {
    require __DIR__ . '/' . $routes[$request_uri];
} else {
   
    require '404.php';
    exit();
    
} 
