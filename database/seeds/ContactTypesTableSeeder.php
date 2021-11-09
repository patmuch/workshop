<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ContactTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('contact_types')->truncate();
        DB::table('contact_types')->insert(
            [
                [
                    'name' => 'Customer'
                    
                ],
                [
                    'name' => 'Supplier'
                  
                ],
               
            ]
        );
    }
}

