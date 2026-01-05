<?php

namespace app\Dao;

use app\Dao\Models\Model as Query; // Ou a classe que usa o trait Query

class Paginator
{
    private readonly Query $builder;

    private readonly int $perPage;

    public function __construct(Query $builder, int $perPage = 10)
    {
        $this->builder = clone $builder;
        $this->perPage = $perPage > 0 ? $perPage : 10;
    }

    public function paginate(): object
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }

        // Este método agora é inteligente o suficiente para lidar com GROUP BY.
        $total = $this->getTotal();

        $totalPages = ($this->perPage > 0) ? (int)ceil($total / $this->perPage) : 0;
        $offset = ($page - 1) * $this->perPage;

        $results = [];
        // Apenas busca os resultados se houver registros e a página atual for válida.
        if ($total > 0 && $page <= $totalPages) {
            $results = $this->builder->limit($this->perPage)->offset($offset)->get();
        }

        return (object)[
            'Items'        => $results,
            'total'        => $total,
            'init'         => $offset + 1,
            'info'         => $this->paginationInfo($offset, is_array($results) ? count($results) : 0, $total),
            'current_page' => $page,
            'per_page'     => $this->perPage,
            'total_pages'  => $totalPages,
            'paginacao'    => ($totalPages > 1) ? $this->html($totalPages, $page) : ''
        ];
    }

    /**
     * MODIFICADO: Calcula o total de registros de forma inteligente.
     * - Usa uma subconsulta se a query principal tiver GROUP BY.
     * - Usa um COUNT(*) simples e rápido caso contrário.
     */
    private function getTotal(): int
    {
        // 1. Clona o builder para não afetar a consulta principal de resultados.
        $countBuilder = clone $this->builder;

        // 2. Remove cláusulas que não afetam a contagem ou podem causar lentidão/erros.
        $countBuilder->removeClause('order')
            ->removeClause('limit')
            ->removeClause('offset');

        // 3. Verifica se a consulta original usa GROUP BY.
        if ($countBuilder->hasClause('groupBy')) {
            // ESTRATÉGIA PARA GROUP BY: Envolve a query original em um COUNT.

            // Gera o SQL da consulta de agrupamento.
            $originalSql = $countBuilder->toSql();
            // Pega os parâmetros correspondentes.
            $params = $countBuilder->getParams();

            // Envolve a query original para contar o número de linhas que ela retornaria.
            $totalQuery = sprintf('SELECT COUNT(*) as total FROM (%s) as subquery_for_count', $originalSql);
        } else {
            // ESTRATÉGIA PADRÃO: Substitui o SELECT por COUNT(*), que é mais rápido.

            // Gera o SQL e popula os parâmetros.
            $queryMontada = $countBuilder->toSql();
            // Pega os parâmetros correspondentes.
            $params = $countBuilder->getParams();

            // Substitui de forma segura a cláusula SELECT.
            $totalQuery = preg_replace(
                '/SELECT\s+.*?\s+FROM/i',
                'SELECT COUNT(*) as total FROM',
                $queryMontada,
                1
            );
        }

        if (is_null($totalQuery)) {
            return 0;
        }

        // 4. Executa a consulta de contagem (seja ela qual for) com os parâmetros corretos.
        $result = $params === []
            ? $this->builder->readOne($totalQuery)
            : $this->builder->readOne($totalQuery, $params);

        return (int) ($result->total ?? 0);
    }

    // ... O restante da classe (métodos de HTML) permanece exatamente o mesmo ...

    public function html(int $totalPages, int $currentPage): string
    {
        $html = '<ul class="pagination">';
        $html .= $this->linkItem($currentPage - 1, 'Anterior', $currentPage > 1);
        $html .= $this->numberLinks($totalPages, $currentPage);
        $html .= $this->linkItem($currentPage + 1, 'Próximo', $currentPage < $totalPages);
        return $html . '</ul>';
    }

    private function numberLinks(int $totalPages, int $currentPage): string
    {
        $html = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i === $currentPage) ? 'active' : '';
            $html .= '<li class="page-item ' . $activeClass . '">';
            $html .= '<a class="page-link" href="' . $this->buildQueryString($i) . '">' . $i . '</a>';
            $html .= '</li>';
        }

        return $html;
    }

    private function linkItem(int $targetPage, string $label, bool $isEnabled): string
    {
        if (!$isEnabled) {
            return '<li class="page-item disabled"><span class="page-link">' . $label . '</span></li>';
        }

        return '<li class="page-item"><a class="page-link" href="' . $this->buildQueryString($targetPage) . '">' . $label . '</a></li>';
    }

    private function buildQueryString(int $page): string
    {
        $query = $_GET;
        $query['page'] = $page;
        unset($query['url']);
        return '?' . http_build_query($query);
    }

    private function paginationInfo(int $offset, int $count, int $total): string
    {
        if ($total === 0) {
            return "Nenhum registro encontrado.";
        }

        $inicio = $offset + 1;
        $fim = $offset + $count;

        return sprintf('Mostrando de %d até %d de %s registros', $inicio, $fim, $total);
    }
}