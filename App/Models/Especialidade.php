<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'especialidades';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nome'
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'especialidade_id');
    }
}
