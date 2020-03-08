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
            'active' => 1,
            'locale' => 'fr',
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
    }
}
