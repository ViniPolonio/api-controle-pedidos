<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            
            $table->string('cor')->nullable(); 
            $table->string('tamanho', 5)->nullable(); 

            $table->integer('quantidade')->default(0);

            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('estoques');
    }
};
