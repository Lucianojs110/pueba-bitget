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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('stage_id')->nullable()->constrained()->onDelete('cascade');

            // Datos del archivo
            $table->string('path'); // ruta en storage/app/public/...
            $table->string('filename')->nullable(); // nombre original
            $table->string('mime_type')->nullable(); // tipo MIME (image/jpeg, etc.)
            $table->text('caption')->nullable(); // descripción opcional

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
