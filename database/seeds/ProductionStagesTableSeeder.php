<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductionStagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('production_stages')->truncate();
        DB::table('production_stages')->insert(
            [
                [
                    'name' => 'Work-in-Progress'
                    
                ],
                [
                    'name' => 'Done'
                  
                ],
                [
                    'name' => 'Not started'
                  
                ],
                [
                    'name' => 'Blocked'
                  
                ],
               
            ]
        );
    }
}

