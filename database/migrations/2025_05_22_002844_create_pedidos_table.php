<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('status_pedidos')->onDelete('restrict');

            $table->json('itens'); 
            $table->decimal('subtotal', 10, 2);
            $table->decimal('frete', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
        
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('endereco_referencia')->nullable();
        
        
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
        
            $table->timestamps();
        
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
        
    }

    public function down(): void {
        Schema::dropIfExists('pedidos');
    }
};

