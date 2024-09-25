<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'id' => Str::uuid(),
                'username' => 'hcm1',
                'email' => 'dinainggrid@gmail.com',
                'telegram_id' => '6369827440',
                'password' => bcrypt('password123'),
                'role' => 'HCM',
            ],
            [
                'id' => Str::uuid(),
                'username' => 'user1',
                'email' => 'dinainggrid@gmail.com',
                'telegram_id' => '6369827440',
                'password' => bcrypt('password123'),
                'role' => 'USER',
            ],
            [
                'id' => Str::uuid(),
                'username' => 'performance1',
                'email' => 'dinainggrid@gmail.com',
                'telegram_id' => '6369827440',
                'password' => bcrypt('password123'),
                'role' => 'PERFORMANCE',
            ],
            [
                'id' => '123210191',
                'username' => 'Rangga Arya',
                'email' => 'dinainggrid@gmail.com',
                'telegram_id' => '6369827440',
                'password' => bcrypt('password123'),
                'role' => 'MITRA',
            ],
            [
                'id' => Str::uuid(),
                'username' => 'FA1',
                'email' => 'dinainggrid@gmail.com',
                'telegram_id' => '6369827440',
                'password' => bcrypt('password123'),
                'role' => 'FA',
            ],
        ]);
    }
}
