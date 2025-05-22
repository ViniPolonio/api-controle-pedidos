<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;
use App\Http\Requests\Estoque\EstoqueCreateRequest;
use App\Http\Requests\Estoque\EstoqueUpdateRequest;
use App\Helpers\ResponseHelper;

class EstoqueController extends Controller
{
    public function index()
    {
        try {
            $estoques = Estoque::all();
            return ResponseHelper::success($estoques, 'Lista de estoques retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar estoques: ' . $e->getMessage(), 500);
        }
    }

    public function store(EstoqueCreateRequest $request)
    {
        try {
            $estoque = Estoque::create($request->validated());
            return ResponseHelper::success($estoque, 'Estoque cadastrado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao cadastrar estoque: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $estoque = Estoque::find($id);

            if (!$estoque) {
                return ResponseHelper::error('Estoque não encontrado.', 404);
            }

            return ResponseHelper::success($estoque, 'Estoque encontrado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar estoque: ' . $e->getMessage(), 500);
        }
    }

    public function update(EstoqueUpdateRequest $request, $id)
    {
        try {
            $estoque = Estoque::find($id);

            if (!$estoque) {
                return ResponseHelper::error('Estoque não encontrado.', 404);
            }

            $estoque->update($request->validated());

            return ResponseHelper::success($estoque, 'Estoque atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar estoque: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $estoque = Estoque::find($id);

            if (!$estoque) {
                return ResponseHelper::error('Estoque não encontrado.', 404);
            }

            $estoque->delete();

            return ResponseHelper::success([], 'Estoque removido com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao remover estoque: ' . $e->getMessage(), 500);
        }
    }
}
