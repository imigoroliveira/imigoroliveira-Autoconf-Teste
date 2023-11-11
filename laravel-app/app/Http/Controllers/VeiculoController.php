<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;
use App\Models\VeiculoModel;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\MarcaController;


class VeiculoController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'preco' => 'required|numeric',
            'imagem' => 'required',
        ]);

        $veiculo = new VeiculoModel([
            'modelo_id' => $request->input('modelo_id'),
            'preco' => $request->input('preco'),
            'imagem' => $request->input('imagem'),
        ]);

        $veiculo->save();

        $dadosCriados = [
            'id' => $veiculo->id,
            'modelo_id' => $veiculo->modelo_id,
            'preco' => $veiculo->preco,
            'imagem' => $veiculo->imagem,
        ];

        return response()->json(['success' => 'Veículo criado com sucesso!', 'veiculo' => $dadosCriados]);
    }

    public function listar()
    {
        $veiculos = VeiculoModel::all();
    
        foreach ($veiculos as $veiculo) {
            $modelo = ModeloController::getModelById($veiculo->modelo_id);
            $marca = MarcaController::getMarcaByModelo($veiculo->modelo_id);

            $veiculo->modelo = $modelo;
            $veiculo->marca = $marca;
        }
    
        return response()->json([
            'success' => true,
            'data' => $veiculos,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'preco' => 'required|numeric',
            'imagem' => 'required',
        ]);
        
        $veiculo = VeiculoModel::findOrFail($request->id);

        $updateData = [
            'modelo_id' => $request->input('modelo_id'),
            'preco' => $request->input('preco'),
            'imagem' => $request->input('imagem'),
        ];

        $veiculo->update($updateData);

        $dadosAtualizados = [
            'modelo_id' => $veiculo->modelo_id,
            'preco' => $veiculo->preco,
            'imagem' => $veiculo->imagem,
        ];
    
        return response()->json(['success' => 'Veiculo atualizado com sucesso!', 'veiculo' => $dadosAtualizados]);
    }

    public function delete($id)
    {
        try {
            $veiculo = VeiculoModel::findOrFail($id);
            $veiculo->delete();
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false]);
        }
    }
}
