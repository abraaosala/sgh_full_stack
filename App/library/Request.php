<?php

namespace App\library;

use App\classes\Validator;

abstract class Request
{
    public array $data;

    public function __construct()
    {
        $this->data= $this->methodPost();
        //aplicar a regras rules
        $this->apply_rules();
    }

    abstract protected function rules();

    public function methodPost():array  {
        return sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
    }

    public function __set($name, $value){
        $this->data[$name]= $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function all()
    {
        return $this->data;
    }

    //
    public function apply_rules()
    {
        $this->rules();
    }
}
