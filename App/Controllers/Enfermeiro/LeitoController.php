<?php

declare(strict_types=1);

namespace App\Controllers\Enfermeiro;

use App\trait\View;
use App\Models\Leito;

class LeitoController
{
    use View;

    public function index()
    {
        $leitos = Leito::orderBy('numero', 'asc')->get();

        \App\library\View::render('enfermeiro.leitos.index', globals([
            'title' => 'Gestão de Leitos',
            'leitos' => $leitos
        ]));
    }

    public function create()
    {
        \App\library\View::render('enfermeiro.leitos.create', globals([
            'title' => 'Novo Leito',
            'leito' => null
        ]));
    }

    public function store()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($data['numero']) || empty($data['tipo'])) {
            redirect('/enfermeiro/leitos');
            return;
        }

        Leito::create([
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'] ?? 'Livre',
            'descricao' => $data['descricao']
        ]);

        redirect('/enfermeiro/leitos');
    }

    public function edit($params)
    {
        $id = (int) ($params['leito'] ?? 0);
        $leito = Leito::find($id);

        if (!$leito) {
            redirect('/enfermeiro/leitos');
        }

        \App\library\View::render('enfermeiro.leitos.create', globals([
            'title' => 'Editar Leito',
            'leito' => $leito
        ]));
    }

    public function update($params)
    {
        $id = (int) ($params['leito'] ?? 0);
        $leito = Leito::find($id);

        if (!$leito) {
            redirect('/enfermeiro/leitos');
        }

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $leito->update([
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'],
            'descricao' => $data['descricao']
        ]);

        redirect('/enfermeiro/leitos');
    }

    public function destroy($params)
    {
        $id = (int) ($params['leito'] ?? 0);
        $leito = Leito::find($id);

        if ($leito) {
            $leito->delete();
        }

        redirect('/enfermeiro/leitos');
    }

    public function updateStatus()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$id || !$status) {
            echo json_encode(['status' => false, 'message' => 'Dados incompletos.']);
            return;
        }

        try {
            $leito = Leito::find($id);
            if ($leito) {
                $leito->status = $status;
                $leito->save();
                echo json_encode(['status' => true, 'message' => 'Status do leito atualizado!']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Leito não encontrado.']);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    }
}
