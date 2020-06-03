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
        DB::table('cars')->insert(['id' => 1, 'name' => 'Economics', 'place' => 5, 'driver_id' => 1, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 2, 'name' => 'Moyen', 'place' => 8, 'driver_id' => 2, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 3, 'name' => 'Van', 'place' => 18, 'driver_id' => 3, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 4, 'name' => 'Van XXL', 'place' => 32, 'driver_id' => 4, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-01.jpg', 'type' => "image/jpeg", 'url' => "img/cars/car-01.jpg", 'imageable_id' => 1, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-02.jpg', 'type' => "image/jpeg", 'url' => "img/cars/car-02.jpg", 'imageable_id' => 2, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        
	}
}
