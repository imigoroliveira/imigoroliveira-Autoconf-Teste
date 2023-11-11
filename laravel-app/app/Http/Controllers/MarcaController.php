<?php

namespace App\Http\Controllers;

use App\Models\MarcaModel;
use App\Models\Modelo; 
use App\Models\ModeloModel;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function listar()
    {
        $marcas = MarcaModel::all();

        return response()->json(['marcas' => $marcas]);
    }

    public static function getMarcaByModelo($id)
    {
        $marca = MarcaModel::find($id);

        if ($marca) {
            return $marca;
        }

        return 'Marca Desconhecida';
    }

}