<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    protected $table = 'acessos';
    
    public $timestamps = false;
    
    protected $guarded = [];
}
