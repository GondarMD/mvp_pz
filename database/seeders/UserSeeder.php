<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    use HasRoles;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'a@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('admin');

        User::create([
            'name' => 'Authenticated User',
            'email' => 'auth@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('authenticated');

        User::create([
            'name' => 'Guest User',
            'email' => 'guest@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('guest');

        User::create([
            'name' => 'Unverified User',
            'email' => 'unverified@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => null,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('guest');

        User::create([
            'name' => 'Super Admin',
            'email' => 'super@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('super-admin');

        User::create([
            'name' => 'Product Manager',
            'email' => 'pm@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('product_manager');

        User::create([
            'name' => 'Order Manager',
            'email' => 'order@t.com',
            'password' => bcrypt('123!!'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('order_manager');

    }
}
