<?php 

require(__DIR__ ."/bootstrap.php");
$host = env('DB_HOST', 'localhost');
$user = env('DB_USER',"root");
$pass = env('DB_PASS',""); // Coloque sua senha aqui
$dbname = env('DB_NAME', "sgh");

try {
    // Conecta ao servidor MySQL
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Comando SQL para criar o banco
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    // Executa o comando
    $pdo->exec($sql);

    echo "Banco de dados '$dbname' criado com sucesso!";

} catch (PDOException $e) {
    echo "Erro ao criar o banco: " . $e->getMessage();
}

// Fecha a conexão
$pdo = null;
?>