<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'obwarfredrick906@gmail.com')->delete();

        DB::table('users')->insert([
            'name' => 'Fredrick Obwar',
            'email' => 'obwarfredrick906@gmail.com',
            'password' => bcrypt('@kafum2030'),
            'type' => 'admin',
        ]);
    }
}
