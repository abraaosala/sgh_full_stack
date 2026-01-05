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
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);

    }

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