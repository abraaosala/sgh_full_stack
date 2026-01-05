<?php

namespace App\classes;

use App\Dao\Models\Model;
use App\Dao\Models\Permition as ModelsPermition;
use Random\Engine\Secure;

class Permition
{
    public $user;

    public $exclude = [
        'Home',
        'Profile',
        'Dashboard',

    ];


    //actionsToDie

    public function __construct(public $controller, public $method)
    {
        $this->user = getUser(Session::get('model'), Session::get('id'));;
        //Inicia
        // $this->permition();
    }

    public function permition()
    {
        if ($this->verify()) {
        }
    }

    public function dbpermition()
    {

        $model = new ModelsPermition();
        $model->select()
            ->where(
                'perfil_id',
                '=',
                $this->user->perfil_id

            );
        return  $model->first();
    }

    public function isToDie(): never
    {
        throw new \Exception("Sem Permissao");
    }

    public function verify()
    {
        if (in_array($this->controller, $this->exclude)) {
            return true;
        }

        if (!$this->user) {
            return false;
        }

        if ($this->user->perfil_id == 1) {
            return true;
        }

        $permitions = $this->dbpermition();
        //filtrar controller e method
        if (!$permitions) {
            return false;
        }

        $actions = $permitions->actions;
        $actions = explode(',', $actions);

        if (in_array($this->controller, $actions)) {
            return true;
        }

        return in_array($this->method, $actions);
    }
}
