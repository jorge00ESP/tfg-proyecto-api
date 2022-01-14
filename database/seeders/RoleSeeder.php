<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'rol'=>'Estandar'
        ]);

        DB::table('roles')->insert([
            'rol'=>'Admin'
        ]);

        DB::table('roles')->insert([
            'rol'=>'Trabajador'
        ]);

        DB::table('roles')->insert([
            'rol'=>'Cliente'
        ]);
    }
}
