<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\Services\MailService;
use App\trait\View;

class UserController extends Controller
{

    protected $userService;

    public function __construct()
    {
        $this->userService = container(\App\Services\UserService::class);
    }

    public function index()
    {
        $search = $_GET['q'] ?? null;
        $usuarios = $this->userService->getPaginatedList($search);

        $usuarios->setPath(lnk('admin/usuarios'));
        if ($search) {
            $usuarios->appends(['q' => $search]);
        }

        $this->view([
            'title'       => 'Todos Usuários',
            'usuarios'    => $usuarios->items(),
            'tools'       => $usuarios,
            'description' => 'Gerir Usuários',
            'keywords'    => 'Gerir, Usuários, Listar'
        ], 'admin.user.index');
    }

    public function store()
    {
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

        try {
            $result = $this->userService->storeUser($data);

            \App\library\PostOld::clean();

            session()->set('temp_credentials', [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha' => $result['senha']
            ]);

            $msg = sprintf(
                'Usuário Cadastrado com Sucesso! <br> <strong>Senha Gerada: %s</strong> <br> ' .
                '<a href="%s" class="btn btn-sm btn-info mt-2" target="_blank"><i class="feather icon-printer"></i> Imprimir Protocolo de Acesso (PDF)</a>',
                $result['senha'],
                lnk('admin/imprimir-credenciais')
            );

            redirect(ROUTE_ADMIN_USERS, ['success', $msg, 'success']);
        } catch (\App\Exceptions\ValidationException $e) {
            \App\library\PostOld::set($data);
            redirect(ROUTE_ADMIN_USERS_CREATE, ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect(ROUTE_ADMIN_USERS, ['error', 'Erro ao cadastrar: ' . $e->getMessage(), 'danger']);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Todos Usuarios',
            'description' => 'Gerir Usuarios',
            'keywords' => 'Girir, Usuarios, Listar'
        ];
        $this->view($data, 'admin.user-criar');
    }

    public function edit($params)
    {
        $id = (int) ($params['usuario-editar'] ?? 0);
        $user = \App\Models\User::find($id);

        if ($user && $user->perfil === 'superadmin') {
            redirect(ROUTE_ADMIN_USERS, ['error', 'Superadministradores não podem ser alterados.', 'danger']);
        }

        if (!$user) {
            redirect(ROUTE_ADMIN_USERS, ['error', 'Usuário não encontrado.', 'danger']);
        }

        $data = [
            'user' => $user,
            'title' => 'Editar Usuário',
            'description' => 'Gerir Usuarios',
            'keywords' => 'Gerir, Usuarios, Editar'
        ];
        $this->view($data, 'admin.user-edit');
    }

    public function update($params)
    {
        $id = (int) ($params['usuario-save'] ?? 0);
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

        try {
            $updated = $this->userService->updateUser($id, $data);
            if (!$updated) {
                redirect(ROUTE_ADMIN_USERS, ['error', 'Usuário não encontrado.', 'danger']);
            }
            redirect(ROUTE_ADMIN_USERS, ['success', 'Usuário atualizado com sucesso!', 'success']);
        } catch (\App\Exceptions\ValidationException $e) {
            \App\library\PostOld::set($data);
            redirect(ROUTE_ADMIN_USERS, ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect(ROUTE_ADMIN_USERS, ['error', 'Falha ao atualizar usuário: ' . $e->getMessage(), 'danger']);
        }
    }

    public function show($params) {}

    public function delete($params) {}

    public function list()
    {
        $search = $_GET['q'] ?? null;
        $usuarios = $this->userService->getPaginatedList($search, 100); // Higher limit for search? Or just all?
        echo json_encode(convertData($usuarios->items()), true);
    }
}
