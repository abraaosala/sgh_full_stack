<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leito extends Model
{
    protected $table = 'leitos';

    protected $fillable = [
        'numero',
        'tipo',
        'status',
        'descricao'
    ];

    public $timestamps = true;
}
