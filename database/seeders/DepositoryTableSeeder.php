<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('depositories')->insert(['name' => 'Асосий склад - Янгиариқ']);
        DB::table('depositories')->insert(['name' => 'Иккинчи склад - Ҳонқа']);
    }
}
