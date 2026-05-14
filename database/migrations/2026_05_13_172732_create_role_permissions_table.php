<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles');

            $table->foreignId('permission_id')
                ->constrained('permissions');

            $table->tinyInteger('estado')
                ->default(2)
                ->comment('0=Eliminado, 1=Inactivo, 2=Activo');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
};
