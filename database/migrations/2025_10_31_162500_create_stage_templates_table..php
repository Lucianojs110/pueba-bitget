<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stage_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->unsignedInteger('position')->default(0); // orden dentro del flujo del servicio
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('stage_templates');
    }
};
