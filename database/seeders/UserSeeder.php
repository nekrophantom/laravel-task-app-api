<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name'                  => 'admin',
                'password'              => bcrypt('password'),
                'email_verified_at'     => now(),
            ]
        );
    }
}
