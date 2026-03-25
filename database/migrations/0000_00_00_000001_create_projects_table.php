<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->integer('nr')->nullable();

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('product_family')->nullable();

            $table->integer('estimated_volume')->nullable();
            $table->string('questionnaire_completion')->nullable();

            $table->string('nda_status')->nullable();

            $table->string('mou_status')->nullable();
            $table->string('tca_status')->nullable();
            $table->string('contract_status')->nullable();
            $table->string('bom_status')->nullable();

            $table->string('price_agreement')->nullable();
            $table->string('project_status')->nullable();

            $table->string('assembly_approach')->nullable();
            $table->string('assembly_line')->nullable();
            $table->string('layout')->nullable();

            $table->integer('production_2026')->nullable();
            $table->integer('potential_volume')->nullable();

            $table->text('comments')->nullable();
            $table->text('next_steps')->nullable();

            $table->tinyInteger('estado')
                ->default(2)
                ->comment('0=Eliminado, 1=Inactivo, 2=Activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
