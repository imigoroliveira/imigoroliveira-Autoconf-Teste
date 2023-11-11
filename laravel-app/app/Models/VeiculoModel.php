<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VeiculoModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'veiculos';

    protected $fillable = ['modelo_id', 'preco', 'imagem'];
}