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
            'distance' => 10000,
            'unit' => 'm',
            'privatizedPrice' => 40,
            'price' => 5,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('zones')->insert([
            'name' => 'Zone 2',
            'distance' => 20000,
            'unit' => 'm',
            'privatizedPrice' => 80,
            'price' => 10,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('zones')->insert([
            'name' => 'Zone 3',
            'distance' => 30000,
            'unit' => 'm',
            'privatizedPrice' => 120,
            'price' => 15,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('zones')->insert([
            'name' => 'Zone 4',
            'distance' => 40000,
            'unit' => 'm',
            'privatizedPrice' => 160,
            'price' => 20,
            'currency' => 'EUR',
            'user_id' => 1,
            'created_at' => now(),
        ]);
    }
}
