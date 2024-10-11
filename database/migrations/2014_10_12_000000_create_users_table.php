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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('uuid', 100)->unique();
            $table->string('personal_token', 50);
            $table->string('username', 50)->unique();
            $table->string('url_img', 80)->nullable();
            $table->string('email', 80)->unique();
            $table->string('password', 100);
            $table->string('role', 20)->nullable()->default('user');
            $table->boolean('verificada')->nullable()->default(false);
            $table->boolean('status')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
