<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->enum('recurrencia', ['Nunca','Diaria','Semanal','Mensual','Anual'])->default('Nunca');
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        Schema::create('template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->text('detalle')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('requerido')->default(false);
            $table->string('tipo', 50)->default('texto'); // texto, archivo, checkbox, fecha...
            $table->timestamps();
        });

        Schema::create('notification_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->onDelete('cascade');
            $table->string('canal', 50); // email, whatsapp, sms...
            $table->integer('offset_days')->default(0); // días antes/ después
            $table->enum('momento', ['antes','despues'])->default('antes');
            $table->string('hora')->nullable();
            $table->timestamps();
        });

        // Pivot con organizaciones (si ya tienes migración similar, ignora)
        Schema::create('organizacion_plantilla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizacion_id')->constrained('organizaciones')->onDelete('cascade');
            $table->foreignId('plantilla_id')->constrained('templates')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['organizacion_id','plantilla_id'],'org_template_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizacion_plantilla');
        Schema::dropIfExists('notification_rules');
        Schema::dropIfExists('template_items');
        Schema::dropIfExists('templates');
    }
};
