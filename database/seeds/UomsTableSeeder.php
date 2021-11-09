<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uoms')->truncate();

        DB::table('uoms')->insert(
            [
                [
                    'name' => 'CM',
                    'description' => 'CentiMetre',
                ],
                [
                    'name' => 'M',
                    'description' => 'Metre',
                ],
                [
                    'name' => 'L',
                    'description' => 'Litre',
                ],
                [
                    'name' => 'KG',
                    'description' => 'Kilogram',
                ],
                [
                    'name' => 'G',
                    'description' => 'Gram',
                ],
                [
                    'name' => 'P',
                    'description' => 'Pounds',
                ],
            ]
        );
    }
}
