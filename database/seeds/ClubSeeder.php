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
            'lat' => 49.127983,
            'lng' => 2.2396556,
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
            'mime' => "image/png",
            'url' => "img/clubs/vegas-club.png",
            'imageable_id' => 1,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 2,
            'name' => 'Grisy Club',
            'lat' => 48.8178148,
            'lng' => 1.3483707,
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
            'mime' => "image/jpeg",
            'url' => "img/clubs/grisy-club.jpg",
            'imageable_id' => 2,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 3,
            'name' => 'LE R7 - Restaurant Lounge Club',
            'lat' => 49.1270697,
            'lng' => 2.0311066,
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
            'mime' => "image/jpeg",
            'url' => "img/clubs/r7-club.jpg",
            'imageable_id' => 3,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 4,
            'name' => 'Pacha Club',
            'lat' => 48.8482925,
            'lng' => 2.1065443,
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
            'mime' => "image/jpeg",
            'url' => "img/clubs/pacha-club.jpg",
            'imageable_id' => 4,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
    }
}
