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
                    'name' => 'Pcs',
                    'description' => 'Pieces',
                ],

                [
                    'name' => 'EA',
                    'description' => 'Each',
                ],
			
                [
                    'name' => 'M',
                    'description' => 'Metres',
                ],
                [
                    'name' => 'L',
                    'description' => 'Litres',
                ],
                [
                    'name' => 'KG',
                    'description' => 'Kilogram',
                ],
                
              
            ]
        );
    }
}
