<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    protected $table = 'exames';
    
    public $timestamps = false;
    
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'tipo',
        'resultado',
        'data_exame'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}
