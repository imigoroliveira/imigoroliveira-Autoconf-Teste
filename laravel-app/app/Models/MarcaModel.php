<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaModel extends Model
{ 
    protected $table = 'marcas'; 
    public $timestamps = false;
    protected $fillable = [
        'nome'
    ];
}