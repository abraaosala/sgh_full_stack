<?php

namespace App\Dao\Models;

use App\Dao\Connexion;
use App\Dao\Crud;
use App\Dao\Entity\Entity;
use App\Dao\interfaces\RelationShipInterface;
use App\Dao\Query;
use Exception;

use PDO;

abstract class Model
{
    use Crud;
    use Query;

    // Usa o trait Crud & Query
    protected string $table;

     // Nome da tabela associada ao modelo
    protected  $entity;



    // Obtém a entidade associada ao modelo

    public function __construct(?string $entity = null)
    {

        if (!in_array($entity, [null, '', '0'], true)) {
            $this->entity = new $entity;
        }

        // AGORA, EM VEZ DE CRIAR UMA NOVA CONEXÃO,
        // NÓS PEGAMOS A INSTÂNCIA ÚNICA JÁ EXISTENTE.
        $connexion = Connexion::getInstance();

        $this->initCrud($connexion); // Inicializa a conexão no modelo

    }

    public function getEntity()
    {
        $class = getClassShorName(static::class);
        $entityShortName = $class . 'Entity';
        $entity = NAMESPACE_ENTITY . $entityShortName;

        if (!class_exists($entity)) {
            throw new Exception(sprintf('A Classe %s não existe', $entityShortName));
        }

        return $entity;
    }

    public function setEntity()
    {
        return $this->entity;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function query(string $sql, ?array $params = [])
    {
        if ($params !== null && $params !== []) {
            return $this->read($sql, $params);
        }

        return $this->read($sql);
    }

    // Retorna todos os registros da tabela
    public function all($fields = "*")
    {
        // $query= "SELECT {$fields} FROM {$this->table}";
        return $this->select($fields)->get();
        // return $this->read($query);
    }

    public function all_find(?array $where = [], string $fields = "*")
    {
    }


    // Retorna a contagem total de registros na tabela
    public function count()
    {
        $query = 'SELECT count(*) as total FROM ' . $this->table;

        return $this->read($query)[0];
    }

    // Insere um novo registro na tabela
    public function store(?object $entity = null)
    {
        //
        $entity = $this->entity->getAtributes() ?? $entity->getAtributes();

        $query = sprintf('INSERT INTO %s (', $this->table);
        $query .= implode(', ', array_keys($entity)) . ')';

        $query .= " VALUES( :" . implode(', :', array_keys($entity)) . ')';


        $params = $this->prepareParams($entity);

        // return $params;
        return $this->insert($query, $params);
    }

    /**
     * INSERE MÚLTIPLOS registros (batch insert) na tabela.
     *
     * @param array $data O array de dados. Pode ser:
     * 1. Um array de objetos [entity1, entity2, ...]
     * 2. Um array de arrays associativos [['name' => 'A'], ['name' => 'B']]
     * @return bool|array O resultado da inserção (depende do seu método $this->insert)
     */
    public function storeBatch(array $data)
    {
        if ($data === []) {
            return false; // Nada para inserir
        }

        // --- 1. Pegar as colunas (do primeiro item) ---
        // Assume que todos os itens do aMrray têm a mesma estrutura
        $firstItem = reset($data); 
        $attributes = [];

        if (is_object($firstItem) && method_exists($firstItem, 'getAtributes')) {
            $attributes = $firstItem->getAtributes();
        } elseif (is_array($firstItem)) {
            $attributes = $firstItem;
        } else {
            // Formato de dados inválido
            throw new \InvalidArgumentException("Os dados devem ser um array de objetos (com getAtributes) ou um array de arrays associativos.");
        }

        $columns = array_keys($attributes);
        $columnList = implode(', ', $columns); // "name, email, age"
        $numColumns = count($columns);

        // --- 2. Preparar os placeholders (?) ---

        // Cria a string "(?, ?, ?)" (uma vez, baseado no número de colunas)
        $rowPlaceholder = '(' . implode(', ', array_fill(0, $numColumns, '?')) . ')';

        // --- 3. Preparar a query e os valores ---

        // $allPlaceholders vai virar: [ "(?,?,?)", "(?,?,?)", "(?,?,?)" ]
        $allPlaceholders = []; 

        // $allValues vai ter todos os valores em um único array plano:
        // [ 'Nome1', 'email1', 'Nome2', 'email2', 'Nome3', 'email3' ]
        $allValues = []; 

        foreach ($data as $item) {
            // Pega os dados do item atual
            $itemData = [];
            if (is_object($item) && method_exists($item, 'getAtributes')) {
                $itemData = $item->getAtributes();
            } elseif (is_array($item)) {
                $itemData = $item;
            }

            if (empty($itemData)) {
                continue;
            }

            // Adiciona o "(?, ?, ?)" para esta linha
            $allPlaceholders[] = $rowPlaceholder;

            // Adiciona os valores REAIS, na ordem correta das colunas
            foreach ($columns as $column) {
                // Adiciona o valor (ou null se não existir naquela linha)
                $allValues[] = $itemData[$column] ?? null;
            }
        }

        // --- 4. Montar a query final ---
        // Ex: INSERT INTO users (name, email) VALUES (?, ?), (?, ?), (?, ?)
        $query = sprintf('INSERT INTO %s (%s) VALUES ', $this->table, $columnList);
        $query .= implode(', ', $allPlaceholders);

        // ---  Executar ---
        // O método `prepareParams` NÃO é usado aqui.
        // O método `insert` deve ser capaz de lidar com parâmetros posicionais (o PDO::execute($allValues) faz isso).
        return $this->insert($query, $allValues);
    }


    // Cria uma relação entre modelos
    private function relation(string $class, string $relation, string $property, array $results)
    {
        if (!class_exists($class)) {
            throw new Exception(sprintf('Model %sdoes not exist', $class));
        }

        if (!class_exists($relation)) {
            throw new Exception(sprintf('Relation %s does not exist', $relation));
        }

        $relation = new $relation;

        if (!$relation instanceof RelationShipInterface) {
            throw new Exception(sprintf('Class %s is not type of RelationShipInterface', $relation));
        }

        return $relation->createWith(
            static::class,
            $class,
            $property,
            $results
        );
    }

    // Prepara os bindings para a atualização
    private function prepareUpdateBindings(array $data): array
    {
        $bindings = [];
        foreach (array_keys($data) as $bind) {
            $bindings[] = sprintf('%s = :%s', $bind, $bind);
        }

        return $bindings;
    }

    // Salva (atualiza) um registro na tabela
    public function save($field = 'id', ?Entity $entity = null)
    {
        $data = $this->entity->getAtributes() ?? $entity->getAtributes();
        $id = $data[$field];
        unset($data[$field]);

        $sql = sprintf('UPDATE %s SET ', $this->table);
        $dateSet = $this->prepareUpdateBindings($data);
        $dateSet = implode(", ", $dateSet);

        $sql .= $dateSet;
        $sql .= sprintf(' WHERE %s = :id', $field);
        $params = $this->prepareParams($data, $id);

        // return $params;
        return $this->update($sql, $params);
    }

      /**
     * Salva (atualiza) MÚLTIPLOS registros (batch update) na tabela.
     * Usa uma sintaxe SQL "CASE WHEN" para eficiência.
     *
     * @param array $data O array de dados. Pode ser:
     * 1. Um array de objetos [entity1, entity2, ...]
     * 2. Um array de arrays associativos [['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']]
     * @param string $field A coluna que serve como chave primária (ex: 'id')
     * @return bool|array O resultado da atualização
     */
    public function saveBatch(array $data, string $field = 'id')
    {
        if ($data === []) {
            return false;
        }

        $columnsToUpdate = [];

        // Pega as colunas do primeiro item (assume que todos são iguais)
        $firstItem = reset($data);
        if (is_object($firstItem) && method_exists($firstItem, 'getAtributes')) {
            $attributes = $firstItem->getAtributes();
        } elseif (is_array($firstItem)) {
            $attributes = $firstItem;
        } else {
            throw new \InvalidArgumentException("Formato de dados inválido.");
        }

        // Remove a chave primária ($field) da lista de colunas a atualizar
        unset($attributes[$field]);
        $columnsToUpdate = array_keys($attributes);

        if ($columnsToUpdate === []) {
            return false; // Nada para atualizar
        }

        // --- 2. Construir as cláusulas CASE ---
        $caseStatements = []; // Para cada coluna: "name = CASE id WHEN ? THEN ? ... END"
        $allParams = [];      // Array plano com todos os parâmetros para o PDO
        $whereInParams = [];  // Array apenas com os IDs para o "WHERE IN"

        foreach ($columnsToUpdate as $column) {
            // Inicia o CASE para esta coluna
            // Ex: "name = CASE id "
            $sqlCase = sprintf('%s = CASE %s ', $column, $field); 

            foreach ($data as $item) {
                // Pega os dados do item (objeto ou array)
                $itemData = [];
                if (is_object($item) && method_exists($item, 'getAtributes')) {
                    $itemData = $item->getAtributes();
                } elseif (is_array($item)) {
                    $itemData = $item;
                }

                $idValue = $itemData[$field] ?? null;
                $updateValue = $itemData[$column] ?? null;

                if ($idValue === null) {
                    continue; // Pula item sem ID
                }

                // Adiciona: "WHEN ? THEN ? "
                $sqlCase .= "WHEN ? THEN ? ";

                // Adiciona os valores na ordem correta para o PDO
                $allParams[] = $idValue;
                $allParams[] = $updateValue;

                // Adiciona o ID à lista do WHERE IN (apenas na primeira iteração das colunas)
                if ($column === $columnsToUpdate[0]) {
                    $whereInParams[] = $idValue;
                }
            }

            $sqlCase .= "END";
            $caseStatements[] = $sqlCase;
        }

        // --- 3. Montar a Query Final ---
        // Ex: UPDATE users SET name = CASE id ... END, email = CASE id ... END
        $sql = sprintf('UPDATE %s SET ', $this->table);
        $sql .= implode(', ', $caseStatements);

        // Cria os placeholders para o "WHERE IN (?, ?, ?)"
        $inPlaceholders = implode(', ', array_fill(0, count($whereInParams), '?'));
        $sql .= sprintf(' WHERE %s IN (%s)', $field, $inPlaceholders);

        // Adiciona os parâmetros do WHERE IN ao final da lista de parâmetros
        $allParams = array_merge($allParams, $whereInParams);

        // --- 4. Executar ---
        // $this->prepareParams não é usado aqui, pois usamos parâmetros posicionais (?)
        return $this->update($sql, $allParams);
    }


    // Prepara os parâmetros para a consulta
    private function prepareParams(array $data, $id = null): array
    {
        $params = [];
        foreach ($data as $key => $item) {

            $params[':' . $key] = $item;
        }

        if (!empty($id)) {
            $params[":id"] = $id;
        }

        return $params;
    }

    public function find(string $value, string $field, $fields = "*")
    {
        return $this->newQuery()->select($fields)
            ->where($field, "=", $value)
            ->toSql();
    }

    public function findByConditions(array $conditions, $fields = "*"): array
    {
        $query = $this->select($fields);

        foreach ($conditions as $field => $value) {
            $query = $query->where($field, '=', $value);
        }

        return $query->get();
    }


    public function findById(int $value, string $fields = "*")
    {
        return $this->select($fields)
            ->where('id', "=", $value)
            ->first();
    }

    public function findIn(string $field, array $conjunts, string $fields = '*')
    {
        return $this->select($fields)->in($field, $conjunts)->get();
    }

    // Encontra registros na tabela com base em uma lista de IDs
    public function relatedWith($ids, string $field = 'id')
    {

        // $conn = Connexion::connect();
        $sql = sprintf('SELECT * FROM %s WHERE %s in(', $this->table, $field) . implode(',', $ids) . ")";
        return $this->read($sql);
    }


    // Cria relações com outros modelos
    public function makeRelationsWith(array ...$relations)
    {
        $results = $this->all();
        $relationCreate = [];

        foreach ($relations as $relationArray) {
            if (count($relationArray) !== 3) {
                throw new \Exception("Deve ter 3 parametros no method");
            }

            [$class, $relation, $property] = $relationArray;
            $relationCreate[] = $this->relation($class, $relation, $property, $results);
        }

        if (count($relationCreate) === 1) {
            return $relationCreate[0]->items;
        }

        return $this->makeManyRelations(...$relationCreate);
    }

    // Cria múltiplas relações
    private function makeManyRelations(...$relation)
    {
        $relation1 = $relation[0];
        unset($relation[0]);

        foreach ($relation as $value) {
            $withName = $value->WithName ?? '';
            foreach ($value->items as $key => $object) {
                if (!property_exists($relation1->items[$key], $withName) && !empty($withName)) {
                    # code...
                    $relation1->items[$key]->$withName = $object->$withName;
                }
            }
        }

        return $relation1->items;
    }

    /**
     * Exclui um registro da tabela com base em um campo específico.
     *-
     * @param mixed  $value Valor do campo (ex: ID)
     * @param string $field Nome do campo (padrão: 'id')
     * @return bool True em caso de sucesso, False em caso de falha
     */
    public function remove(mixed $value, string $field = 'id'): bool
    {
        if (empty($value) || ($field === '' || $field === '0')) {
            return false; // Evita delete sem condição
        }

        $sql = sprintf('DELETE FROM %s WHERE %s = :%s', $this->table, $field, $field);
        $params = [':' . $field => $value];

        return $this->delete($sql, $params);
    }


    public function withRelation(array $items, string $relation, string $modelClass, ?string $foreignKey = null)
    {
        $foreignKey ??= $relation . '_id';

        if (!class_exists($modelClass)) {
            throw new \Exception(sprintf('Classe %s não encontrada.', $modelClass));
        }

        $modelInstance = new $modelClass();

        foreach ($items as $item) {
            // echo "Processing item with ID: {$item->$foreignKey}\n"; // Debugging line
            $id = $item->$foreignKey ?? null;

            $item->$relation = $id ? $modelInstance->select()->where('id', '=', $id)->first() ?? null : null;
        }
    }


    // Remove múltiplos registros comparando um campo com vários valores
    public function removeComparing(array $values, string $field = 'id')
    {
        if ($values === []) {
            return false;
        }

        $placeholders = [];
        $params = [];
        foreach ($values as $index => $value) {
            $ph = sprintf(':%s_%s', $field, $index);
            $placeholders[] = $ph;
            $params[$ph] = $value;
        }

        $in = implode(',', $placeholders);
        $sql = sprintf('DELETE FROM %s WHERE %s IN (%s)', $this->table, $field, $in);
        return $this->delete($sql, $params);
    }

    public function namesget()
    {
        return $this;
    }

    public function truncate()
    {
        $sql = 'truncate table ' . $this->table;
        return $this->statement($sql);
    }



    public function check($id): bool
    {
        return (bool) $this->findById($id);
    }


    /**
     *
     * Verificar se existe a chave unica
     *  * @param string $value
     * @return boolean
     */
    public function unique(string $value, string $field)
    {
        return (bool) $this->newQuery()->select()
            ->where($field, '=', $value)
            ->first();
    }

    /**
     * 
     **/
    public function convert($data)
    {
        if ($data instanceof Entity) {
            // Se for um único objeto Entity
            $data = $data->getAtributes();
        } elseif (is_array($data)) {
            // Se for um array, mapeia normalmente
            $data = array_map(function ($value) {
                if ($value instanceof Entity) {
                    return $value->getAtributes();
                }

                return $value;
            }, $data);
        }

        return $data;
    }
}