<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->text('detalle')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('requerido')->default(false);
            $table->string('tipo', 50)->default('texto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_items');
    }
};
