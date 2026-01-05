<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\classes\Validator\GeneralValidator as Validator;
use App\classes\View;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\User;
use App\Http\Request;
use App\trait\TemplateView;

class SettingController
{
    use TemplateView;

    public function renovarSenhaGerate($params)
    {
        $id = (int) urldecode((string) session()->get('id'));
        $perfil = session()->get('perfil');

        if (!verifyPasswordGenerate($id, $perfil)) {
            redirect($perfil . '/home', ['informar', 'Usuario já alterou sua senha', 'info']);
        }

        View::srender([
            'partials.header-html',
            'pages.senha_gerada',
            'partials.footer-html'
        ], data([
            'title' => 'Renovar a senha Gerada',
            'id' => $id,
        ]));
    }

    public function renovarSenha()
    {


        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
        $user = (new User(UserEntity::class))->findById($data['id']);
        $model = new User(UserEntity::class);
        // dd($data);
        $validator = validator($data);
        $validator->Roles('senha', 'required', 'Senha é campo Obrigatório');
        /*   $validator->Roles('senha', 'between', "Senha não correspondde, deve ter entre 8 a 16 caracteres",[8,16]); */
        $validator->Roles('confirm_password', 'required', 'Senha é campo Obrigatório');
        $validator->Roles('senha', 'compare', 'Senha não são compativeis', [$data['confirm_password']]);
        // dd($data);

        if (!$validator->validation()) {
            $errors = $validator->getErrors();
            // dd($errors);
            if ($errors['senha']) {
                // code...
                redirect('config/renovar_senha_gerado', ['password', $errors['senha'], 'danger']);
            }

            if ($errors['confirm_password']) {
                // code...
                redirect('config/renovar_senha_gerado', ['confirm_password', $errors['confirm_password'], 'danger']);
            }
        }

        unset($data['confirm_password']);

        // dd();
        if (!$user) {
            redirect('config/renovar_senha_gerado', ['error', 'Usuario não foi encontrado', 'danger']);
        }

        // remover a senha gerada  no store
        fileManager()->delete('email', $user->email);

        $model->setEntity()->senha = Password::hash($data['senha']);
        $model->setEntity()->id = $data['id'];
        $model->setEntity()->senha_gerada = null;

        $updated = $model->save();
        if ($updated) {
            redirect($user->perfil . '/home', ['success', 'Senha renovada com sucesso!', 'success']);
        }

        // entity_data_itera($data,$model);
        // dd();
    }

    public function procurarUsuario() {}

    public function recuperarSenha()
    {

        if (empty($_SESSION['etapa_senha'])) {
            $_SESSION['etapa_senha'] = 1;
        }

        // if (empty($_SESSION['etapa_senha']))
        //     ;

        $etapa = $_SESSION['etapa_senha'];
        if ($etapa == 1):
            $data = [
                'title' => 'Procurar Usuario',
                'description' => 'Encontrar Usuario',
                'keywords' => 'Encontrar, Usuario, Senha'
            ];
            $this->render([
                'partials.header-html',
                'pages.search-user',
                'partials.footer-html'
            ], globals($data));
        elseif ($etapa == 2):

            $data = [
                'title' => 'Recuperando Senha',
                'description' => 'Alterar Senha Esquecida',
                'keywords' => 'alterar, Senha, Nova Senha, Esquecido',
            ];
            $this->render([
                'partials.header-html',
                'pages.altera-senha',
                'partials.footer-html'
            ], globals($data));
        endif;
    }

    public function recovery($params)
    {

        $data = sanitizeInput((new Request)->getBody());
        $model = new User(UserEntity::class);
        $etapa = (int) $params['etapa'];

        $e_senha =  $_SESSION['etapa_senha'];
        // dd($etapa);
        if ($etapa !== $e_senha) {
            throw new \Exception("Etapas não são compativeis");
        }

        if ($e_senha === 1) {
            $usuario = $data['user'];
            if (!Validator::required($usuario)) {
                redirect('recuperar_senha', ['error', 'O Campo é Obrigatorio', 'danger']);
            }

            if (!Validator::email($usuario) || !Validator::email($usuario)) {
                redirect(
                    'recuperar_senha',
                    ['error', 'Valor não é compativel, deve ser email ou BI', 'danger']
                );
            }

            $user = $model->select()->where(function ($model) use ($usuario) {
                $model->where('email', '=', $usuario)
                    // ->where('bi', '=', $usuario, 'or')
                ;
            })->first();
            if (!$user) {
                redirect(
                    'recuperar_senha',
                    ['error', 'Usuario não foi encontrado', 'danger']
                );
            }

            $_SESSION['etapa_senha'] = 2;
            $_SESSION['id'] = $user->id;
            redirect(
                sprintf('recuperar_senha?email=%s?etapa=2', $user->email),
                ['info', 'Usuario encontrado', 'success']
            );
            // dd($user);


        } elseif ($e_senha === 2) {
            // dd($data);
            $id = (int) $_SESSION['id'];
            if (!Validator::required($data['senha'])) {
                redirect(
                    'recuperar_senha',
                    ['password', 'Campo Obrigatório', 'danger']
                );
            }

            // if (!Validator::between($data['senha'], 6, 16))
            //     redirect(
            //         'recuperar_senha',
            //         ['password', 'Deve ter entre 6 a 16 digitos', 'danger']
            //     );
            if (!Validator::required($data['confirm_password'])) {
                redirect(
                    'recuperar_senha',
                    ['confirm_password', 'Campo Obrigatório', 'danger']
                );
            }

            if (!Validator::compare($data['senha'], $data['confirm_password'])) {
                redirect(
                    'recuperar_senha',
                    ['password', 'Senha Senhas sao diferentes', 'danger']
                );
            }

            //Atribuir valores no entity     
            $model->setEntity()->id = $_SESSION['id'];
            $model->setEntity()->senha = Password::hash($data['senha']);

            //Actualizar
            $update = $model->save();
            if ($update) {
                $_SESSION['etapa_senha'] = null;
            }

            // session_destroy();
            redirect(
                'login',
                ['success', 'Senha alterado com Successo']
            );
            // dd($model);

        }
    }
}