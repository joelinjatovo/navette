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
        DB::table('car_types')->insert([
            'id' => 1,
            'name' => 'Sport',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('car_types')->insert([
            'id' => 2,
            'name' => 'SUV',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('car_brands')->insert([
            'id' => 1,
            'name' => 'Mazda',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('car_brands')->insert([
            'id' => 2,
            'name' => 'Toyota',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('car_brands')->insert([
            'id' => 3,
            'name' => 'Renault',
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('car_models')->insert([
            'id' => 1,
            'name' => 'Mazda',
            'year' => '2020',
            'place' => 4,
            'car_brand_id' => 1,
            'car_type_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('car_models')->insert([
            'id' => 2,
            'name' => 'Mazda',
            'year' => '2019',
            'place' => 6,
            'car_brand_id' => 1,
            'car_type_id' => 2,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('cars')->insert([
            'id' => 1,
            'name' => 'Economics',
            'year' => '2020',
            'place' => 3,
            'car_model_id' => 1,
            'driver_id' => 1,
            'user_id' => 1,
            'club_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'car-01.png',
            'type' => "image/jpeg",
            'url' => "img/cars/car-01.jpg",
            'imageable_id' => 1,
            'imageable_type' => "App\Models\Car",
            'created_at' => now(),
        ]);
        
        DB::table('cars')->insert([
            'id' => 2,
            'name' => 'Moyen',
            'year' => '2019',
            'place' => 3,
            'car_model_id' => 2,
            'user_id' => 1,
            'club_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'car-02.jpg',
            'type' => "image/jpeg",
            'url' => "img/cars/car-02.jpg",
            'imageable_id' => 2,
            'imageable_type' => "App\Models\Car",
            'created_at' => now(),
        ]);
        
        DB::table('cars')->insert([
            'id' => 3,
            'name' => 'Van',
            'year' => '2019',
            'place' => 6,
            'car_model_id' => 2,
            'user_id' => 1,
            'club_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'car-01.jpg',
            'type' => "image/jpeg",
            'url' => "img/cars/car-01.jpg",
            'imageable_id' => 3,
            'imageable_type' => "App\Models\Car",
            'created_at' => now(),
        ]);
        
        DB::table('cars')->insert([
            'id' => 4,
            'name' => 'Van XL',
            'year' => '2019',
            'place' => 8,
            'car_model_id' => 2,
            'user_id' => 1,
            'club_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'car-01.jpg',
            'type' => "image/jpeg",
            'url' => "img/cars/car-01.jpg",
            'imageable_id' => 4,
            'imageable_type' => "App\Models\Car",
            'created_at' => now(),
        ]);
    }
}
