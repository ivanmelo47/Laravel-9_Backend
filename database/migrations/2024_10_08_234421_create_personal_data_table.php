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
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id('personal_data_id');
            $table->string('uuid', 100)->unique();
            // Definir 'user_id' como BIGINT(20)
            $table->bigInteger('user_id')->unsigned(); // BIGINT sin signo
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('second_last_name', 50);
            $table->string('phone', 20)->nullable();
            $table->timestamps();

            // Agregar un índice para user_id
            $table->index('user_id');
        });
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
