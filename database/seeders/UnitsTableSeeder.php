<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'symbol' => 'Шт',
                'name' => 'Дона'
            ],
            [
                'symbol' => 'м',
                'name' => 'Метр'
            ],
            [
                'symbol' => 'м²',
                'name' => 'Метр квадрат'
            ],
            [
                'symbol' => 'м³',
                'name' => 'Метр куб'
            ],
            [
                'symbol' => 'Қути',
                'name' => 'Қути'
            ],
            [
                'symbol' => 'Гр',
                'name' => 'Грамм'
            ],
            [
                'symbol' => 'Кг',
                'name' => 'Килограмм'
            ],
            [
                'symbol' => 'Т',
                'name' => 'Тонна'
            ],
            [
                'symbol' => 'Л',
                'name' => 'Литр'
            ],
            [
                'symbol' => 'Лист',
                'name' => 'Лист'
            ],
        ];

        \DB::table('units')->insert($units);
    }
}
