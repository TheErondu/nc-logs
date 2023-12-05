<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage stores']);
        Permission::create(['name' => 'manage roles']);
    }
}
