<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'uid' => "00000000-0000-0000-0000-000000000000",
            'email' => "example@mini.api",
            'password' => Str::uuid()->toString()
        ]);
    }
}
