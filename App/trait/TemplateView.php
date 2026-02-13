<?php

declare(strict_types=1);
namespace App\trait;
trait   TemplateView
{
    /**
     * Limpa os dados de entrada para prevenir ataques XSS.
     *
     * @param array $data O array de dados a ser sanitizado.
     * @return array O array de dados limpo e seguro.
     */
    private function sanitizeTemplateData(array $data): array
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
        }

        return $sanitizedData;
    }

    /**
     * Monta o caminho completo do arquivo de template e verifica sua existência.
     *
     * @param string $templateName O nome do template (ex: 'home', 'partials.header').
     * @return string O caminho completo do arquivo.
     * @throws \Exception Se o arquivo de template não for encontrado.
     */
    private function getTemplateFilePath(string $templateName): string
    {
        $templatePath = str_replace('.', '/', $templateName);
        $fullPath = VIEW . $templatePath . '.php';

        if (!file_exists($fullPath)) {
            throw new \Exception("Template not found: " . $fullPath);
        }

        return $fullPath;
    }

    /**
     * Renderiza uma página completa combinando diferentes templates.
     *
     * @param array $data Dados a serem passados para os templates.
     * @param string $viewTemplate O template principal da página (ex: 'home').
     */
    public function view(array $data, string $viewTemplate = ''): void
    {
        $this->render(
            [
                'partials.header-html',
                'partials.layout-vertical',
                $viewTemplate,
                'partials.footer',
                'partials.footer-html',
            ],
            $data
        );
    }
    
    /**
     * Renderiza uma lista de templates em sequência.
     *
     * @param array $templateNames Array de nomes de templates.
     * @param array|null $data Array de dados a serem passados para os templates.
     */
    public function render(array $templateNames, ?array $data = null): void
    {
        $sanitizedData = $data !== null && $data !== [] && is_array($data) ? globals($data) : globals([]);
        $sanitizedData = $this->sanitizeTemplateData($sanitizedData);

        $isolatedRenderFunction = function ($filePath) use ($sanitizedData) {
            if (!empty($sanitizedData)) {
                extract($sanitizedData);
            }

            include $filePath;
        };

        foreach ($templateNames as $templateName) {
            $templateFile = $this->getTemplateFilePath($templateName);
            $isolatedRenderFunction($templateFile);
        }
    }
    
    /**
     * Renderiza templates em um buffer e retorna o HTML como uma string.
     *
     * @param array $templateNames Nomes dos templates a serem renderizados.
     * @param array $data Dados a serem passados para os templates.
     * @return string O conteúdo HTML renderizado.
     */
    public function content(array $templateNames, array $data): string
    {
        ob_start();
        $this->render($templateNames, $data);
        return ob_get_clean();
    }

    /**
     * Renderiza templates em um buffer e retorna o HTML como uma string(Template)
     *
     * @param array $data Dados a serem passados para os templates.
     * @param string $view A View que Sera exibido com o padrao geral
     * @return string O conteúdo HTML renderizado.
     */
    public function vContent(array $data, $view) : string {
        return $this->content([
            'partials.document.header-html',
            'partials.document.header',
            $view,
            'partials.document.footer',
            'partials.document.footer-html'
        ], $data);
    }
}