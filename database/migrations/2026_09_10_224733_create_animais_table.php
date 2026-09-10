<?php

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
        Schema::create('animais', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->enum('especie', ['cato', 'gato']);
            $table->enum('porte', ['pequeno', 'medio', 'grande']);
            $table->enum('sexo', ['macho', 'femea']);
            $table->date('data_nascimento_estimada');
            $table->enum('situacao', ['registrado', 'disponivel', 'em_processo', 'adotado'])->default('registrado');
            $table->boolean('castrado')->default(false);
            $table->boolean('vacinado')->default(false);
            $table->boolean('vermifugado')->default(false);
            $table->text('descricao')->nullable();
            $table->date('data_recebimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animais');
    }
};
