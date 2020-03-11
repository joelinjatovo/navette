<?php

use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->insert([
            'name' => 'Zone 1',
            'distance' => 10,
            'unit' => 'km',
            'privatizedPrice' => 20,
            'price' => 10,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('zones')->insert([
            'name' => 'Zone 2',
            'distance' => 20,
            'unit' => 'km',
            'privatizedPrice' => 30,
            'price' => 20,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('zones')->insert([
            'name' => 'Zone 3',
            'distance' => 40,
            'unit' => 'km',
            'privatizedPrice' => 120,
            'price' => 30,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
    }
}
