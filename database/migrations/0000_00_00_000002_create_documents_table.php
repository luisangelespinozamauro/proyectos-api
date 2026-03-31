<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->enum('type', ['QUESTIONNAIRE', 'NDA', 'MOU', 'TCA', 'CONTRACT', 'BOM', 'PRICE', 'LAYOUT']);

            $table->string('name')->nullable(); // nombre lógico
            $table->integer('current_version')->default(1);

            $table->tinyInteger('estado')
                ->default(2)
                ->comment('0=Eliminado, 1=Inactivo, 2=Activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
