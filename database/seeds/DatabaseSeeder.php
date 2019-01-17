<?php

use Illuminate\Database\Seeder;
use App\Connection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Connection::create([
            "ruc" => "12312312312",
            "database" => "nbdata2018_1",
        ]);
        
        Connection::create([
            "ruc" => "12312312315",
            "database" => "nbdata2018_2",
        ]);
        
        $this->call(ConnectionTableSeeder::class);
    }
}
