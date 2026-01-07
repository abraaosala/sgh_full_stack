<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-09-20 16:55:16


class Funcionario extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'funcionarios';

    public array $fillable = [
        // Adicione aqui os campos que podem ser preenchidos em massa
        'usuario_id',
        'numero_ordem',
        'nivel',
        'hospital',
        'telefone',
        'provincia_id'
    ];

    /**
     * Métodos específicos para o modelo Funcionario podem ser adicionados aqui.
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