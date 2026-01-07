<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnosticos';
    
    public $timestamps = false;
    
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'doenca_id',
        'data_diagnostico',
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

    public function doenca()
    {
        return $this->belongsTo(Doenca::class, 'doenca_id');
    }

    public function tratamentos()
    {
        return $this->hasMany(Tratamento::class, 'diagnostico_id');
    }
}
