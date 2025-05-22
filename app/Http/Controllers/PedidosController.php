<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\PedidosCreateRequest;
use App\Http\Requests\Pedidos\PedidosUpdateRequest;
use App\Models\Cupons;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class PedidosController extends Controller
{
    public function index()
    {
        try {
            $pedidos = Pedidos::all();
            return ResponseHelper::success($pedidos, 'Lista de pedidos retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar pedidos: ' . $e->getMessage(), 500);
        }
    }

    public function store(PedidosCreateRequest $request)
    {
        try {
            $data = $request->validated();
            
            // $user = auth()->user();
            // $data['created_by'] = $user->id;
            $data['created_by'] = 1;

            $cupom = null;

            $data['itens'] = json_encode($data['itens']);

            $pedido = Pedidos::create($data);

            if ($cupom) {
                $cupom->increment('quantidade_usada');
            }

            return ResponseHelper::success($pedido, 'Pedido criado com sucesso.', 201);

        } catch (\Exception $e) {
            \Log::error('Erro ao criar pedido', ['exception' => $e]);
            return ResponseHelper::error('Erro interno ao processar o pedido.', 500);
        }
    }


    public function show($id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            return ResponseHelper::success($pedido, 'Pedido encontrado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function update(PedidosUpdateRequest $request, $id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            $pedido->update($request->validated());

            return ResponseHelper::success($pedido, 'Pedido atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            $pedido->delete();

            return ResponseHelper::success([], 'Pedido removido com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao remover pedido: ' . $e->getMessage(), 500);
        }
    }
}
