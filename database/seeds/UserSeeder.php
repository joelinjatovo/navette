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
            'name' => 'JOELINJATOVO Haja',
            'phone' => '+261331377768',
            'password' => Hash::make('admin!'),
            'phone_verified_at' => now(),
            'created_at' => now(),
            'active' => 1,
            'locale' => 'fr',
        ]);
    }
}
