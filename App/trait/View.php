<?php

namespace App\trait;

trait View
{
    public function view(array $data, string $view = 'dashboard')
    {
       
        $this->render(
            [
                'partials.header-html',
                'partials.layout-vertical',
                $view,
                'partials.footer',
                'partials.footer-html'
            ],
            $data
        );
    }

    public function render(array $templetes, ?array $data = null)
    {
       
        // converte os / em .
        $templetes = str_replace('.', '/', $templetes);
        if ($data !== null && $data !== [] &&  is_array($data)) {
            extract($data);
        }

        

        foreach ($templetes as $templete) {
            include VIEW . $templete . ".php";
        }
    }

    /**
     * Renderizar em um buffer
     */
    public function bRender(array $templates, array $data):string
    {
        // 1. Inicia o buffer de saída
        ob_start();

        // 2. Inclui o arquivo. O conteúdo vai para o buffer, não para a tela.
        $this->render($templates, $data);

        // 3. Pega o conteúdo do buffer e salva na variável $html_conteudo.
        //    O buffer é limpo e a captura é encerrada.
        $html_conteudo = ob_get_clean();

        return $html_conteudo;



    }
}