<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->id();
            $table->string('nr')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->string('main_contact')->nullable();
            $table->string('model_family')->nullable();
            $table->string('models')->nullable();
            $table->string('estimated_volume')->nullable();
            $table->string('plant')->nullable();
            $table->string('questionnaire_completion')->nullable();
            $table->string('nda_status')->nullable();
            $table->string('mou_status')->nullable();
            $table->string('tca_status')->nullable();
            $table->string('trademark_license_agreement')->nullable();
            $table->string('contract_status')->nullable();
            $table->string('bom_status')->nullable();
            $table->string('project_status')->nullable();
            $table->string('assembly_approach')->nullable();
            $table->string('assembly_line')->nullable();



            $table->string('product_family')->nullable();


            // Volumen y producción
            $table->string('potential_volume')->nullable();

            $table->string('production_2026')->nullable();

            $table->date('target_start_production')->nullable();
            $table->date('sop_date')->nullable();

            // Documentación / acuerdos







            $table->string('price_agreement')->nullable();

            // Ingeniería / sourcing
            $table->string('engineering_cost')->nullable();

            $table->string('rfq_sourcing')->nullable();

            $table->string('supplier_nomination')->nullable();

            // Estatus
            $table->string('current_status')->nullable();

            $table->string('due_diligence')->nullable();

            // Producción / ensamblaje



            $table->string('layout')->nullable();

            // Comentarios
            $table->text('comments')->nullable();

            $table->text('next_steps')->nullable();

            // Estado lógico
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
