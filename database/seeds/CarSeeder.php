<?php

use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cars')->insert(['id' => 1, 'status' => 'available', 'name' => 'AA-572-BF', 'place' => 8, 'driver_id' => 1, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 2, 'status' => 'unavailable', 'name' => 'BA-737-AT', 'place' => 8, 'driver_id' => 2, 'user_id' => 1, 'club_id' => 2, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 3, 'status' => 'unavailable', 'name' => 'AB-439-MT', 'place' => 8, 'driver_id' => 3, 'user_id' => 1, 'club_id' => 3, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 4, 'status' => 'unavailable', 'name' => 'WS-015-BT', 'place' => 8, 'driver_id' => 4, 'user_id' => 1, 'club_id' => 4, 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-01.jpg', 'mime' => "image/jpeg", 'url' => "img/cars/car-01.jpg", 'imageable_id' => 1, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-02.jpg', 'mime' => "image/jpeg", 'url' => "img/cars/car-02.jpg", 'imageable_id' => 2, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        
	}
}
