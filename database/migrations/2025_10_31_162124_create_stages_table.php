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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');

            // Datos de la etapa
            $table->string('name');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
