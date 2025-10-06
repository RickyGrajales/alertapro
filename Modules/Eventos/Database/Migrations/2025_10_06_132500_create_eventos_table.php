<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();
            $table->text('descripcion')->nullable();
            $table->date('due_date');
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Completado'])->default('Pendiente');

            // FK hacia tabla 'usuarios' (módulo Usuarios)
            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('usuarios')->onDelete('cascade');

            // FK hacia tabla 'templates' (módulo Plantillas)
            $table->unsignedBigInteger('plantilla_id')->nullable();
            $table->foreign('plantilla_id')->references('id')->on('templates')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

