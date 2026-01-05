<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'usuarios';

    public $timestamps = false; // Assuming false based on legacy code not showing distinct timestamp handling

    protected $fillable = [
        'nome',
        'email',
        'senha', // Changed from senha_hash to senha
        'perfil',
        'criado_em',
        'genero'
    ];

    // Simple auth methods for compatibility (adjusting to use senha_hash if needed by legacy auth)
    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function medico()
    {
        return $this->hasOne(Medico::class, 'usuario_id');
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'usuario_id');
    }
}
