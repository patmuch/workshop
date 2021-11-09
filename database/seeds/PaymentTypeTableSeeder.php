<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('payment_type')->truncate();
        DB::table('payment_type')->insert(
            [
                [
                    'name' => 'Cash'
                    
                ],
                [
                    'name' => 'Credit'
                  
                ],
                [
                    'name' => 'Mpesa'
                  
                ],
                [
                    'name' => 'Bank transfer'
                  
                ],
              
               
            ]
        );
    }
}

