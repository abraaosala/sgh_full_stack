<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\Models\Funcionario;
use App\Models\Provincia;
use App\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\Services\FuncionarioService;
use App\Exceptions\ValidationException;

class FuncionarioController extends Controller
{
   protected FuncionarioService $funcionarioService;

   public function __construct()
   {
      $this->funcionarioService = container(FuncionarioService::class);
   }

   private array $perfil = ['enfermeiro', 'recepcionista'];

   // Métodos padrão de controllers RESTful
   public function index()
   {
      $search = $_GET['search'] ?? null;

      $func = $this->funcionarioService->getPaginatedList($search);
      $func->setPath(root() . 'admin/funcionarios');
      if ($search !== null && $search !== '') {
         $func->appends(['search' => $search]);
      }
      
      $this->view([
         'title' => 'Todos Funcionários',
         'usuarios' => $func->items(),
         'tools' => $func
      ], 'admin.funcionarios.index');
   }

   public function show($params)
   {
      $id = (int) $params['id'];
      $res = $this->funcionarioService->getFuncionarioDetails($id);

      echo json_encode($res);
   }

   public function create()
   {
      // criar novo recurso

      $provincias = (new Provincia())->all();
      // dd($provincias);
      $this->view(
         [
            'title' => 'Criar Novo Funcionário',
            'description' => 'Gerir Funcionários',
            'keywords' => 'Girir, Funcionários, Listar',
            'provincias' => $provincias,
            'funcionarios' => ['Enfermeiro', 'Recepcionista']
         ],
         'admin.funcionarios.create'
      );
   }

   public function store()
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      
      if (!csrf()->isValid($data['csrf_token'] ?? '')) {
         redirect('admin/funcionario-criar', ['error', 'Erro ao processar o formulário. Por favor, tente novamente.', 'danger']);
      }

      unset($data['csrf_token']);

      try {
         $result = $this->funcionarioService->storeFuncionario($data);

         PostOld::clean();

         session()->set('temp_credentials', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $result['senha']
         ]);

         $msg = sprintf(
            'Funcionário registrado com sucesso! <br> <strong>Senha de Acesso: %s</strong> <br> ' .
               '<a href="%s" class="btn btn-sm btn-info mt-2" target="_blank"><i class="feather icon-printer"></i> Imprimir Protocolo de Acesso (PDF)</a>',
            $result['senha'],
            lnk('admin/imprimir-credenciais')
         );
         redirect('admin/funcionarios', ['success', $msg]);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect('admin/funcionario-criar', ['error', implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/funcionarios', ['error', 'Erro ao cadastrar: ' . $exception->getMessage()]);
      }
   }

   public function edit($params)
   {
      $id = (int) $params['id'];
      $funcionario = $this->funcionarioService->getFuncionarioById($id);

      if (!$funcionario) {
         redirect('admin/funcionarios', ['error', 'Funcionário não encontrado']);
      }

      // View compatibility mapping
      $funcionario->nome = $funcionario->usuario->nome;
      $funcionario->email = $funcionario->usuario->email;
      $funcionario->genero = $funcionario->usuario->genero;
      $funcionario->data_nascimento = $funcionario->usuario->data_nascimento;
      $funcionario->perfil = $funcionario->usuario->perfil;

      $provincias = Provincia::orderBy('nome')->get();

      $data = [
         'title' => 'Editar Funcionário',
         'description' => 'Gerir Funcionários',
         'keywords' => 'Gerir, Funcionários, Editar',
         'funcionario' => $funcionario,
         'provincias' => $provincias,
         'funcionarios' => ['Enfermeiro', 'Recepcionista']
      ];
      $this->view($data, 'admin.funcionarios.create');
   }

   public function update($params)
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      $id = (int) ($params['id'] ?? $data['id'] ?? 0);

      if ($id === 0) {
         redirect('admin/funcionarios', ['error', 'Funcionário não encontrado']);
      }

      try {
         $updated = $this->funcionarioService->updateFuncionario($id, $data);
         if (!$updated) {
            redirect('admin/funcionarios', ['error', 'Funcionário não encontrado']);
         }

         PostOld::clean();
         redirect('admin/funcionarios', ['success', 'Funcionário atualizado com sucesso']);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect("admin/funcionario-editar/" . $id, ['error', 'Verifique os erros no formulário.<br>' . implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/funcionarios', ['error', 'Falha ao atualizar: ' . $exception->getMessage()]);
      }
   }

   public function destroy($params)
   {
      $id = (int) ($params['id'] ?? 0);

      if ($id === 0) {
         redirect('admin/funcionarios', ['error', 'Funcionário não encontrado', 'danger']);
      }

      try {
         $deleted = $this->funcionarioService->deleteFuncionario($id);
         if (!$deleted) {
            redirect('admin/funcionarios', ['error', 'Funcionário não encontrado', 'danger']);
         }
         redirect('admin/funcionarios', ['success', 'Funcionário excluído com sucesso']);
      } catch (\Exception $exception) {
         redirect('admin/funcionarios', ['error', 'Falha ao excluir: ' . $exception->getMessage()]);
      }
   }

   public function delete($params)
   {
      $this->destroy($params);
   }
}
