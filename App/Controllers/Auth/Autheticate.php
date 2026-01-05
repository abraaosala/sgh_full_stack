<?php

namespace App\controllers;

use App\classes\FlashMessage;
use App\classes\Password;
use App\classes\Session;
use App\trait\View;
use App\Dao\Entity\AcessoEntity;
use App\Dao\Models\Acesso;
use App\Dao\Models\User;
use App\Http\Request;
use App\library\PostOld;

class Autheticate
{

    use View;

    public function index()
    {

        // Render the login view
        $data = [
            'title' => 'Login',
            'keywords' => 'login, sistema, hospitalar'
        ];
        return $this->render([
            'partials/header-html',
            'auth/login',
            'partials/footer-html',
        ], data($data));
    }

    public function attempt()
    {


        $model = new User();
        $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
        //======================================
        $email = lower($data['email']);
        $senha = $data['password'];
        //======================================


        if ($email === '' || $email === '0' || empty($senha)) {
            PostOld::set($data);
            redirect('login', ['error', "Campos Obrigatórios", 'danger']);
        }

        $user = $model->findbyEmail($email);
        // dd($user);
        if (empty($user)) {
            PostOld::set($data);
            redirect('login', ['error', "Credencias não coresponde", 'danger']);
        }

        // dd(Password::verify($senha, $user->senha));
        if (!Password::verify($senha, $user->senha)) {
            PostOld::set($data);
            redirect('login', ['error', "Credencias não coresponde", 'danger']);
        }

        PostOld::clean();
        /* Implementar Session para posteriormente usar Cookie */

        $mAcesso = new Acesso(AcessoEntity::class);
        $acesso = $mAcesso->select()
            ->where('usuario_id', '=', $user->id)->model();

        if (!$acesso) {
            $mAcesso->setEntity()->usuario_id = $user->id;
            $mAcesso->setEntity()->ip_login = $_SERVER['SERVER_ADDR'];
            $mAcesso->store();
        }



        //guardar acessos 

        Session::multiSet([
            'id' => $user->id,
            'perfil' => $user->perfil_id,
            'model' => $model::class
        ]);


        redirect('admin/dashboard');
    }

    public function logout()
    {

        // Handle user logout
        Session::destroy();



        redirect('login');
    }
}
