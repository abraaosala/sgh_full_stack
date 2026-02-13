<?php

namespace App\library;

use eftec\bladeone\BladeOne;

class View
{
    // Caminho para as views do Blade (resources/views)
    const VIEWS = __DIR__ . '/../../resources/views';

    // Caminho para o cache do Blade (cache/blade)
    const CACHE = __DIR__ . '/../../cache/blade';

    /**
     * Renderiza um template BladeOne
     *
     * @param string $view Nome da view (ex: 'home', 'admin.dashboard')
     * @param array $data Dados a serem passados para a view
     * @return void
     */
    public static function render(string $view, array $data = [])
    {
        echo self::content($view, $data);
    }

    /**
     * Retorna o conteúdo renderizado de um template BladeOne
     *
     * @param string $view Nome da view
     * @param array $data Dados
     * @return string
     */
    public static function content(string $view, array $data = []): string
    {
        $data = globals($data);
        $blade = new BladeOne(self::VIEWS, self::CACHE, BladeOne::MODE_AUTO);
        return $blade->run($view, $data);
    }
}
