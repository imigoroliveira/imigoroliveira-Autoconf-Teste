<?php

namespace App\Http\Controllers;

use App\Models\Modelo; 
use App\Models\ModeloModel;
use Illuminate\Http\Request;

class ModeloController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'marca_id' => 'required|exists:marcas,id',

        ]);

        $modelo = new ModeloModel([
            'nome' => $request->input('nome'),
            'marca_id' => $request->input('marca_id'),
        ]);

        $modelo->save();

        $dadosCriados = [
            'id' => $modelo->id,
            'nome' => $modelo->nome,
            'marca_id' => $modelo->marca_id,
        ];

        return response()->json(['success' => 'Modelo criado com sucesso!', 'modelo' => $dadosCriados]);
    }

    public static function listar()
    {
        $modelos = ModeloModel::all();
    
        foreach ($modelos as $modelo) {
            $marca = MarcaController::getMarcaByModelo($modelo->marca_id);

            $modelo->marca = $marca;
        }
    
        return response()->json([
            'success' => true,
            'data' => $modelos,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'marca_id' => 'required|numeric'
        ]);
        
        $modelo = ModeloModel::findOrFail($request->id);

        $updateData = [
            'nome' => $request->input('nome'),
            'marca_id' => $request->input('marca_id'),
        ];

        $modelo->update($updateData);

        $dadosAtualizados = [
            'nome' => $modelo->nome,
            'marca_id' => $modelo->marca_id,
        ];
    
        return response()->json(['success' => 'Modelo atualizado com sucesso!', 'veiculo' => $dadosAtualizados]);
    }
    public static function getModelById($modeloId)
    {
        $modelo = ModeloModel::find($modeloId);
        if ($modelo) {
            return $modelo;
        }

        return '';
    }


    public function delete($id)
    {
        try {
            $modelo = ModeloModel::findOrFail($id);
            $modelo->delete();
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false]);
        }
    }
}