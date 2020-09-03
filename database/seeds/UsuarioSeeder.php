<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Eduardo',
            'email' => 'gorki.eduardo@gmail.com',
            'url' => 'http://codigojuan.com',
            'password' => Hash::make(12345678),
        ]);


        $user2 = User::create([
            'name' => 'Eduardo2',
            'email' => 'gorki2.eduardo@gmail.com',
            'url' => 'http://elfinancierosa.com',
            'password' => Hash::make(12345678),
        ]);
    }
}
