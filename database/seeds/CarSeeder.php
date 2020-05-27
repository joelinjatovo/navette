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
        DB::table('car_types')->insert(['id' => 1, 'name' => 'Sport', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_types')->insert(['id' => 2, 'name' => 'SUV', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_types')->insert(['id' => 3, 'name' => 'Van', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_types')->insert(['id' => 4, 'name' => 'Bus', 'user_id' => 1, 'created_at' => now()]);
        
        DB::table('car_brands')->insert(['id' => 1, 'name' => 'Mazda', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_brands')->insert(['id' => 2, 'name' => 'Toyota', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_brands')->insert(['id' => 3, 'name' => 'Mercedes', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_brands')->insert(['id' => 4, 'name' => 'Kia', 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_brands')->insert(['id' => 5, 'name' => 'Renault', 'user_id' => 1, 'created_at' => now()]);
        
        DB::table('car_models')->insert(['id' => 1, 'name' => 'Mazda 2020 (5 Places)', 'year' => '2020', 'place' => 5, 'car_type_id' => 1, 'car_brand_id' => 1, 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_models')->insert(['id' => 2, 'name' => 'Mazda 2018 (5 Places)', 'year' => '2018', 'place' => 5, 'car_type_id' => 1, 'car_brand_id' => 1, 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_models')->insert(['id' => 3, 'name' => 'Mazda 2020 (9 Places)', 'year' => '2020', 'place' => 9, 'car_type_id' => 2, 'car_brand_id' => 1, 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_models')->insert(['id' => 4, 'name' => 'Toyota 2020 (18 Places)', 'year' => '2020', 'place' => 18, 'car_type_id' => 3, 'car_brand_id' => 2, 'user_id' => 1, 'created_at' => now()]);
        DB::table('car_models')->insert(['id' => 5, 'name' => 'Toyota 2020 (32 Places)', 'year' => '2020', 'place' => 32, 'car_type_id' => 4, 'car_brand_id' => 2, 'user_id' => 1, 'created_at' => now()]);
        
        DB::table('cars')->insert(['id' => 1, 'name' => 'Economics', 'year' => '2020', 'place' => 5, 'car_model_id' => 1, 'driver_id' => 2, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 2, 'name' => 'Moyen', 'year' => '2020', 'place' => 9, 'car_model_id' => 3, 'driver_id' => 3, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 3, 'name' => 'Van', 'year' => '2020', 'place' => 18, 'car_model_id' => 4, 'driver_id' => 4, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('cars')->insert(['id' => 4, 'name' => 'Van XXL', 'year' => '2020', 'place' => 32, 'car_model_id' => 5, 'driver_id' => 5, 'user_id' => 1, 'club_id' => 1, 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-01.jpg', 'type' => "image/jpeg", 'url' => "img/cars/car-01.jpg", 'imageable_id' => 1, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        DB::table('images')->insert(['name' => 'car-02.jpg', 'type' => "image/jpeg", 'url' => "img/cars/car-02.jpg", 'imageable_id' => 2, 'imageable_type' => "App\Models\Car", 'created_at' => now()]);
        
	}
}
