<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->decimal('desconto', 10, 2); 
            $table->boolean('percentual')->default(false);
            $table->decimal('valor_minimo', 10, 2)->nullable();
            $table->date('validade');
            $table->integer('quantidade');
            $table->integer('quantidade_usada');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cupons');
    }
};

