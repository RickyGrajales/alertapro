<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizacion_plantilla', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('organizacion_id')
                ->constrained('organizaciones')
                ->onDelete('cascade');

            $table->foreignId('plantilla_id')
                ->constrained('templates')
                ->onDelete('cascade');

            $table->timestamps();

            // Evita duplicados
            $table->unique(['organizacion_id', 'plantilla_id'], 'org_template_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizacion_plantilla');
    }
};
