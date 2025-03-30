<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            ['name' => 'super admin',
            'email' => 'super@gmail.com',
            'gambar' => 'profile.jpg',
            'role' =>'super admin',
            'password' => bcrypt('super123'),
            'created_at' => now(),
            'updated_at' => now(),],

            ['name' => 'admin',
            'email' => 'admin@gmail.com',
            'gambar' => 'profile.jpg',
            'role' =>'admin',
            'password' => bcrypt('admin123'),
            'created_at' => now(),
            'updated_at' => now(),],

            [
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'gambar' => 'profile.jpg',
            'role' =>'kasir',
            'password' => bcrypt('kasir123'),
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
