<?php

namespace App\Observers;

use App\Models\Pedidos;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoStatusAtualizado;
use PedidoAprovadoEmail;

class PedidoObserver
{
    public function updated(Pedidos $pedido): void
    {
        // Checa se o status foi alterado e é 3 - Pagamento Concluido
        if ($pedido->isDirty('status') && $pedido->status == 3) {
            // Busca o usuário criador do pedido
            $usuario = $pedido->createdBy;

            if ($usuario && $usuario->email) {
                Mail::to($usuario->email)->send(new PedidoAprovadoEmail($pedido));
            }
        }
    }
}
