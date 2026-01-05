<?php

namespace App\trait;

use PDO;
use PDOException;
use InvalidArgumentException;

trait Dao
{
    private static ?PDO $db = null;

    /**
     * Obtém (ou cria) a ligação PDO.
     * Usa conexão persistente apenas em produção.
     */
    private static function connect(): PDO
    {
        if (self::$db instanceof \PDO) {
            return self::$db;
        }

        // Defina APP_ENV no seu .env ou servidor (“production”, “development” etc.)
        $env         = getenv('APP_ENV') ?: 'production';
        $isProd      = $env === 'production';

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            env('DATABASE_HOST', 'localhost'),
            env('DATABASE_NAME', 'db_sgh')
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        if ($isProd) {
            $options[PDO::ATTR_PERSISTENT] = true;   // só em produção
        }

        self::$db = new PDO(
            $dsn,
            env('DATABASE_HOST', 'localhost'),
            env('DATABASE_PASSWORD', ''),
            $options
        );

        return self::$db;
    }

    /**
     * (Opcional) força o encerramento da ligação.
     * Normalmente não é necessário, pois o PDO destrói sozinho ao fim do script.
     */
    public static function disconnect(): void
    {
        self::$db = null;
    }

    /* --------------------------------------------------------------------
     |        MÉTODOS PÚBLICOS (CRUD + statement genérico)                |
     --------------------------------------------------------------------*/

    public function select(string $sql, array $params = [])
    {
        $this->assertStartsWith($sql, 'SELECT');
        return $this->run($sql, $params);
    }

    /**
     * Retorna apenas um registro (primeiro encontrado) para SELECT com WHERE.
     */
    public function selectOne(string $sql, array $params = [])
    {
        $this->assertStartsWith($sql, 'SELECT');
        $result = $this->run($sql, $params);
        return is_array($result) && $result !== [] ? $result[0] : null;
    }

    public function insert(string $sql, array $params = [])
    {
        $this->assertStartsWith($sql, 'INSERT');
        return $this->run($sql, $params, true);   // devolve lastInsertId
    }

    public function update(string $sql, array $params = [])
    {
        $this->assertStartsWith($sql, 'UPDATE');
        return $this->run($sql, $params);
    }

    public function delete(string $sql, array $params = [])
    {
        $this->assertStartsWith($sql, 'DELETE');
        return $this->run($sql, $params);
    }

    /**
     * Executa DDL ou outras instruções (“CREATE TABLE”, “ALTER”, “TRUNCATE”…).
     * Bloqueia uso incorreto para SELECT/INSERT/UPDATE/DELETE.
     */
    public function statement(string $sql, array $params = [])
    {
        $verb = strtoupper(strtok(ltrim($sql), ' '));
        if (in_array($verb, ['SELECT', 'INSERT', 'UPDATE', 'DELETE'], true)) {
            throw new InvalidArgumentException(
                'Use select/insert/update/delete para instruções DML.'
            );
        }

        return $this->run($sql, $params);
    }

    /* --------------------------------------------------------------------
     |                         MÉTODOS INTERNOS                            |
     --------------------------------------------------------------------*/

    /**
     * Executa a query preparada e devolve resultado apropriado.
     * - SELECT → array de registros
     * - INSERT → id gerado
     * - UPDATE/DELETE/DDL → nº de linhas afectadas
     */
    private function run(string $sql, array $params = [], bool $returnLastId = false)
    {
        $pdo  = self::connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($returnLastId) {
            return $pdo->lastInsertId();
        }

        $verb = strtoupper(strtok(ltrim($sql), ' '));

        return $verb === 'SELECT'
            ? $stmt->fetchAll(PDO::FETCH_CLASS)
            : $stmt->rowCount();   // linhas afectadas
    }

    private function assertStartsWith(string $sql, string $verb): void
    {
        if (stripos(ltrim($sql), $verb) !== 0) {
            throw new InvalidArgumentException(
                'A instrução deve começar por ' . $verb
            );
        }
    }
}