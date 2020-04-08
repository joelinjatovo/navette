<?php

use Illuminate\Database\Seeder;

class RideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rides')->insert([
            'id' => 1,
            'status' => 'ping',
            'driver_id' => 1,
            'user_id' => 1,
            'car_id' => 1,
            'created_at' => now(),
        ]);
    }
}
