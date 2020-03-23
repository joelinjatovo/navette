<?php

use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('points')->insert([
            'id' => 1,
            'name' => 'Vegas Club',
            'lng' => 49.127983,
            'lat' => 2.2396556,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 1,
            'name' => 'Vegas Club',
            'point_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'vegas-club.png',
            'type' => "image/png",
            'url' => "uploads/vegas-club.png",
            'imageable_id' => 1,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 2,
            'name' => 'Grisy Club',
            'lng' => 48.8178148,
            'lat' => 1.3483707,
            'alt' => 8,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 2,
            'name' => 'Grisy Club',
            'point_id' => 2,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'grisy-club.png',
            'type' => "image/jpeg",
            'url' => "uploads/grisy-club.jpg",
            'imageable_id' => 2,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 3,
            'name' => 'LE R7 - Restaurant Lounge Club',
            'lng' => 49.1270697,
            'lat' => 2.0311066,
            'alt' => 14,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 3,
            'name' => 'LE R7 - Restaurant Lounge Club',
            'point_id' => 3,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'r7-club.png',
            'type' => "image/jpeg",
            'url' => "uploads/r7-club.jpg",
            'imageable_id' => 3,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 4,
            'name' => 'Pacha Club',
            'lng' => 48.8482925,
            'lat' => 2.1065443,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 4,
            'name' => 'Pacha Club',
            'point_id' => 4,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'pacha-club.png',
            'type' => "image/jpeg",
            'url' => "uploads/pacha-club.jpg",
            'imageable_id' => 4,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
    }
}
