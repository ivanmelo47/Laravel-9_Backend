<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::create('personal_data', function (Blueprint $table) {
            $table->id('personal_data_id');
            $table->string('uuid', 100)->unique();
            $table->bigInteger('user_id')->unsigned(); // BIGINT sin signo
            $table->string('nombres', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('url_img', 80)->nullable();
            $table->date('cumpleanios')->nullable();
            $table->string('linkedin', 100)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('cargo', 100)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->timestamps();

            // Agregar un índice para user_id
            $table->index('user_id');
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_data');
    }
};
