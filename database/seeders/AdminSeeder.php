<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@protectora.com',
            'password'   => Hash::make('root'),
            'es_admin'   => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
