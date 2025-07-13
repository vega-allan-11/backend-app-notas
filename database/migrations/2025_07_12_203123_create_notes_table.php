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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // 🔗 Clave foránea al usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 📝 Campos de la nota
            $table->string('title');
            $table->text('content');

            // 📌 Campos opcionales si usas etiquetas o soft delete
            $table->string('tags')->nullable();  // opcional
            $table->softDeletes();               // para eliminar sin borrar físicamente

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
