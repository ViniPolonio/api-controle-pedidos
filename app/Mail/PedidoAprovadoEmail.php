<?php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedidos;

class PedidoAprovadoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public function __construct(Pedidos $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        return $this->subject('Seu pedido foi aprovado!')
                    ->markdown('emails.pedidos.aprovado');
    }
}

