<?php

use Illuminate\Database\Seeder;

class ClubMgSeeder extends Seeder
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
            'name' => 'Restaurant Ravimpôntsy',
            'lat' => -18.9175739,
            'lng' => 47.5422863,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 1,
            'name' => 'Restaurant Ravimpôntsy',
            'point_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'vegas-club.png',
            'type' => "image/png",
            'url' => "img/clubs/vegas-club.png",
            'imageable_id' => 1,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 2,
            'name' => 'Shoprite Tsiadana',
            'lat' => -18.9153215,
            'lng' => 47.5385984,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 2,
            'name' => 'Shoprite Tsiadana',
            'point_id' => 2,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'grisy-club.png',
            'type' => "image/jpeg",
            'url' => "img/clubs/grisy-club.jpg",
            'imageable_id' => 2,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 3,
            'name' => 'Jet Club',
            'lat' => -18.9127615,
            'lng' => 47.5344172,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 3,
            'name' => 'Jet Club',
            'point_id' => 3,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'r7-club.png',
            'type' => "image/jpeg",
            'url' => "img/clubs/r7-club.jpg",
            'imageable_id' => 3,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 4,
            'name' => 'OPTIMUS Technology Antsahabe',
            'lat' => -18.9127615,
            'lng' => 47.5344172,
            'alt' => 17,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'id' => 4,
            'name' => 'OPTIMUS Technology Antsahabe',
            'point_id' => 4,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('images')->insert([
            'name' => 'pacha-club.png',
            'type' => "image/jpeg",
            'url' => "img/clubs/pacha-club.jpg",
            'imageable_id' => 4,
            'imageable_type' => "App\Models\Club",
            'created_at' => now(),
        ]);
    }
}
