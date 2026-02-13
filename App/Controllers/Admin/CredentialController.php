<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;
use App\export\Pdf;
use App\trait\DocumentExport;

class CredentialController extends Controller
{
    protected $credentialService;

    public function __construct()
    {
        $this->credentialService = container(\App\Services\CredentialService::class);
    }

    /**
     * Gera o PDF de credenciais baseado nos dados armazenados na sessão.
     */
    public function print()
    {
        try {
            $data = session()->get('temp_credentials');
            $pdfData = $this->credentialService->generateProtocolPdf($data ?: []);
            $this->credentialService->downloadPdf($pdfData['html'], $pdfData['filename']);
        } catch (\Exception $e) {
            redirect(ROUTE_ADMIN_HOME, ['error', 'Falha ao gerar o PDF: ' . $e->getMessage(), 'danger']);
        }
    }

    // Métodos obrigatórios do BaseController
    public function index() {}
    public function show($params) {}
    public function create() {}
    public function store() {}
    public function edit($params) {}
    public function update($params) {}
    public function delete($params) {}
}
