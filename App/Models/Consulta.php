<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';
    
    public $timestamps = false;
    
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'data_consulta',
        'motivo',
        'observacoes'
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
