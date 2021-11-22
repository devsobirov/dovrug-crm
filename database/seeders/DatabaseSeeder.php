<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            DepositoryTableSeeder::class,
            UserTableSeeder::class,
            UnitsTableSeeder::class
        ]);
        Material::factory(100)->create();
    }
}
