<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'Admin',
            'role' => 'admin',
            'password' => Hash::make("123456"),
            'email' => 'admin@app.com',
            'avatar' => 'https://i1.sndcdn.com/artworks-000248908839-wlug27-t500x500.jpg',
        ];
        User::create($admin);
    }
}
