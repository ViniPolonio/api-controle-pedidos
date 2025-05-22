<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao'); 
            $table->decimal('preco', 10, 2);
            $table->integer('status')->comment('1 - Ativo | 0- Inativo ');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void {
        Schema::dropIfExists('produtos');
    }
};
