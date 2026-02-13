<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;
use App\Models\Leito;
use App\library\View;

class LeitoController extends Controller
{
    protected $leitoService;

    public function __construct()
    {
        $this->leitoService = container(\App\Services\LeitoService::class);
    }

    /**
     * Listar leitos
     */
    public function index()
    {
        $leitos = $this->leitoService->getAllLeitos();

        \App\library\View::render('admin.leitos.index', [
            'title' => 'Gestão de Leitos',
            'leitos' => $leitos
        ]);
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        \App\library\View::render('admin.leitos.create', [
            'title' => 'Novo Leito',
            'leito' => null 
        ]);
    }

    /**
     * Salvar novo leito
     */
    public function store()
    {
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

        try {
            $this->leitoService->storeLeito($data);
            redirect('admin/leitos', ['success', 'Leito cadastrado com sucesso!']);
        } catch (\App\Exceptions\ValidationException $e) {
            \App\library\PostOld::set($data);
            redirect('admin/leito-criar', ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect('admin/leitos', ['error', 'Erro ao cadastrar: ' . $e->getMessage(), 'danger']);
        }
    }

    /**
     * Formulário de edição
     */
    public function edit($params)
    {
        $id = (int) ($params['leito-editar'] ?? 0);
        
        if ($id === 0) redirect('admin/leitos');

        $leito = $this->leitoService->getLeitoById($id);
        if (!$leito) redirect('admin/leitos');

        \App\library\View::render('admin.leitos.create', [
            'title' => 'Editar Leito',
            'leito' => $leito
        ]);
    }

    /**
     * Atualizar leito
     */
    public function update($params)
    {
        $id = (int) ($params['leito-save'] ?? 0);
        if ($id === 0) redirect('admin/leitos');

        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

        try {
            $updated = $this->leitoService->updateLeito($id, $data);
            if (!$updated) {
                redirect('admin/leitos', ['error', 'Leito não encontrado', 'danger']);
            }
            redirect('admin/leitos', ['success', 'Leito atualizado com sucesso!']);
        } catch (\App\Exceptions\ValidationException $e) {
            \App\library\PostOld::set($data);
            redirect('admin/leito-editar/' . $id, ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect('admin/leitos', ['error', 'Falha ao atualizar: ' . $e->getMessage(), 'danger']);
        }
    }

    /**
     * Excluir leito
     */
    public function destroy($params)
    {
        $id = (int) ($params['leito-excluir'] ?? 0);

        if ($id !== 0) {
            $this->leitoService->deleteLeito($id);
        }
        redirect('admin/leitos', ['success', 'Leito excluído com sucesso!']);
    }

    public function show($params) {}
    public function delete($params) {}
}
