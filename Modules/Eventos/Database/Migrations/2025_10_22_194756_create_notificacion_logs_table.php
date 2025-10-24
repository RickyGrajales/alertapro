<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacion_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Usuario que recibe
            $table->string('canal')->default('email');
            $table->string('destinatario')->nullable();
            $table->text('mensaje')->nullable();
            $table->timestamp('enviado_en')->nullable();
            $table->boolean('exitoso')->default(false);
            $table->text('error')->nullable();
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion_logs');
    }
};
