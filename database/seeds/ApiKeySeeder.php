<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_keys')->insert([
            'scopes' => 'scopes',
            'name' => 'App Dev',
            'version' => date('Y-m-d'),
            'user_agent' => null,
            'expires_at' => now()->addDays(5*365 +1 ), // 5 ans
            'user_id' => 1,
        ]);
    }
}
