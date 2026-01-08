<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;
use App\Models\Leito;
use App\library\View;

class LeitoController extends Controller
{
    /**
     * Listar leitos
     */
    public function index()
    {
        // Eloquent: buscar todos os leitos paginados (opcional, aqui trazendo todos)
        $leitos = Leito::orderBy('id', 'desc')->get();

        View::render('admin.leitos.index', globals([
            'title' => 'Gestão de Leitos',
            'leitos' => $leitos
        ]));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        View::render('admin.leitos.create', globals([
            'title' => 'Novo Leito',
            'leito' => null // null indica modo criação
        ]));
    }

    /**
     * Salvar novo leito
     */
    public function store()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        // Simple Validation (pode melhorar depois)
        if (empty($data['numero']) || empty($data['tipo'])) {
            // Em um cenário real, usar flash messages e redirect back
            redirect('/admin/leito-criar');
            return;
        }

        // Eloquent: Mass Assignment
        // Certifique-se que os campos estão no $fillable do Model
        Leito::create([
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'] ?? 'Disponível',
            'descricao' => $data['descricao']
        ]);

        redirect('admin/leitos');
    }

    /**
     * Formulário de edição
     */
    public function edit($params)
    {
        $id = (int) $params['leito-editar'] ?? null;
        
        if (!$id) redirect('admin/leitos');

        $leito = Leito::find($id);
        if (!$leito) redirect('admin/leitos');

        View::render('admin.leitos.create', globals([
            'title' => 'Editar Leito',
            'leito' => $leito // objeto preenchido indica edição
        ]));
    }

    /**
     * Atualizar leito
     */
    public function update($params)
    {
        $id = $params[0] ?? null;
        if (!$id) redirect('admin/leitos');

        $leito = Leito::find($id);
        if (!$leito) redirect('admin/leitos');

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $leito->update([
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'],
            'descricao' => $data['descricao']
        ]);

        redirect('admin/leitos');
    }

    /**
     * Excluir leito
     */
    public function destroy($params)
    {
        $id = (int) $params['leito-excluir'] ?? null;

        if ($id) {
            $leito = Leito::find($id);
            if ($leito) $leito->delete();
        }
        redirect('admin/leitos');
    }

    public function show($params) {}
    public function delete($params) {}
}