<?php

namespace App\Services;

use App\export\Pdf;
use App\trait\DocumentExport;

class CredentialService extends AbstractService
{
    use DocumentExport;

    public function generateProtocolPdf(array $data): array
    {
        if (empty($data)) {
            throw new \Exception('Dados de credenciais indisponíveis.');
        }

        $viewData = [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $data['senha'],
            'hospital' => HOSPITAL,
            'date' => date('d/m/Y'),
            'hour' => date('H:i')
        ];

        $html = $this->vcontent($viewData, 'document.credenciais');
        
        return [
            'html' => $html,
            'filename' => 'Protocolo_Acesso_' . str_replace(' ', '_', (string) ($data['nome'] ?? 'usuario'))
        ];
    }

    public function downloadPdf(string $html, string $filename): void
    {
        $pdf = new Pdf();
        $pdf->exportar([
            'html' => $html,
            'nome_arquivo' => $filename,
            'download' => true
        ]);
        exit;
    }
}
