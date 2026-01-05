<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    public $timestamps = false;
    protected $fillable = [
        'nome'
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'provincia_id');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'provincia_id');
    }
}
