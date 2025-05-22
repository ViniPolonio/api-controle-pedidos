{{-- resources/views/emails/pedidos/aprovado.blade.php --}}
@component('mail::message')
# Pedido Aprovado!

Olá, {{ $pedido->createdBy->name ?? 'Cliente' }}!

Seu pedido de número **#{{ $pedido->id }}** foi aprovado com sucesso.

@component('mail::button', ['url' => url('/pedidos/' . $pedido->id)])
Ver Pedido
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
