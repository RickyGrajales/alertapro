<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    if (!Schema::hasTable('documentos_evento')) {
        Schema::create('documentos_evento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->string('nombre');
            $table->string('ruta');
            $table->string('tipo')->nullable();
            $table->timestamps();
        });
    }
}
    
    public function down(): void
    {
        Schema::dropIfExists('documento_eventos');
    }
};
