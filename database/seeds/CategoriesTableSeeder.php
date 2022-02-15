<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert(
            [
                [
                    'name' => 'E-Power',
                    'description' => Str::words(20),
                ],
                [
                    'name' => 'Compact Car',
                    'description' => Str::words(20),
                ],
                [
                    'name' => 'Light Car',
                    'description' => Str::words(20),
                ],
                [
                    'name' => 'Minivan',
                    'description' => Str::words(20),
                ],
                [
                    'name' => 'Sports & Specialty',
                    'description' => Str::words(20),
                ],
                [
                    'name' => 'Sedan',
                    'description' => Str::words(20),
                ],
            ]
        );
    }
}
