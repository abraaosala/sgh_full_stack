<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-05 07:44:35

class Paciente extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'pacientes'; 


    public array $fillable= [
        'id',
        'usuario_id',
        'code',
        'data_nascimento',
        'telefone',
        'endereco',
        'provincia_id',
        'criado_em'
    ];

    /**
     * Métodos específicos para o modelo Paciente podem ser adicionados aqui.
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