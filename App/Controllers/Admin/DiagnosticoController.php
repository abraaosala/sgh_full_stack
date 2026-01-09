<?php

namespace App\Controllers\Admin;

use App\Http\BaseController;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Doenca;

class DiagnosticoController extends BaseController
{
    public function index()
    {
        $diagnosticos = Diagnostico::with(['paciente.usuario', 'medico.usuario', 'doenca'])->get();

        return $this->view(globals([
            'title' => 'Gestão de Diagnósticos',
            'diagnosticos' => $diagnosticos
        ]), 'admin.diagnosticos.index');
    }

    public function show($params)
    {
        $id = $params['id'];
        $diagnostico = Diagnostico::with(['paciente.usuario', 'medico.usuario', 'doenca'])->find($id);

        if (!$diagnostico) {
            return redirect(lnk('admin/diagnosticos'));
        }

        return $this->view(globals([
            'title' => 'Detalhes do Diagnóstico',
            'diagnostico' => $diagnostico
        ]), 'admin.diagnosticos.show');
    }

    public function create()
    {
        // Administradores geralmente não criam diagnósticos diretamente, 
        // mas podemos implementar se necessário.
    }

    public function store() {}

    public function edit($params) {}

    public function update($params) {}

    public function delete($params)
    {
        $id = $params['id'];
        $diagnostico = Diagnostico::find($id);

        if ($diagnostico) {
            $diagnostico->delete();
        }

        return redirect(lnk('admin/diagnosticos'));
    }
}
