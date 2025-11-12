<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_stage_items', function (Blueprint $table) {
            $table->id();

            //  Relación con la etapa real de la orden de trabajo
            $table->foreignId('work_order_stage_id')->constrained()->onDelete('cascade');

            //  Relación con el ítem base del checklist (la plantilla)
            $table->foreignId('checklist_template_id')->constrained()->onDelete('cascade');

            // Estado del ítem (ej: revisado o no)
            $table->boolean('is_ok')->default(false);

            $table->timestamps();

            $table->unique(
                ['work_order_stage_id', 'checklist_template_id'],
                'uniq_workstage_checktemplate'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_stage_items');
    }
};
