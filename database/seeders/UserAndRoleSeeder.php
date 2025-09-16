<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserAndRoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin@123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@test.com'],
            [
                'name' => 'Customer',
                'password' => Hash::make('customer@123'),
            ]
        );
        $customer->assignRole($customerRole);
    }
}
