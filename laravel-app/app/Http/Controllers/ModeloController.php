<?php

namespace App\Http\Controllers;

use App\Models\Modelo; 
use App\Models\ModeloModel;
use Illuminate\Http\Request;

class ModeloController extends Controller
{

    public static function listar()
    {
        $modelo = ModeloModel::all();
        if ($modelo) {
            return $modelo;
        }

        return '';
    }

    public static function getModelById($modeloId)
    {
        $modelo = ModeloModel::find($modeloId);
        if ($modelo) {
            return $modelo;
        }

        return '';
    }
}