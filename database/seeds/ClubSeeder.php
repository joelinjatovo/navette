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
            'name' => 'Antananarivo, Madagascar',
            'long' => -18.8873012,
            'lat' => 47.3724257,
            'alt' => 11,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'name' => 'Club Antananarivo',
            'point_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 2,
            'name' => 'Toamasina, Madagascar',
            'long' => -18.1303933,
            'lat' => 49.3220981,
            'alt' => 12,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'name' => 'Club Toamasina',
            'point_id' => 2,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 3,
            'name' => 'Antsirabe, Madagascar',
            'long' => -19.8549619,
            'lat' => 46.9821708,
            'alt' => 12,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'name' => 'Club Antsirabe',
            'point_id' => 3,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        
        DB::table('points')->insert([
            'id' => 4,
            'name' => 'Antsirabe, Madagascar',
            'long' => -25.1775697,
            'lat' => 46.0723836,
            'alt' => 14,
            'user_id' => 1,
            'created_at' => now(),
        ]);
        DB::table('clubs')->insert([
            'name' => 'Club Antsirabe',
            'point_id' => 4,
            'user_id' => 1,
            'created_at' => now(),
        ]);
    }
}
