<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-30 07:32:42


class Doenca extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'doencas_respiratorias'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);
        
    }

}