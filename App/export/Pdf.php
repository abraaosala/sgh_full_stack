<?php

declare(strict_types=1);

namespace App\export;

use App\contracts\DocumentExport;
use Dompdf\Dompdf;

class Pdf implements DocumentExport
{
    private string $nomeArquivo;

    public function exportar(array $data): void
    {
        
        // Extrai o HTML do array de dados.
        if (!isset($data['html']) || !is_string($data['html'])) {
            throw new \InvalidArgumentException('O array de dados deve conter a chave "html" com uma string.');
        }

        $html = $data['html'];

        // Extrai o nome do arquivo se ele estiver no array.
        if (isset($data['nome_arquivo']) && is_string($data['nome_arquivo'])) {
            $this->setNomeArquivo($data['nome_arquivo']);
        }

        $dompdf = new Dompdf();

        // Carrega o HTML
        $dompdf->loadHtml($html);

        // (Opcional) Define o tamanho e a orientação do papel
        $dompdf->setPaper($data['tamanho_papel'] ?? 'A4', $data['orientacao'] ?? 'portrait'); // portrait ou 'landscape'

        // Renderiza o HTML como PDF
        $dompdf->render();

        // Envia o PDF para o navegador
        $dompdf->stream($this->nomeArquivo ?: "arquivo",
         ["Attachment" => $data['download'] ?? true]);

        // return "PDF gerado com sucesso.";
    }

    public function setNomeArquivo(string $nome): void
    {
        // Limpa o nome do arquivo para evitar problemas de segurança
        $this->nomeArquivo = preg_replace('/[^a-zA-Z0-9_-]/', '', $nome);
    }
}