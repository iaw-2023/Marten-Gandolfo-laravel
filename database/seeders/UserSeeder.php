<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Matias',
                'username' => 'mati',
                'email' => 'matiasgandolfo17@gmail.com',
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'Juan',
                'username' => 'juan',
                'email' => 'juanmarten99@gmail.com',
                'password' => bcrypt('4321')
            ],
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@iaw.com',
                'password' => bcrypt('admin123')
            ]
        ]);

        $adminRole = Role::where('name', 'Admin')->first();
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        User::where('username', 'admin')->first()->roles()->attach($superAdminRole);
        User::where('username', 'admin')->first()->roles()->attach($adminRole);
        User::where('username', 'juan')->first()->roles()->attach($adminRole);
        User::where('username', 'mati')->first()->roles()->attach($adminRole);
    }
}
