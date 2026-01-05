<?php

namespace App\Dao;

class Paginator
{
    private $query;
    private $params;
    private $table;
    private $readCallback;

    public function __construct($query, $params, $table, callable $readCallback)
    {
        $this->query = $query;
        $this->params = $params;
        $this->table = $table;
        $this->readCallback = $readCallback;
    }

    public function paginate($perPage = 10)
    {

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $paginatedQuery = $this->query . " LIMIT $perPage OFFSET $offset";
        $results = call_user_func($this->readCallback, $paginatedQuery, $this->params);

        // Query montada pelo builder
        $queryMontada = $this->query;
        // Troca os campos originais por COUNT(*)
        $totalQuery = preg_replace(
            '/SELECT\s+(.*?)\s+FROM/i',
            'SELECT COUNT(*) as total FROM',
            $queryMontada
        );
        // $totalQuery = "SELECT COUNT(*) as total FROM {$this->table}";

        $totalResults = call_user_func($this->readCallback, $totalQuery);
        $total = $totalResults[0]->total;
        $totalPages = ceil($total / $perPage);

        return (object)[
            'Items' => $results,
            'total' => $total,
            'info' => $this->pagination([$perPage, $offset, $results, $total]),
            'current_page' => $page,
            'bigin' => $offset,
            'total_pages' => $totalPages,
            'paginacao' => ($totalPages > 1) ? $this->html($totalPages, $page, $total) : ''
        ];
    }

    private function buildQueryString($page)
    {
        $query = $_GET;         // pega somente os parâmetros presentes
        $query['page'] = $page; // só adiciona/atualiza o "page"
        unset($query['url']); // remove o parâmetro "url"
        return '?' . http_build_query($query);
    }


    public function html($totalPages, $page, $total)
    {
        $html = '<ul class="pagination">';
        $html .= $this->linkItem($page - 1, 'Anterior', $page > 1);
        $html .= $this->numberLinks($totalPages, $page);
        $html .= $this->linkItem($page + 1, 'Próximo', $page < $totalPages);
        $html .= '</ul>';
        return $html;
    }

    private function linkItem($targetPage, $label, $enabled)
    {
        if (!$enabled) return '';
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

    private function pagination(array $part)
    {
        [$limit, $offset, $res, $total] = $part;
        $inicio = $offset + 1;

        if ($total == 0) return "";

        $index = $inicio + count($res) - 1;

        $html = "<p class='text-end text-dark'>";
        $html .= "Mostrando de {$inicio} até {$index} de {$total} registros";
        $html .= "</p>";
        return $html;
    }
}
