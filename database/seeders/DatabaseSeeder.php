<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tbl_users')->updateOrInsert(
            ['email' => 'admin@admin.com'],
            [
                'root' => 0,
                'photo' => '/admin.default.png',
                'username' => 'admin',
                'fullname' => 'Administrator',
                'password' => Hash::make('password'),
                'phone' => '',
                'email' => 'admin@admin.com',
                'city' => '',
                'subdistrict' => '',
                'ward' => '',
                'user_type' => 'SuperAdmin',
                'status' => 'Active',
                'data' => null,
                'last_login' => null,
                'login_token' => null,
                'creationdate' => now(),
            ]
        );
    }
}
