<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Employee\Entities\Employee;

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
        $super_admin = User::with('relatedEmployee')->updateOrCreate(
            ['email' => 'suadmin@auxyl-web.test'],
            [
                'name' => 'Super Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('Password!'),
            ]
        );
        $super_admin->syncRoles('super-admin');
        $employee = new Employee([
            'employee_name' => $super_admin->name,
            'employee_position' => 'Super Admin',
            'employee_phone' => '0812345678',
            'employee_address' => null
        ]);
        $super_admin->relatedEmployee()->save($employee);

        // Create Admin User for Employee
        $admin = User::with('relatedEmployee')->updateOrCreate(
            ['email' => 'admin@auxyl-web.test'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('Password!'),
            ]);
        $admin->syncRoles('admin');
        $employee = new Employee([
            'employee_name' => $admin->name,
            'employee_position' => 'Admin',
            'employee_phone' => '081234567890',
            'employee_address' => null
        ]);
        $admin->relatedEmployee()->save($employee);

        // Create Customer User
        $customer = User::with('relatedEmployee')->updateOrCreate(
            ['email' => 'customer@auxyl-web.test'],
            [
                'name' => 'Customer',
                'email_verified_at' => now(),
                'password' => bcrypt('Password!'),
            ]);
        $customer->syncRoles('customer');
    }
}
