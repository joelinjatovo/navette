<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(User::class, 10)->create();
        
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Haja JOELINJATOVO',
            'phone' => '+261331377768',
            'password' => Hash::make('admin!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'locale' => 'fr',
        ]);
        DB::table('images')->insert([
            'name' => 'haja.jpg',
            'mime' => "image/jpeg",
            'url' => "img/users/haja.jpg",
            'imageable_id' => 1,
            'imageable_type' => "App\Models\User",
            'created_at' => now(),
        ]);
        
        $i = 1;
        $roles = ['admin' => 'administrator', 'driver' => 'driver', 'customer' => 'customer'];
        foreach($roles as $role => $description){
            DB::table('roles')->insert([
                'id' => $i,
                'name' => $role,
                'description' => $description,
                'priority' => $i - 1,
                'user_id' => 1,
                'created_at' => now(),
            ]);
            $i++;
        }
        
        DB::table('role_user')->insert(['approved' => 1, 'user_id' => 1, 'role_id' => 1]);
        
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Driver2 JOELINJATOVO',
            'phone' => '+261331377769',
            'password' => Hash::make('driver2!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'locale' => 'fr',
        ]);
        DB::table('role_user')->insert(['approved' => 1, 'user_id' => 2, 'role_id' => 2]);
        
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Driver3 JOELINJATOVO',
            'phone' => '+261331377770',
            'password' => Hash::make('driver3!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'locale' => 'fr',
        ]);
        DB::table('role_user')->insert(['approved' => 1, 'user_id' => 3, 'role_id' => 2]);
        
        DB::table('users')->insert([
            'id' => 4,
            'name' => 'Driver4 JOELINJATOVO',
            'phone' => '+261331377771',
            'password' => Hash::make('driver4!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'locale' => 'fr',
        ]);
        DB::table('role_user')->insert(['approved' => 1, 'user_id' => 4, 'role_id' => 2]);
        
        DB::table('users')->insert([
            'id' => 5,
            'name' => 'Driver5 JOELINJATOVO',
            'phone' => '+261331377772',
            'password' => Hash::make('driver5!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'locale' => 'fr',
        ]);
        DB::table('role_user')->insert(['approved' => 1, 'user_id' => 5, 'role_id' => 2]);
    }
}
