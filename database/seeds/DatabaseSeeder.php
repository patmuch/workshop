<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(UomsTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(StockAvailabilityTableSeeder::class);
        $this->call(PaymentTypeTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(MovementsTableSeeder::class);
		$this->call(ProductionStagesTableSeeder::class);
    }
}
