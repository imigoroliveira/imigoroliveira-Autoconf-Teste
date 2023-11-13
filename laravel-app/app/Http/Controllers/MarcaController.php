<?php

namespace App\Http\Controllers;

use App\Models\MarcaModel;
use App\Models\Modelo; 
use App\Models\ModeloModel;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',

        ]);

        $marca = new MarcaModel([
            'nome' => $request->input('nome'),
        ]);

        $marca->save();

        $dadosCriados = [
            'id' => $marca->id,
            'nome' => $marca->nome,
        ];

        return response()->json(['success' => 'Marca criada com sucesso!', 'modelo' => $dadosCriados]);
    }
    
    public function listar()
    {
        $marcas = MarcaModel::all();

        return response()->json(['marcas' => $marcas]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
        ]);
        
        $marca = MarcaModel::findOrFail($id);
    
        $updateData = [
            'nome' => $request->input('nome'),
        ];
    
        $marca->update($updateData);
    
        $dadosAtualizados = [
            'nome' => $marca->nome
        ];
    
        return response()->json(['success' => 'Marca atualizada com sucesso!', 'veiculo' => $dadosAtualizados]);
    }


    public static function getMarcaByModelo($id)
    {
        $marca = MarcaModel::find($id);

        if ($marca) {
            return $marca;
        }

        return 'Marca Desconhecida';
    }

    public function delete($id)
    {
        try {
            $marca = MarcaModel::findOrFail($id);
            $marca->delete();
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false]);
        }
    }
    
}