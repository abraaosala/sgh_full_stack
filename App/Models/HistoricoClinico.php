<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoClinico extends Model
{
    protected $table = 'historicos_clinicos';

    protected $fillable = [
        'paciente_id',
        'descricao',
        'data_registro'
    ];

    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
