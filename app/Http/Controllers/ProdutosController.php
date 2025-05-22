<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produtos\ProdutosCreateRequest;
use App\Http\Requests\Produtos\ProdutosUpdateRequest;
use App\Models\Estoque;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;


class ProdutosController extends Controller
{
    public function index()
    {
        try {
            // Carrega os produtos com o relacionamento 'estoque'
            $produtos = Produtos::with('estoque')->get();

            return ResponseHelper::success($produtos, 'Lista de produtos retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar produtos: ' . $e->getMessage(), 500);
        }
    }


        public function store(ProdutosCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $produtoData = $request->except(['cor', 'tamanho', 'quantidade']);
            $produto = Produtos::create($produtoData);

            $estoqueData = [
                'produto_id' => $produto->id,
                'cor' => $request->cor,
                'tamanho' => $request->tamanho,
                'quantidade' => $request->quantidade,
            ];
            Estoque::create($estoqueData);

            DB::commit();

            return ResponseHelper::success($produto, 'Produto cadastrado com sucesso.', 201);
        } catch (\Exception $e) {
            DB::rollBack();

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
