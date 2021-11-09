<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('order_status')->truncate();
        DB::table('order_status')->insert(
            [
                [
                    'name' => 'Processing'
                    
                ],
                [
                    'name' => 'Packaging'
                  
                ],
                [
                    'name' => 'Shipping'
                  
                ],
                [
                    'name' => 'Delivered'
                  
                ],
               
            ]
        );
    }
}

