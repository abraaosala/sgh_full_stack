<?php

namespace App\Dao;

use PDO;
use Closure;

trait Query
{
    private array $query = [];

    private array $params = [];

    public function newQuery(): self
    {
        $clone = clone $this;
        $clone->query = [];
        $clone->params = [];
        return $clone;
    }

    // MÉTODOS DE CONSTRUÇÃO DA QUERY

    public function select(string|array|null $fields = ['*']): self
    {
        if (is_array($fields)) {
            $fields = implode(",", $fields);
        }

        $this->query['select'] = $fields;
        return $this;
    }

    public function join(
        string $model,
        string $localKey,
        string $operator,
        string $foreignKey,
        ?string $alias = null,
        string $type = 'INNER'
    ): self {
        $table = (new $model)->getTable();
        $tableAlias = $alias ? sprintf('%s AS %s', $table, $alias) : $table;

        $this->query['join'][] = [
            'table'      => $table,
            'tableAlias' => $tableAlias,
            'localKey'   => $localKey,
            'operator'   => $operator,
            'foreignKey' => $foreignKey,
            'type'       => strtoupper($type),
            'alias'      => $alias,
        ];

        return $this;
    }

    public function where($field, $operator = null, $value = null, $logic = 'AND'): self
    {
        if ($field instanceof Closure) {
            $this->query['where'][] = ['type' => 'Nested', 'closure' => $field, 'logic' => strtoupper((string) $logic)];
            return $this;
        }

        $this->query['where'][] = ['type' => 'Simple', 'field' => $field, 'operator' => $operator, 'value' => $value, 'logic' => strtoupper((string) $logic)];
        return $this;
    }

    /**
     * MODIFICADO: orWhere agora suporta Closure para aninhar condições.
     *
     * @param string|Closure $field
     * @param string|null    $operator
     * @param mixed|null     $value
     */
    public function orWhere($field, $operator = null, $value = null): self
    {
        // Delega para o método 'where' principal, passando 'OR' como lógica.
        // Se $field for uma Closure, os outros argumentos serão ignorados pelo 'where' principal.
        return $this->where($field, $operator, $value, 'OR');
    }

    /**
     * MODIFICADO: andWhere agora suporta Closure para aninhar condições.
     *
     * @param string|Closure $field
     * @param string|null    $operator
     * @param mixed|null     $value
     */
    public function andWhere($field, $operator = null, $value = null): self
    {
        // Delega para o método 'where' principal, passando 'AND' como lógica.
        // Se $field for uma Closure, os outros argumentos serão ignorados pelo 'where' principal.
        return $this->where($field, $operator, $value, 'AND');
    }

    public function in(string $field, array $values): self
    {
        $this->query['in'][] = [$field, $values];
        return $this;
    }

    public function whereGroup(array $conditions, $logic = 'AND'): self
    {
        $this->query['whereGroup'][] = ['conditions' => $conditions, 'logic' => strtoupper((string) $logic)];
        return $this;
    }

    /**
     * Adiciona uma cláusula WHERE {field} IS NULL.
     * @param string $field O nome da coluna.
     * @param string $logic O operador lógico ('AND' ou 'OR').
     * @return $this
     */
    public function whereNull(string $field, string $logic = 'AND')
    {
        $this->query['whereNull'][] = [$field, 'IS NULL', strtoupper($logic)];
        return $this;
    }

    /**
     * Adiciona uma cláusula WHERE {field} IS NOT NULL.
     * @param string $field O nome da coluna.
     * @param string $logic O operador lógico ('AND' ou 'OR').
     * @return $this
     */
    public function whereNotNull(string $field, string $logic = 'AND')
    {
        $this->query['whereNull'][] = [$field, 'IS NOT NULL', strtoupper($logic)];
        return $this;
    }

    /* public function like(array $conditions, $logic = 'OR'): self
       {
           $this->query['like'][] = ['conditions' => $conditions, 'logic' => strtoupper($logic)];
           return $this;
       } */
    /**
     * Adiciona uma ou mais condições LIKE.
     * Suporta array de condições, condição única (array simples) ou Closure para aninhamento.
     * * @param array|\Closure $conditions Array de condições [field, value] ou uma Closure.
     * @param string $logic Lógica de combinação ('OR' ou 'AND') para as condições internas.
     * @return self
     */
    /* public function like($conditions, string $logic = 'OR'): self
        {
            // 1. TRATAMENTO DE CLOSURE (LIKE ANINHADO)
            if ($conditions instanceof \Closure) {
                $this->query['like'][] = [
                    'type' => 'Nested',
                    'closure' => $conditions,
                    'logic' => 'AND' // A lógica principal para agrupar o aninhamento
                ];
                return $this;
            };

            // Garante que $conditions seja um array, se não for, lança um erro (boa prática)
            if (!is_array($conditions)) {
                throw new \InvalidArgumentException("O método like() espera um array ou uma Closure.");
            }

            // 2. TRATAMENTO DE CONDIÇÃO ÚNICA
            // Se o array não contiver subarrays, é tratado como uma única condição: ['campo', 'valor']
            if (count($conditions) === 2 && is_string($conditions[0])) {
                $conditions = [$conditions]; // Envolve em um array para tratar como grupo
            }
            // Nota: Se não for uma Closure, nem uma condição única, assume-se que é um array de grupos.

            // 3. TRATAMENTO DE GRUPO SIMPLES (seu original)
            $this->query['like'][] = [
                'type' => 'Group',
                'conditions' => $conditions,
                'logic' => strtoupper($logic) // 'OR' ou 'AND' para combinar as condições do grupo
            ];

            return $this;
        } */
    /**
     * Adiciona uma ou mais condições LIKE.
     * A sintaxe é flexível:
     * 1. Condição Única: like('field', 'value', 'AND/OR')
     * 2. Grupo: like([['field1', 'value1'], ['field2', 'value2']], 'OR/AND')
     * 3. Aninhado: like(function($q) { ... })
     * * @param string|array|\Closure $field O nome do campo (se for condição única), um array de condições (grupo), ou uma Closure (aninhamento).
     * @param mixed $value O valor a ser comparado, se o primeiro argumento for o nome do campo.
     * @param string $logic Lógica de combinação ('OR' ou 'AND').
     */
    public function like($field, $value = null, string $logic = 'OR'): self
    {
        // A lógica de combinação padrão para o grupo ou condição única
        $logic = strtoupper($logic);

        // =================================================================
        // 1. TRATAMENTO DE CLOSURE (LIKE ANINHADO)
        // Se o primeiro argumento for uma Closure, é um LIKE aninhado.
        // =================================================================
        if ($field instanceof \Closure) {
            $this->query['like'][] = [
                'type' => 'Nested',
                'closure' => $field,
                'logic' => 'AND' // Lógica principal para agrupar o bloco aninhado
            ];
            return $this;
        }

        // =================================================================
        // 2. TRATAMENTO DA CONDIÇÃO ÚNICA (Nova sintaxe: field, value, logic)
        // Se o primeiro argumento for string E o segundo valor for fornecido.
        // =================================================================
        if (is_string($field) && $value !== null) {
            // É uma condição única. Criamos um grupo simples com ela.
            $conditions = [[$field, $value]];

            $this->query['like'][] = [
                'type' => 'Group',
                'conditions' => $conditions,
                'logic' => $logic // 'OR' ou 'AND'
            ];
            return $this;
        }

        // =================================================================
        // 3. TRATAMENTO DE GRUPO (Sintaxe original: array de condições, logic)
        // =================================================================
        if (is_array($field)) {
            $conditions = $field;

            // Se a sintaxe original for usada, a lógica é passada no segundo parâmetro.
            // Se o $value (agora lógica) não for null, ele sobrepõe o $logic padrão.
            if ($value !== null && is_string($value)) {
                $logic = strtoupper($value);
            }

            // Trata o caso onde o usuário chamou like(['campo', 'valor'], 'OR') - que é o antigo caso de Condição Única.
            if (count($conditions) === 2 && is_string($conditions[0])) {
                $conditions = [$conditions];
            }

            $this->query['like'][] = [
                'type' => 'Group',
                'conditions' => $conditions,
                'logic' => $logic
            ];
            return $this;
        }

        throw new \InvalidArgumentException("Sintaxe inválida para o método like(). Os argumentos devem ser 'campo, valor, lógica', 'array de condições, lógica' ou 'Closure'.");
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->query['order'][] = [$field, strtoupper($direction)];
        return $this;
    }

    public function groupBy(string ...$fields): self
    {
        $this->query['groupBy'] = $fields;
        return $this;
    }

    public function having(string $field, string $operator, string $value, $logic = 'AND'): self
    {
        $this->query['having'][] = [$field, $operator, $value, strtoupper((string) $logic)];
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->query['limit'] = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->query['offset'] = $offset;
        return $this;
    }

    public function toSql(): string
    {
        return $this->transform();
    }

    private function transform(): string
    {
        $query = $this->buildSelect();
        $query .= $this->buildJoins();
        $query .= $this->buildWheres();
        $query .= $this->buildGroupBy();
        $query .= $this->buildHavings();
        $query .= $this->buildOrderBy();
        $query .= $this->buildLimit();
        $query .= $this->buildOffset();

        return trim($query);
    }

    private function buildSelect(): string
    {
        $fields = $this->query['select'] ?? '*';
        return sprintf('SELECT %s FROM %s', $fields, $this->table);
    }

    private function buildJoins(): string
    {
        $sql = '';
        if (!empty($this->query['join'])) {
            foreach ($this->query['join'] as $join) {
                $sql .= sprintf(' %s JOIN %s ON %s %s %s', $join['type'], $join['tableAlias'], $join['localKey'], $join['operator'], $join['foreignKey']);
            }
        }

        return $sql;
    }



    protected function buildWheres(): string
    {

        if (empty($this->query['where']) && empty($this->query['in']) && empty($this->query['whereGroup']) && empty($this->query['like']) && empty($this->query['whereNull'])) {
            return '';
        }

        $clauses = [];
        $fieldCount = [];

        $addClause = function (string $clause, string $logic = 'AND') use (&$clauses) {
            $clauses[] = $clauses === [] ? $clause : $logic . ' ' . $clause;
        };

        if (isset($this->query['whereNull'])) {
            foreach ($this->query['whereNull'] as [$field, $operator, $logic]) {
                // O $operator será 'IS NULL' ou 'IS NOT NULL'
                $addClause(sprintf('%s %s', $field, $operator), $logic);
            }
        }

        // WHERE IN (lógica original mantida)
        if (isset($this->query['in'])) {
            foreach ($this->query['in'] as $inCondition) {
                $placeholders = [];
                foreach ($inCondition[1] as $value) {
                    $placeholder = ':' . preg_replace('/\W/', '', (string) $inCondition[0]) . count($this->params);
                    $placeholders[] = $placeholder;
                    $this->params[$placeholder] = $value;
                }

                $addClause($inCondition[0] . ' IN (' . implode(', ', $placeholders) . ")");
            }
        }

        // WHERE simples e aninhado
        if (isset($this->query['where'])) {
            foreach ($this->query['where'] as $where) {
                $logic = $where['logic'];

                if ($where['type'] === 'Nested') {
                    $nestedBuilder = $this->newQuery();
                    $where['closure']($nestedBuilder);

                    $nestedSql = ltrim($nestedBuilder->buildWheres());
                    if (stripos($nestedSql, 'WHERE ') === 0) {
                        $nestedSql = substr($nestedSql, 6);
                    }

                    if ($nestedSql !== '' && $nestedSql !== '0') {
                        $addClause(sprintf('(%s)', $nestedSql), $logic);
                        $this->params = array_merge($this->params, $nestedBuilder->getParams());
                    }

                    continue;
                }

                $field = $where['field'];
                if (!isset($fieldCount[$field])) {
                    $fieldCount[$field] = 0;
                }

                $fieldCount[$field]++;
                $placeholder = ':' . preg_replace('/\W/', '', (string) $field) . ($fieldCount[$field] > 1 ? '_' . $fieldCount[$field] : '');

                $addClause(sprintf('%s %s %s', $field, $where['operator'], $placeholder), $logic);
                $this->params[$placeholder] = $where['value'];
            }
        }

        // WHERE GROUP (lógica original mantida)
        if (isset($this->query['whereGroup'])) {
            foreach ($this->query['whereGroup'] as $group) {
                $groupConditions = $group['conditions'];
                $groupLogic = $group['logic'];
                $groupClauses = [];

                foreach ($groupConditions as [$field, $operator, $value]) {
                    if (!isset($fieldCount[$field])) {
                        $fieldCount[$field] = 0;
                    }

                    $fieldCount[$field]++;
                    $placeholder = ':' . preg_replace('/\W/', '', (string) $field) . '_group_' . $fieldCount[$field];
                    $groupClauses[] = sprintf('%s %s %s', $field, $operator, $placeholder);
                    $this->params[$placeholder] = $value;
                }

                $groupSql = '(' . implode(sprintf(' %s ', $groupLogic), $groupClauses) . ')';
                $addClause($groupSql, $groupLogic);
            }
        }

        // LIKE (lógica original mantida)
        /* if (isset($this->query['like'])) {
            foreach ($this->query['like'] as $likeGroup) {
                $conditions = $likeGroup['conditions'];
                $logic = $likeGroup['logic'];
                $likeClauses = [];

                foreach ($conditions as $index => [$field, $value]) {
                    if (!isset($fieldCount[$field])) $fieldCount[$field] = 0;
                    $fieldCount[$field]++;
                    $placeholder = ':' . preg_replace('/\W/', '', $field) . '_like_' . $fieldCount[$field];
                    $likeClauses[] = "$field LIKE $placeholder";
                    $this->params[$placeholder] = "%$value%";
                }

                $groupSql = '(' . implode(" {$logic} ", $likeClauses) . ')';
                $addClause($groupSql, 'AND');
            }
        } */

        // LIKE (Lógica ATUALIZADA para aceitar Closure)
        if (isset($this->query['like'])) {
            foreach ($this->query['like'] as $likeGroup) {
                $logic = $likeGroup['logic'];

                // === NOVO: Tratar Closure (LIKE Aninhado) ===
                if ($likeGroup['type'] === 'Nested') {
                    $nestedBuilder = $this->newQuery();
                    $likeGroup['closure']($nestedBuilder);

                    // Constrói o WHERE aninhado
                    $nestedSql = ltrim($nestedBuilder->buildWheres());

                    // Remove "WHERE " se estiver no início
                    if (stripos($nestedSql, 'WHERE ') === 0) {
                        $nestedSql = substr($nestedSql, 6);
                    }

                    if ($nestedSql !== '' && $nestedSql !== '0') {
                        // Adiciona a cláusula aninhada (já com WHEREs internos)
                        $addClause(sprintf('(%s)', $nestedSql), $logic);
                        // Mescla os parâmetros do builder aninhado
                        $this->params = array_merge($this->params, $nestedBuilder->getParams());
                    }

                    continue; // Pula para a próxima condição
                }

                // === FIM DO NOVO TRATAMENTO ===

                // Lógica de Group LIKE (sua lógica original mantida)
                $conditions = $likeGroup['conditions'];
                $likeClauses = [];

                foreach ($conditions as [$field, $value]) {
                    if (!isset($fieldCount[$field])) {
                        $fieldCount[$field] = 0;
                    }

                    $fieldCount[$field]++;
                    $placeholder = ':' . preg_replace('/\W/', '', (string) $field) . '_like_' . $fieldCount[$field];
                    $likeClauses[] = sprintf('%s LIKE %s', $field, $placeholder);
                    $this->params[$placeholder] = sprintf('%%%s%%', $value);
                }

                $groupSql = '(' . implode(sprintf(' %s ', $logic), $likeClauses) . ')';
                $addClause($groupSql, 'AND'); // Adiciona o grupo de OR/AND LIKEs com AND principal
            }
        }

        return $clauses === [] ? '' : ' WHERE ' . implode(' ', $clauses);
    }


    private function buildGroupBy(): string
    {
        if (!isset($this->query['groupBy'])) {
            return '';
        }

        return ' GROUP BY ' . implode(', ', $this->query['groupBy']);
    }

    private function buildHavings(): string
    {
        if (!isset($this->query['having'])) {
            return '';
        }

        // Implementação da lógica HAVING
        return '';
    }

    private function buildOrderBy(): string
    {
        if (!isset($this->query['order'])) {
            return '';
        }

        $orderParts = [];
        foreach ($this->query['order'] as [$field, $direction]) {
            $orderParts[] = sprintf('%s %s', $field, $direction);
        }

        return ' ORDER BY ' . implode(', ', $orderParts);
    }

    private function buildLimit(): string
    {
        if (!isset($this->query['limit'])) {
            return '';
        }

        return ' LIMIT ' . $this->query['limit'];
    }

    private function buildOffset(): string
    {
        if (!isset($this->query['offset'])) {
            return '';
        }

        return ' OFFSET ' . $this->query['offset'];
    }

    public function get()
    {
        $query = $this->transform();
        $params = $this->params;
        return empty($params) ? $this->read($query) : $this->read($query, $params);
    }

    public function first()
    {
        $this->limit(1);
        $query = $this->transform();
        $params = $this->params;
        return empty($params) ? $this->readOne($query) : $this->readOne($query, $params);
    }

    public function toArray()
    {
        $get = $this->get();
        return convertData($get);
    }

    public function toArrayOne()
    {
        $get = $this->first();
        return $this->convert($get);
    }

    public function toJson()
    {
        header('Content-Type: application/json');
        http_response_code(202);

        return json_encode($this->toArray());
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function paginate($perPage = 10)
    {
        $paginator = new Paginator($this, $perPage);
        return $paginator->paginate();
    }

    public function setSelect(string $fields): self
    {
        $this->query['select'] = $fields;
        return $this;
    }

    public function removeClause(string $clause): self
    {
        unset($this->query[$clause]);
        return $this;
    }

    public function hasClause(string $clause): bool
    {
        return !empty($this->query[$clause]);
    }
}