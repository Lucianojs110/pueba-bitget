<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_templates', function (Blueprint $table) {
            $table->id();

            // Relación con el servicio (obligatoria)
            $table->foreignId('service_id')
                ->constrained()
                ->onDelete('cascade');

            // Relación con la etapa plantilla (opcional, por si hay checklists globales de servicio)
            $table->foreignId('stage_template_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->string('name');               // Ej: "Revisar nivel de aceite"
            $table->text('description')->nullable(); // Detalle opcional
            $table->integer('position')->default(0); // Orden dentro de la etapa
            $table->boolean('is_required')->default(false); // Si el ítem es obligatorio (opcional)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_templates');
    }
};
