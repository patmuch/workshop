<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('movements')->truncate();
        DB::table('movements')->insert(
            [
                [
                    'name' => 'IN'
                    
                ],
                [
                    'name' => 'OUT'
                  
                ],
                [
                    'name' => 'Adjustment'
                  
                ],
               
            ]
        );
    }
}

