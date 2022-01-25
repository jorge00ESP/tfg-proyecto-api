<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NosotrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->insert([
            'nombre'=>'jorge',
            'apellido'=>'bas',
            'email'=>'jorgebas@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'id_rol'=>'2'
        ]);

        DB::table('users')->insert([
            'nombre'=>'saul',
            'apellido'=>'sarias',
            'email'=>'saulsarias@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'id_rol'=>'2'
        ]);

        DB::table('users')->insert([
            'nombre'=>'carlos',
            'apellido'=>'vera',
            'email'=>'carlosvera@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'id_rol'=>'2'
        ]);

        DB::table('users')->insert([
            'nombre'=>'jonas',
            'apellido'=>'espanol',
            'email'=>'jonasespanol@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'id_rol'=>'2'
        ]);

        DB::table('users')->insert([
            'nombre'=>'usuario',
            'apellido'=>'prueba',
            'email'=>'prueba@gmail.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'id_rol'=>'2'
        ]);
    }
}
