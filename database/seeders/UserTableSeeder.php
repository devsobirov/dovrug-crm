<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Sobirov Otabek',
                'email' => 'devsobirov@gmail.com',
                'roles' => json_encode(['director']),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'depository_id' => 1
            ],
            [
                'name' => 'Director Name',
                'email' => 'director@mail.com',
                'roles' => json_encode(['director']),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'depository_id' => 1
            ],
            [
                'name' => 'Administrator Name',
                'email' => 'admin@mail.com',
                'roles' => json_encode(['administrator', 'designer', 'depositor']),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'depository_id' => 1
            ],
            // [
            //     'name' => 'Administrator-2 Name',
            //     'email' => 'admin2@mail.com',
            //     'roles' => json_encode(['accountant','administrator', 'designer', 'depositor']),
            //     'email_verified_at' => now(),
            //     'password' => Hash::make(12345678),
            //     'remember_token' => Str::random(10),
            // ],
            // [
            //     'name' => 'Dizayner Name',
            //     'email' => 'designer@mail.com',
            //     'roles' => json_encode(['designer', 'depositor']),
            //     'email_verified_at' => now(),
            //     'password' => Hash::make(12345678),
            //     'remember_token' => Str::random(10),
            // ],
            // [
            //     'name' => 'Kassir Name',
            //     'email' => 'accountant@mail.com',
            //     'roles' => json_encode(['accountant', 'depositor']),
            //     'email_verified_at' => now(),
            //     'password' => Hash::make(12345678),
            //     'remember_token' => Str::random(10),
            // ],
            [
                'name' => 'Складчик 1',
                'email' => 'depositor@mail.com',
                'roles' => json_encode(['depositor']),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'depository_id' => 1
            ],
            [
                'name' => 'Складчик 2',
                'email' => 'depositor2@mail.com',
                'roles' => json_encode(['depositor']),
                'email_verified_at' => now(),
                'password' => Hash::make(12345678),
                'remember_token' => Str::random(10),
                'depository_id' => 2
            ],
        ];

        \DB::table('users')->insert($users);
    }
}
