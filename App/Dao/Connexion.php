<?php

namespace App\Dao;

use PDO;
use PDOException;

class Connexion
{
    /**
     * @var PDO|null A única instância estática da conexão PDO.
     */
    private static ?PDO $instance = null;

    /**
     * O método para obter a instância da conexão.
     * É a única forma pública de acessar a conexão.
     */
    public static function getInstance(): PDO
    {
        // Se a instância ainda não foi criada, cria-a.
        if (!self::$instance instanceof \PDO) {
            try {
                // Sua lógica de DSN usando a função env()
                $dsn = env('DB_ADAPTER', 'mysql') . ":"
                    . "host=" . env('DB_HOST', "localhost")
                    . ";dbname=" . env('DB_NAME', "")
                    . ";port=" . env('DB_PORT', "3306") # 5432
                    . ";charset=" . env('DB_CHARSET', "utf8mb4"); // É uma boa prática definir o charset aqui

                // Opções recomendadas para o PDO
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,       // Retorna objetos por padrão
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa prepares nativos do DB
                ];
                
                // Cria a instância do PDO e a armazena na propriedade estática
                self::$instance = new PDO(
                    $dsn,
                    env('DB_USER', 'root'),
                    env("DB_PASS", ''),
                    $options // Passa as opções para o construtor
                );

            } catch (PDOException $e) {
                // Se a conexão falhar, lança uma exceção para interromper a execução.
                // Em produção, você deve logar este erro em vez de exibi-lo.
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        // Retorna a instância já existente (ou a que acabamos de criar).
        return self::$instance;
    }

    /**
     * O construtor é privado para impedir a criação de instâncias com 'new Connexion()'.
     */
    private function __construct() {}

    /**
     * Impede que a instância única seja clonada.
     */
    private function __clone() {}
}