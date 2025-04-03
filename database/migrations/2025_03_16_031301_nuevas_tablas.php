<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE personal_data (
                personal_data_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                uuid VARCHAR(100) UNIQUE NOT NULL,
                user_id BIGINT UNSIGNED NOT NULL,
                nombres VARCHAR(50) NOT NULL,
                apellido_paterno VARCHAR(50) NOT NULL,
                apellido_materno VARCHAR(50) NULL,
                telefono VARCHAR(20) NULL,
                url_img VARCHAR(80) NULL,
                cumpleanios DATE NULL,
                linkedin VARCHAR(100) NULL,
                especialidad VARCHAR(100) NULL,
                cargo VARCHAR(100) NULL,
                direccion VARCHAR(100) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )
        ");

        DB::statement("
            CREATE TABLE sobre_mi (
                sobre_mi_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                parrafo TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )"
        );

        DB::statement("
            CREATE TABLE redes_sociales (
                redes_sociales_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                nombre VARCHAR(50) NOT NULL,
                url_red VARCHAR(100) NOT NULL,
                logo VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )
        ");

        DB::statement("
            CREATE TABLE skills (
                skills_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                nombre VARCHAR(50) NOT NULL,
                logo VARCHAR(100) NOT NULL,
                tipo VARCHAR(50) NOT NULL,
                tipo_nombre VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )"
        );

        DB::statement("
            CREATE TABLE intereses (
                intereses_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                nombre VARCHAR(50) NOT NULL,
                logo VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )"
        );

        DB::statement("
            CREATE TABLE curriculum (
                curriculum_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                nombre VARCHAR(50) NOT NULL,
                empresa VARCHAR(50) NOT NULL,
                inicio DATE NOT NULL,
                fin DATE NOT NULL,
                actualmente BOOLEAN NOT NULL,
                tipo VARCHAR(50) NOT NULL,
                descripcion VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )
        ");

        DB::statement("
            CREATE TABLE mensajes_entrantes (
                mensajes_entrantes_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                nombre VARCHAR(50) NOT NULL,
                telefono VARCHAR(20) NOT NULL,
                email VARCHAR(50) NOT NULL,
                tema VARCHAR(50) NOT NULL,
                mensaje VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )
        ");

        DB::statement("
            CREATE TABLE portafolio_trabajos (
                portafolio_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                url_img VARCHAR(80) NULL,
                nombre VARCHAR(80) NOT NULL,
                descripcion VARCHAR(80) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL,
                INDEX (user_id)
            )
        ");
    }

    public function down()
    {

    }
};
