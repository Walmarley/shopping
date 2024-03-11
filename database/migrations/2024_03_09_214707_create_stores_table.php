<?php

use App\Models\Shopping;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shopping::class)->references('id')->on('shoppings')->onDelete('CASCADE');
            $table->string('nome');
            $table->string('RazaoSocial');
            $table->string('CNPJ')->unique();
            $table->string('endereco');
            $table->string('classificacao');
            $table->string('responsavel');
            $table->string('numeroDaLoja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store', function(Blueprint $table){
            $table->dropForeignIdFor(Shopping::class);
        });
        Schema::dropIfExists('stores');
    }
};
