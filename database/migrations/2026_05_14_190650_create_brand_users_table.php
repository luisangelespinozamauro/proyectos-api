<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('brand_users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onDelete('cascade');

            $table->tinyInteger('estado')
                ->default(2)
                ->comment('0=Eliminado, 1=Inactivo, 2=Activo');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('brand_users');
    }
};
