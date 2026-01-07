<?php

namespace App\Dao\Models;


// Arquivo gerado automaticamente em: 2025-08-05 07:44:35

class User extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'usuarios';

    public array $fillable = [
        'id',
        'nome',
        'email',
        'senha',
        'perfil',
        'senha', 
        'perfil',
        'genero'
    ];

    public function findbyEmail($email, $fields = '*')
    {
        return $this->select($fields)
            ->where('email', '=', $email)
            ->first();
    }

    public function findbyPerfil($perfil, $fields = '*')
    {
        return $this->select($fields)
            ->where('perfil', '=', $perfil)
            ->first();
    }
}