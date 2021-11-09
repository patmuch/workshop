<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->truncate();

        DB::table('payments')->insert(
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
                    'name' => 'Cheque'
                    
                ],
               
            ]
        );
    }
}
