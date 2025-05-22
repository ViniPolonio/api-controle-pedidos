<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produtos\ProdutosCreateRequest;
use App\Http\Requests\Produtos\ProdutosUpdateRequest;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class ProdutosController extends Controller
{
    public function index()
    {
        try {
            $produtos = Produtos::all();
            return ResponseHelper::success($produtos, 'Lista de produtos retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar produtos: ' . $e->getMessage(), 500);
        }
    }

    public function store(ProdutosCreateRequest $request)
    {
        try {
            $produto = Produtos::create($request->validated());
            return ResponseHelper::success($produto, 'Produto cadastrado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao cadastrar produto: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return ResponseHelper::error('Produto não encontrado.', 404);
            }

            return ResponseHelper::success($produto, 'Produto encontrado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar produto: ' . $e->getMessage(), 500);
        }
    }

    public function update(ProdutosUpdateRequest $request, $id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return ResponseHelper::error('Produto não encontrado.', 404);
            }

            $produto->update($request->validated());

            return ResponseHelper::success($produto, 'Produto atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar produto: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return ResponseHelper::error('Produto não encontrado.', 404);
            }

            $produto->delete();

            return ResponseHelper::success([], 'Produto removido com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao remover produto: ' . $e->getMessage(), 500);
        }
    }
}
