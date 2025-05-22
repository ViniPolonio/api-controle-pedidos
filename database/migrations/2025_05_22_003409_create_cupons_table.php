<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $table->integer('quantidade_usada')->default(0);
            $table->timestamps();
        });

        DB::table('cupons')->insert([
            [
                'codigo' => 'MONTINK10',
                'desconto' => 10.00,
                'percentual' => true,
                'valor_minimo' => 50.00,
                'validade' => Carbon::now()->addDays(30)->toDateString(),
                'quantidade' => 100,
                'quantidade_usada' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('cupons');
    }
};


