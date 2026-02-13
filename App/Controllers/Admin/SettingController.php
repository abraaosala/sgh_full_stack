<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\classes\Validator\GeneralValidator as Validator;
use App\classes\View;
use App\Models\User;
use App\Http\Request;
use App\trait\TemplateView;

class SettingController
{
    use \App\trait\TemplateView;

    protected $settingService;

    public function __construct()
    {
        $this->settingService = container(\App\Services\SettingService::class);
    }

    public function renovarSenhaGerate($params)
    {
        $id = (int) urldecode((string) session()->get('id'));
        $perfil = session()->get('perfil');

        if (!verifyPasswordGenerate($id, $perfil)) {
            redirect($perfil . '/home', ['informar', 'Usuario já alterou sua senha', 'info']);
        }

        \App\classes\View::srender([
            'partials.header-html',
            'pages.senha_gerada',
            'partials.footer-html'
        ], [
            'title' => 'Renovar a senha Gerada',
            'id' => $id,
        ]);
    }

    public function renovarSenha()
    {
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
        $id = (int) ($data['id'] ?? 0);

        try {
            $this->settingService->renewPassword($id, $data);
            $perfil = session()->get('perfil');
            redirect($perfil . '/home', ['success', 'Senha renovada com sucesso!', 'success']);
        } catch (\App\Exceptions\ValidationException $e) {
            redirect('renovar_senha_gerado', ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect('renovar_senha_gerado', ['error', $e->getMessage(), 'danger']);
        }
    }

    public function recuperarSenha()
    {
        if (empty($_SESSION['etapa_senha'])) {
            $_SESSION['etapa_senha'] = 1;
        }

        $etapa = $_SESSION['etapa_senha'];
        
        $data = [
            'title' => ($etapa == 1) ? 'Procurar Usuario' : 'Recuperando Senha',
            'description' => ($etapa == 1) ? 'Encontrar Usuario' : 'Alterar Senha Esquecida',
            'keywords' => 'Recuperar, Senha, SGH'
        ];

        $page = ($etapa == 1) ? 'pages.search-user' : 'pages.altera-senha';

        $this->render([
            'partials.header-html',
            $page,
            'partials.footer-html'
        ], $data);
    }

    public function recovery($params)
    {
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
        $etapa = (int) $params['etapa'];
        $sessionEtapa = (int) ($_SESSION['etapa_senha'] ?? 0);

        if ($etapa !== $sessionEtapa) {
            throw new \Exception("Etapas não são compatíveis");
        }

        try {
            if ($etapa === 1) {
                $user = $this->settingService->findUserForRecovery($data['user'] ?? '');
                $_SESSION['etapa_senha'] = 2;
                $_SESSION['temp_recovery_id'] = $user->id;
                redirect(sprintf('recuperar_senha?email=%s&etapa=2', $user->email), ['info', 'Usuário encontrado', 'success']);
            } elseif ($etapa === 2) {
                $id = (int) ($_SESSION['temp_recovery_id'] ?? 0);
                $this->settingService->recoverPassword($id, $data);
                $_SESSION['etapa_senha'] = null;
                unset($_SESSION['temp_recovery_id']);
                redirect('login', ['success', 'Senha alterada com sucesso!']);
            }
        } catch (\App\Exceptions\ValidationException $e) {
            redirect('recuperar_senha', ['error', implode('<br>', $e->getErrors()), 'danger']);
        } catch (\Exception $e) {
            redirect('recuperar_senha', ['error', $e->getMessage(), 'danger']);
        }
    }
}
