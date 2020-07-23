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
        if(env('APP_ENV') == 'local')
        {
            // $this->call(UserTableSeeder::class);
            // $this->call(StatusTableSeeder::class);
            // $this->call(BuyTableSeeder::class);
            // $this->call(SaleTableSeeder::class);
            // $this->call(FinanceTableSeeder::class);
            // $this->call(BuildingTableSeeder::class);
            // $this->call(ShippingTableSeeder::class);
            // $this->call(DeliveryTableSeeder::class);
            // $this->call(StatusTableSeeder::class);
            // $this->call(AddVerificarStatusSeeder::class);
            // $this->call(ScheduleTableSeeder::class);
            // $this->call(UpdateStatusSeeder::class);
            // $this->call(CatalogsTablesSeeder::class);
            // $this->call(MigrationTablesSeeder::class);
            // $this->call(SlugsCheckSeeder::class);
            $this->call(ChangeOriginNameSeeder::class);
        }
        else if(env('APP_ENV') == 'testing')
        {
            $this->call(ChangeOriginNameSeeder::class);
        }
        else
        {
            $this->call(ChangeOriginNameSeeder::class);
        }
    }
}
