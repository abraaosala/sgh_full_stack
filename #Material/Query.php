<?php

namespace App\Dao;

use App\Dao\Models\Model;
use PDO;

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

    public function select(string $fields = '*'): self
    {
        $this->query['select'] = $fields;
        return $this;
    }

    /*  public function join(string $model, string $localKey, string $operator, string $foreignKey, $type = 'INNER'): self
    {
        $table = (new $model)->getTable();
        $this->query['join'][] = [$table, $localKey, $operator, $foreignKey, strtoupper($type)];
        return $this;
    } */
    /*  public function join(string $model, string $localKey, string $operator, string $foreignKey, $type = 'INNER'): self
    {
        $table = (new $model)->getTable();
        // Armazena as strings completas que você passou
        $this->query['join'][] = [$table, $localKey, $operator, $foreignKey, strtoupper($type)];
        return $this;
    } */

    public function join(
        string $model,
        string $localKey,
        string $operator,
        string $foreignKey,
        ?string $alias = null,
        string $type = 'INNER'
    ): self {
        $table = (new $model)->getTable();
        $tableAlias = $alias ? "$table AS $alias" : $table;

        // Armazena a estrutura do JOIN com alias aplicado
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
    public function where(string $field, string $operator, string $value, $logic = 'AND'): self
    {
        $this->query['where'][] = [$field, $operator, $value, strtoupper($logic)];
        return $this;
    }

    public function orWhere(string $field, string $operator, string $value): self
    {
        return $this->where($field, $operator, $value, 'OR');
    }
    public function andWhere(string $field, string $operator, string $value): self
    {
        return $this->where($field, $operator, $value, 'AND');
    }

    public function in(string $field, array $values): self
    {
        $this->query['in'][] = [$field, $values];
        return $this;
    }

    public function whereGroup(array $conditions, $logic = 'AND'): self
    {
        $this->query['whereGroup'][] = ['conditions' => $conditions, 'logic' => strtoupper($logic)];
        return $this;
    }

    public function like(array $conditions, $logic = 'OR'): self
    {
        $this->query['like'][] = ['conditions' => $conditions, 'logic' => strtoupper($logic)];
        return $this;
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
        $this->query['having'][] = [$field, $operator, $value, strtoupper($logic)];
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


    // MÉTODO CENTRAL DE TRANSFORMAÇÃO

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

    // MÉTODOS AUXILIARES DE CONSTRUÇÃO (BUILDERS)

    private function buildSelect(): string
    {
        $fields = $this->query['select'] ?? '*';
        return "SELECT {$fields} FROM {$this->table}";
    }

    /*  private function buildJoins(): string
    {
        $sql = '';
        if (isset($this->query['join'])) {
            foreach ($this->query['join'] as $join) {
                $sql .= " {$join[4]} JOIN {$join[0]} ON {$join[1]} {$join[2]} {$join[3]}";
            }
        }
        return $sql;
    } */

   /*  private function buildJoins(): string
    {
        $sql = '';
        if (isset($this->query['join'])) {
            foreach ($this->query['join'] as $join) {
                // $join[1] é 'agendas.medico_id', $join[3] é 'medicos.id', etc.
                $sql .= " {$join[4]} JOIN {$join[0]} ON {$join[1]} {$join[2]} {$join[3]}";
            }
        }
        return $sql;
    } */
   private function buildJoins(): string
{
    $sql = '';

    if (!empty($this->query['join'])) {
        foreach ($this->query['join'] as $join) {
            $joinType     = $join['type'] ?? 'INNER';
            $tableAlias   = $join['tableAlias'] ?? $join['table']; // 'usuarios AS usuario_paciente' ou 'usuarios'
            $localKey     = $join['localKey'];
            $operator     = $join['operator'];
            $foreignKey   = $join['foreignKey'];

            $sql .= " {$joinType} JOIN {$tableAlias} ON {$localKey} {$operator} {$foreignKey}";
        }
    }

    return $sql;
}


    /*   private function buildWheres(): string
    {
        $whereClauses = [];
        $fieldCount = [];

        // Lógica para todos os tipos de WHERE
        // ... (Implementação detalhada abaixo) ...
        
        if (empty($whereClauses)) {
            return '';
        }

        return ' WHERE ' . implode(' ', $whereClauses);
    } */

    // A lógica de construção dos WHEREs precisa ser unificada.
    // Esta é uma implementação mais robusta para `buildWheres`.
    protected function buildWheres(): string
    {
        if (empty($this->query['where']) && empty($this->query['in']) && empty($this->query['whereGroup']) && empty($this->query['like'])) {
            return '';
        }

        $clauses = [];
        $fieldCount = []; // Para evitar colisão de placeholders

        $addClause = function (string $clause, string $logic = 'AND') use (&$clauses) {
            if (empty($clauses)) {
                $clauses[] = $clause;
            } else {
                $clauses[] = $logic . ' ' . $clause;
            }
        };

        // WHERE IN
        if (isset($this->query['in'])) {
            foreach ($this->query['in'] as $inCondition) {
                $placeholders = [];
                foreach ($inCondition[1] as $value) {
                    $placeholder = ':' . preg_replace('/\W/', '', $inCondition[0]) . count($this->params);
                    $placeholders[] = $placeholder;
                    $this->params[$placeholder] = $value;
                }
                $addClause("{$inCondition[0]} IN (" . implode(', ', $placeholders) . ")");
            }
        }

        // WHERE simples
        if (isset($this->query['where'])) {
            foreach ($this->query['where'] as $where) {
                $field = $where[0];
                if (!isset($fieldCount[$field])) $fieldCount[$field] = 0;
                $fieldCount[$field]++;
                $placeholder = ':' . preg_replace('/\W/', '', $field) . ($fieldCount[$field] > 1 ? '_' . $fieldCount[$field] : '');

                $addClause("$field {$where[1]} $placeholder", $where[3]);
                $this->params[$placeholder] = $where[2];
            }
        }

        // Outros builders (whereGroup, like) seguiriam padrão similar...
        // WHERE GROUP
        if (isset($this->query['whereGroup'])) {
            foreach ($this->query['whereGroup'] as $group) {
                $groupConditions = $group['conditions'];
                $groupLogic = $group['logic'];
                $groupClauses = [];

                foreach ($groupConditions as $index => [$field, $operator, $value]) {
                    if (!isset($fieldCount[$field])) $fieldCount[$field] = 0;
                    $fieldCount[$field]++;
                    $placeholder = ':' . preg_replace('/\W/', '', $field) . '_group_' . $fieldCount[$field];
                    $groupClauses[] = "$field $operator $placeholder";
                    $this->params[$placeholder] = $value;
                }

                $groupSql = '(' . implode(" {$groupLogic} ", $groupClauses) . ')'; // OR fixo dentro do grupo
                $addClause($groupSql, $groupLogic);
            }
        }

        // LIKE
        if (isset($this->query['like'])) {
            foreach ($this->query['like'] as $likeGroup) {
                $conditions = $likeGroup['conditions'];
                $logic = $likeGroup['logic'];
                $likeClauses = [];

                foreach ($conditions as $index => [$field, $value]) {
                    if (!isset($fieldCount[$field])) $fieldCount[$field] = 0;
                    $fieldCount[$field]++;
                    $placeholder = ':' . preg_replace('/\W/', '', $field) . '_like_' . $fieldCount[$field];
                    $likeClauses[] = "$field LIKE $placeholder";
                    $this->params[$placeholder] = "%$value%"; // adiciona os % para busca parcial
                }

                $groupSql = '(' . implode(" {$logic} ", $likeClauses) . ')';
                $addClause($groupSql, 'AND');
            }
        }





        return ' WHERE ' . implode(' ', $clauses);
    }


    private function buildGroupBy(): string
    {
        if (!isset($this->query['groupBy'])) return '';
        return ' GROUP BY ' . implode(', ', $this->query['groupBy']);
    }

    private function buildHavings(): string
    {
        // Similar ao buildWheres, mas para a cláusula HAVING
        if (!isset($this->query['having'])) return '';
        // ... Lógica para construir a cláusula HAVING ...
        return ''; // Implementar
    }

    private function buildOrderBy(): string
    {
        if (!isset($this->query['order'])) return '';
        $orderParts = [];
        foreach ($this->query['order'] as [$field, $direction]) {
            $orderParts[] = "$field $direction";
        }
        return ' ORDER BY ' . implode(', ', $orderParts);
    }

    private function buildLimit(): string
    {
        if (!isset($this->query['limit'])) return '';
        return " LIMIT {$this->query['limit']}";
    }

    private function buildOffset(): string
    {
        if (!isset($this->query['offset'])) return '';
        return " OFFSET {$this->query['offset']}";
    }


    // MÉTODOS DE EXECUÇÃO

    public function get()
    {
        $query = $this->transform();
        $params = $this->params;
        return empty($params) ? $this->read($query) : $this->read($query, $params);
    }

   /*  public function toArray()
    {
        return $this->get()->getAtributes();
    } */

    public function first()
    {
        $this->limit(1);
        $query = $this->transform();
        $params = $this->params;
        return empty($params) ? $this->readOne($query) : $this->readOne($query, $params);
    }
  
    public function getParams()
    {
        return $this->params;
    }
    public function paginate($perPage=10)
    {
        // dd($perPage);
        // Crie uma nova instância do Paginator passando o próprio builder
        $paginator = new Paginator($this, $perPage);
        return $paginator->paginate();
    }

    // Adicione este método auxiliar na trait Query para que o Paginator possa acessá-lo.
    // Ele permite que a gente modifique a query internamente.
    public function setSelect(string $fields): self
    {
        $this->query['select'] = $fields;
        return $this;
    }

    // E um método para remover cláusulas que não queremos na query de contagem
    public function removeClause(string $clause): self
    {
        unset($this->query[$clause]);
        return $this;
    }

   
}