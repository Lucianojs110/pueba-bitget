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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            // Relación con la orden
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');

            // Token público de seguimiento
            $table->uuid('public_token')->unique();

            // Calificación y comentario
            $table->unsignedTinyInteger('rating')->nullable(); // 1 a 5
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
