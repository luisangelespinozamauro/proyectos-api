<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands');

            $table->string('nr')->nullable();

            //Ya no aparece en el excel
            $table->string('model')->nullable();
            //Ya no aparece en el excel
            $table->string('product_family')->nullable();

            $table->string('estimated_volume')->nullable();
            $table->string('questionnaire_completion')->nullable();

            $table->string('nda_status')->nullable();

            $table->string('mou_status')->nullable();
            $table->string('tca_status')->nullable();
            $table->string('contract_status')->nullable();
            $table->string('contract_status2')->nullable();
            $table->string('bom_status')->nullable();

            //Ya no aparece en el excel
            $table->string('price_agreement')->nullable();
            $table->string('project_status')->nullable();

            $table->string('assembly_approach')->nullable();
            $table->string('assembly_line')->nullable();

            //Ya no aparece en el excel
            $table->string('layout')->nullable();
            $table->string('potential_volume')->nullable();

            //Ya no aparece en el excel
            $table->string('due_diligence')->nullable();

            $table->string('comments')->nullable();
            $table->string('next_steps')->nullable();

            $table->tinyInteger('estado')
                ->default(2)
                ->comment('0=Eliminado, 1=Inactivo, 2=Activo');

            $table->timestamps();

            //Nuevos Campos
            $table->string('main_contact_supervisor')->nullable();
            $table->string('model_family')->nullable();
            $table->string('models')->nullable();
            $table->string('plant_line')->nullable();
            $table->string('trademark_license_agreement')->nullable();
            $table->string('homologation_status')->nullable();
            $table->string('estimated_sop')->nullable();
            $table->string('project_mgr')->nullable();
            $table->string('pending_points_legal')->nullable();
            $table->string('support_requested')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
