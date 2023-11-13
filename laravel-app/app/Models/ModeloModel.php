<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloModel extends Model
{
    protected $table = 'modelos'; 

    protected $fillable = [
        'nome', 'marca_id', 'created_at', 'updated_at'
    ];

}