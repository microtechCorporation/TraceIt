<?php

// Habilitar exibição de erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir o arquivo de configuração do banco de dados
require_once 'app/configs/database.php';

// Instanciar a classe Database e tentar conectar
$database = new Database();
$conn = $database->connect();

// Verificar se a conexão foi bem-sucedida
if ($conn) {
    echo "Conexão com o banco de dados 'traceit' bem-sucedida!";
} else {
    echo "Falha na conexão com o banco de dados.";
}

?>