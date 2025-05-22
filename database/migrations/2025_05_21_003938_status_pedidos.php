<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('status_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao')->nullable(); 
            $table->timestamps();
        });

        // Rodando na migration para otimizar tempo -> correto é criar seeder
        DB::table('status_pedidos')->insert([
            ['nome' => 'Pendente'],
            ['nome' => 'Aguardando pagamento'],
            ['nome' => 'Pagamento concluído'],
            ['nome' => 'Em trânsito'],
            ['nome' => 'Entregue'],
            ['nome' => 'Cancelado'],
            ['nome' => 'Extraviado'],
            ['nome' => 'Solicitação de devolução'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('status_pedidos');
    }
};
