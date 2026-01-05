<?php

namespace App\Dao;

use App\Dao\Models\Model as Query; // Importe a trait (ou a classe que a usa)

class Paginator
{
    private readonly Query $builder;

    /**
     * O construtor agora recebe a instância do Query Builder.
     */
    public function __construct(Query $builder, private readonly int $perPage = 10)
    {
        // Clonamos o builder para que qualquer modificação aqui
        // não afete o objeto original fora do paginador.
        $this->builder = clone $builder;
    }

    /**
     * Executa a paginação.
     */
    public function paginate()
    {
        $this->builder->toSql();

        // dd($this->builder->readOne($totalQuery, $this->builder->getParams()));
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }

        // 1. Obter o total de resultados de forma segura
        $total = $this->getTotal();

        $totalPages = ($this->perPage > 0) ? ceil($total / $this->perPage) : 0;
        $offset = ($page - 1) * $this->perPage;

        // 2. Obter os itens para a página atual
        $results = [];
        if ($total > 0) {
            $results = $this->builder->limit($this->perPage)->offset($offset)->get();
        }
        
        return (object)[
            'Items' => $results,
            'total' => $total,
            'init'=>$offset,
            'info' => $this->paginationInfo($offset, count($results), $total),
            'current_page' => $page,
            'per_page' => $this->perPage,
            'total_pages' => $totalPages,
            'paginacao' => ($totalPages > 1) ? $this->html($totalPages, $page) : ''
        ];
    }

    private function getTotal():int
    {
        // 1. Cria um clone para não modificar a query principal
        $countBuilder = $this->builder;


        // Remove cláusulas que não afetam a contagem e podem deixar a query lenta
        $countBuilder->removeClause('order')
            ->removeClause('limit')
            ->removeClause('offset');


        // 2. Transforma o builder em uma string de SQL completa
        $queryMontada = $countBuilder->toSql();
        $params = $this->builder->getParams();

        // 3. Usa a expressão regular para substituir a lista de campos por COUNT(*)
        // O '1' no final garante que a substituição ocorra apenas na primeira vez,
        // o que é uma pequena segurança contra subqueries.
        $totalQuery = preg_replace(
            '/SELECT\s+(.*?)\s+FROM/i',
            'SELECT COUNT(*) as total FROM',
            $queryMontada,
            1 // Limita a substituição a apenas 1 ocorrência
        );

        // Se o preg_replace falhar, $totalQuery pode ser null.
        if (is_null($totalQuery)) {
            // Lidar com o erro, talvez lançando uma exceção ou retornando 0
            return 0;
        }


        if ($params !== []) {
            $result = $this->builder->readOne($totalQuery, $this->builder->getParams());
        } else {
            $result = $this->builder->readOne($totalQuery);
        }


        return (int) ($result?->total ?? 0);
    }

    private function buildQueryString($page)
    {
        $query = $_GET;
        $query['page'] = $page;
        unset($query['url']);
        return '?' . http_build_query($query);
    }

    public function html($totalPages, $page)
    {
        $html = '<ul class="pagination">';
        $html .= $this->linkItem($page - 1, 'Anterior', $page > 1);
        $html .= $this->numberLinks($totalPages, $page);
        $html .= $this->linkItem($page + 1, 'Próximo', $page < $totalPages);
        return $html . '</ul>';
    }

    private function linkItem($targetPage, $label, $enabled)
    {
        if (!$enabled) {
            return '';
        }

        $url = $this->buildQueryString($targetPage);
        return '<li class="page-item"><a class="page-link" href="' . $url . '">' . $label . '</a></li>';
    }

    private function numberLinks($totalPages, $currentPage)
    {
        $html = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            $url = $this->buildQueryString($i);
            $active = $i == $currentPage ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
        }

        return $html;
    }

    private function paginationInfo(int $offset, int $count, int $total)
    {
        if ($total === 0) {
            return "";
        }

        $inicio = $offset + 1;
        $fim = $offset + $count;

        return sprintf("<p class='text-end text-dark'>Mostrando de %d até %d de %s registros</p>", $inicio, $fim, $total);
    }
}