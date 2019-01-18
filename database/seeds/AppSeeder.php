<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 100)->create();
        factory(App\Seller::class, 20)->create();
        factory(App\Client::class, 20)->create();
    }
}
