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
        $this->call(UserTableSeeder::class);
        $this->call(BuyTableSeeder::class);
        $this->call(SaleTableSeeder::class);
        $this->call(FinanceTableSeeder::class);
        $this->call(BuildingTableSeeder::class);
        $this->call(ShippingTableSeeder::class);
    }
}
