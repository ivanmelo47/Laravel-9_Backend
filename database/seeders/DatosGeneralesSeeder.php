<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatosGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Informacion sobre mi
        DB::table('sobre_mi')->insert([
            'user_id'       => 1,
            'parrafo'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam unde soluta minima necessitatibus,
                                voluptas consectetur vero officiis quas, explicabo deleniti
                                repellendus aliquid debitis maiores numquam voluptate
                                reprehenderit in delectus dolores.',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Datos personales
        DB::table('personal_data')->insert([
            'user_id'       => 1,
            'uuid'          => Str::uuid(),
            'nombres'       => 'Josue Ivan',
            'apellido_paterno' => 'Melo',
            'apellido_materno' => 'Jaramillo',
            'telefono'      => '+52 744 118 6963',
            'cumpleanios'   => '23-10-2000',
            'linkedin'      => 'https://www.linkedin.com/in/josue-ivan-b510611a5/',
            'especialidad'  => 'Desarrollador Web',
            'cargo'         => 'FREELANCE',
            'direccion'     => 'Acapulco de Juarez, Guerrero, 39931',
        ]);

        // Redes sociales
        DB::table('redes_sociales')->insert([
            'user_id'       => 1,
            'nombre'        => 'Facebook',
            'url_red'       => 'https://www.facebook.com/ivan23.melojaramillo',
            'logo'          => 'fa-brands fa-facebook-f',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('redes_sociales')->insert([
            'user_id'       => 1,
            'nombre'        => 'Linkedin',
            'url_red'       => 'https://www.linkedin.com/in/josue-ivan-b510611a5/',
            'logo'          => 'fa-brands fa-linkedin-in',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Intereses
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Hardware',
            'logo'          => 'fa-solid fa-microchip',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Musica',
            'logo'          => 'fa-solid fa-music',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Viajar',
            'logo'          => 'fa-solid fa-plane',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Cine',
            'logo'          => 'fa-solid fa-film',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Videojuegos',
            'logo'          => 'fa-solid fa-gamepad',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('intereses')->insert([
            'user_id'       => 1,
            'nombre'        => 'Linux',
            'logo'          => 'fa-brands fa-linux',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Skills tecnicas
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Laravel 9',
            'tipo'          => 'tech_skill',
            'tipo_nombre'   => 'tech_skill',
            'logo'          => 'fa-brands fa-html5',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Vue Js',
            'tipo'          => 'tech_skill',
            'tipo_nombre'   => 'tech_skill',
            'logo'          => 'fa-brands fa-vuejs',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'MySQL',
            'tipo'          => 'tech_skill',
            'tipo_nombre'   => 'tech_skill',
            'logo'          => 'fa-brands fa-mysql',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Node Js',
            'tipo'          => 'tech_skill',
            'tipo_nombre'   => 'tech_skill',
            'logo'          => 'fa-brands fa-node-js',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Git Version Control',
            'tipo'          => 'tech_skill',
            'tipo_nombre'   => 'tech_skill',
            'logo'          => 'fa-brands fa-git',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Skills profesionales
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Desarrollo Web',
            'tipo'          => 'prof_skill',
            'tipo_nombre'   => 'prof_skill',
            'logo'          => 'fa-solid fa-code',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Documentación de codigo',
            'tipo'          => 'prof_skill',
            'tipo_nombre'   => 'prof_skill',
            'logo'          => 'fa-solid fa-code-commit',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Trabajo en Equipo',
            'tipo'          => 'prof_skill',
            'tipo_nombre'   => 'prof_skill',
            'logo'          => 'fa-solid fa-people-group',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Comunicación',
            'tipo'          => 'prof_skill',
            'tipo_nombre'   => 'prof_skill',
            'logo'          => 'fa-solid fa-comments',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('skills')->insert([
            'user_id'       => 1,
            'nombre'        => 'Proactividad',
            'tipo'          => 'prof_skill',
            'tipo_nombre'   => 'prof_skill',
            'logo'          => 'fa-solid fa-handshake',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Curriculum educacion
        DB::table('curriculum')->insert([
            'user_id'       => 1,
            'nombre'        => 'Bachillerato en Programación',
            'empresa'       => 'CETIS No.116',
            'inicio'        => '22-08-2016',
            'fin'           => '08-07-2019',
            'actualmente'   => false,
            'tipo'          => 'educacion',
            'descripcion'   => 'Estudié en el CETis No. 116, donde cursé la carrera técnica en Programación. Durante mi formación,
                                adquirí habilidades en programación en C, gestión de bases de datos MySQL y SQL, así como conocimientos
                                en mantenimiento de computadoras e instalación de sistemas operativos. Además, desarrollé competencias
                                en áreas relacionadas con la tecnología y la informática, lo que me permitió fortalecer mi capacidad
                                para resolver problemas y trabajar con diversas herramientas del sector.',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        DB::table('curriculum')->insert([
            'user_id'       => 1,
            'nombre'        => 'Ingeniería en Sistemas Computacionales',
            'empresa'       => 'Instituto Tecnológico de Acapulco',
            'inicio'        => '31-07-2019',
            'fin'           => '01-01-2025',
            'actualmente'   => false,
            'tipo'          => 'educacion',
            'descripcion'   => 'Estudié la carrera de Ingeniería en Sistemas Computacionales en el Instituto Tecnológico de Acapulco,
                                donde llevé mis conocimientos de programación a un nivel más avanzado, enfocándome en el desarrollo
                                completo de software. Aprendí a integrar planeación, diseño, codificación, gestión de bases de datos,
                                pruebas y documentación en proyectos de software. Además, expandí mis habilidades con nuevos lenguajes
                                de programación como Java, C# y PHP, así como con frameworks backend como Laravel y .NET Core,
                                fortaleciendo mi capacidad para desarrollar soluciones tecnológicas eficientes y escalables.',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
