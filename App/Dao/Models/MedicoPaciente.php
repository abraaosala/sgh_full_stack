<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-22 10:59:49


class MedicoPaciente extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'medico_paciente'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);

    }

    /**
     * Métodos específicos para o modelo MedicoPaciente podem ser adicionados aqui.
     *
     * Exemplo:
     *
     * public function findbyEmail($emailId)
     * {
     *       return $this->select($fields)
     *     ->where('email', '=', $emailId)
     *     ->first();
     * }
     */
}