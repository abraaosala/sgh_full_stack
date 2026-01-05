<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    public $timestamps = false;
    protected $fillable = [
        'usuario_id',
        'code',
        'telefone',
        'endereco',
        'provincia_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
}
