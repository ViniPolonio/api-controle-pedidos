<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\PedidosCreateRequest;
use App\Http\Requests\Pedidos\PedidosUpdateRequest;
use App\Models\Cupons;
use App\Models\Estoque;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();

            $data = $request->validated();
            
            $data['created_by'] = 1; // ou auth()->id();

            $cupom = null;

            $itens = $data['itens']; // salva os itens para usar depois
            $data['itens'] = json_encode($itens);

            $pedido = Pedidos::create($data);

            // 🔻 Baixar do estoque
            foreach ($itens as $item) {
                $estoque = Estoque::where('id', $item['product_id'])->first();

                if ($estoque) {
                    if ($estoque->quantidade < $item['quantidade']) {
                        // Lógica se faltar estoque (opcional)
                        DB::rollBack();
                        return ResponseHelper::error("Estoque insuficiente para o produto ID {$item['product_id']}", 422);
                    }

                    $estoque->quantidade -= $item['quantidade'];
                    $estoque->save();
                } else {
                    DB::rollBack();
                    return ResponseHelper::error("Produto ID {$item['product_id']} não encontrado no estoque", 404);
                }
            }

            if ($cupom) {
                $cupom->increment('quantidade_usada');
            }

            DB::commit();

            return ResponseHelper::success($pedido, 'Pedido criado com sucesso.', 201);

        } catch (\Exception $e) {
            DB::rollBack();
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
