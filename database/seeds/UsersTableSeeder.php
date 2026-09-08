<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'           => 'Administrator',
            'username'       => 'admin',
            'password'       => bcrypt('admin'),
            'level'          => 'admin',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name'           => 'Pemilik',
            'username'       => 'pemilik',
            'password'       => bcrypt('pemilik'),
            'level'          => 'pemilik',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name'           => 'Karyawan',
            'username'       => 'karyawan',
            'password'       => bcrypt('karyawan'),
            'level'          => 'karyawan',
            'remember_token' => Str::random(10),
        ]);
    }
}
