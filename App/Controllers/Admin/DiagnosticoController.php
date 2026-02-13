<?php

namespace App\Controllers\Admin;

use App\Http\BaseController;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Doenca;

class DiagnosticoController extends BaseController
{
    protected $diagnosticoService;

    public function __construct()
    {
        $this->diagnosticoService = container(\App\Services\DiagnosticoService::class);
    }

    public function index()
    {
        $diagnosticos = $this->diagnosticoService->getAllDiagnosticos();

        return $this->view([
            'title' => 'Gestão de Diagnósticos',
            'diagnosticos' => $diagnosticos
        ], 'admin.diagnosticos.index');
    }

    public function show($params)
    {
        $id = (int) $params['id'];
        $diagnostico = $this->diagnosticoService->getDiagnosticoById($id);

        if (!$diagnostico) {
            return redirect(lnk('admin/diagnosticos'));
        }

        return $this->view([
            'title' => 'Detalhes do Diagnóstico',
            'diagnostico' => $diagnostico
        ], 'admin.diagnosticos.show');
    }

    public function create() {}

    public function store() {}

    public function edit($params) {}

    public function update($params) {}

    public function delete($params)
    {
        $id = (int) $params['id'];
        $this->diagnosticoService->deleteDiagnostico($id);

        return redirect(lnk('admin/diagnosticos'), ['success', 'Diagnóstico excluído com sucesso!']);
    }
}
