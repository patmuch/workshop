<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StockAvailabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('stock_availability')->truncate();
        DB::table('stock_availability')->insert(
            [
                [
                    'name' => 'In stock'
                    
                ],
                [
                    'name' => 'Not available'
                  
                ],
                [
                    'name' => 'Expected'
                  
                ],
                [
                    'name' => 'Sold'
                  
                ],
              
               
            ]
        );
    }
}

