<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'view role','create role','edit role','delete role',
            'view permission','create permission','edit permission','delete permission',
            'view user','create user','edit user','delete user',
            'view country','create country','edit country','delete country',
            'view source','create source','edit source','delete source',
            'view status','create status','edit status','delete status',
            'view setting','create setting','edit setting','delete setting',
            'view leads','create leads','edit leads','delete leads',
            'view customers','create customers','edit customers','delete customers',
            'view projects','create projects','edit projects','delete projects',
            'view expenses','create expenses','edit expenses','delete expenses',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('123456'),
                'type' => 'admin',
            ]
        );

        $admin->assignRole('super-admin');
    }
}
