<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Super Admin User for Owner
        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'suadmin@auxyl-web.test',
            'email_verified_at' => now(),
            'password' => bcrypt('Password!'),
        ]);
        $super_admin->assignRole('super-admin');

        // Create Admin User for Employee
        $super_admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@auxyl-web.test',
            'email_verified_at' => now(),
            'password' => bcrypt('Password!'),
        ]);
        $super_admin->assignRole('admin');

        // Create Customer User
        $super_admin = User::create([
            'name' => 'Customer',
            'email' => 'customer@auxyl-web.test',
            'email_verified_at' => now(),
            'password' => bcrypt('Password!'),
        ]);
        $super_admin->assignRole('customer');
    }
}
