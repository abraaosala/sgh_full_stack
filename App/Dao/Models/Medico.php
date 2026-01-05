<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-05 07:44:35

class Medico extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'medicos'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct($entity= null) {

        parent::__construct($entity);

    }

    /**
     * Métodos específicos para o modelo Medico podem ser adicionados aqui.
     *
     * Exemplo:
     *
     * public function findbyEmail($emailId)
     * {
     *       return $this->select($fields)
     *      ->where('email', '=', $emailId)
     *      ->first();
     * }
     */
}