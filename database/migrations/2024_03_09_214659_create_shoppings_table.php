<?php

use App\Models\User;
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
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users')->onDelete('CASCADE');
            $table->string('nome');
            $table->string('RazaoSocial');
            $table->string('CNPJ')->unique();
            $table->string('endereco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shoppings', function (Blueprint $table) {
            $table -> dropForeignIdFor(User::class);
        });
        Schema::dropIfExists('shoppings');
    }
};
