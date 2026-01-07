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
        // Instancia o BladeOne
        // MODE_AUTO: Recompila se o template mudar (bom para dev e prod)
        $blade = new BladeOne(self::VIEWS, self::CACHE, BladeOne::MODE_AUTO);

        // Renderiza e imprime o conteúdo
        echo $blade->run($view, $data);
    }
}
