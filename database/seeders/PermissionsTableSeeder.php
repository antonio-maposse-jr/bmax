<?php

namespace Database\Seeders;

use Backpack\PermissionManager\app\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // create permission for each combination of table.level
        collect([ // tables
            'users',
            'roles',
            'permissions',
            'customer_categories',
            'customers',
            'categories',
            'subcategories',
            'products',
            'processes',
            'stage_cashiers',
            'stage_authorisations',
            'stage_productions',
            'stage_credit_controls',
            'stage_dispatches',
            'return_stages',
            'production_tasks',
            'reason_declines',
            'activity_log',
            'logs',
            'reports',
        ])
            ->crossJoin([ // levels
                'list',
                'show',
                'create',
                'update',
                'delete',
            ])
            ->each(
                fn (array $item) => Permission::firstOrCreate([
                    'name' => implode('_', $item),
                ])
                    ->save()
            )
            //
        ;
        User::first()
            ->givePermissionTo(['users_list'])
            ->givePermissionTo(['users_show'])
            ->givePermissionTo(['users_create'])
            ->givePermissionTo(['users_update'])
            ->givePermissionTo(['users_delete'])
            ->givePermissionTo(['roles_list'])
            ->givePermissionTo(['roles_show'])
            ->givePermissionTo(['roles_create'])
            ->givePermissionTo(['roles_update'])
            ->givePermissionTo(['roles_delete'])
            ->givePermissionTo(['permissions_list'])
            ->givePermissionTo(['permissions_show'])
            ->givePermissionTo(['permissions_create'])
            ->givePermissionTo(['permissions_update'])
            ->givePermissionTo(['permissions_delete']);
    }
}
