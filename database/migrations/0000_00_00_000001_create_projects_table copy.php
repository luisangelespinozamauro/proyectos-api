<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->string('nr')->nullable();

            //Nuevo campo
            $table->string('main_contact_supervisor')->nullable();

            //Nuevo campo
            $table->string('model_family')->nullable();

            //Nuevo campo
            $table->string('models')->nullable();

            $table->string('estimated_volume')->nullable();

            //Nuevo campo
            $table->string('plant_line')->nullable();

            $table->string('questionnaire_completion')->nullable();
            $table->string('nda_status')->nullable();
            $table->string('mou_status')->nullable();
            $table->string('tca_status')->nullable();

            //Nuevo campo
            $table->string('trademark_license_agreement')->nullable();

            $table->string('contract_status')->nullable();
            $table->string('bom_status')->nullable();
            $table->string('project_status')->nullable();
            $table->string('assembly_approach')->nullable();
            $table->string('assembly_line')->nullable();

            //Nuevo campo
            $table->string('homologation_status')->nullable();

            //Nuevo campo
            $table->string('estimated_sop')->nullable();

            //Nuevo campo
            $table->string('project_mgr')->nullable();
            $table->string('potential_volume')->nullable();


            $table->string('april_15th')->nullable();
            $table->string('may_11th')->nullable();
            $table->text('pending_points_legal')->nullable();
            $table->text('support_requested_to_raul')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
