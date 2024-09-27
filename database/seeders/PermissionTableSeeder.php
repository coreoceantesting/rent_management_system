<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'dashboard.view',
                'group' => 'dashboard',
            ],
            [
                'id' => 2,
                'name' => 'users.view',
                'group' => 'users',
            ],
            [
                'id' => 3,
                'name' => 'users.create',
                'group' => 'users',
            ],
            [
                'id' => 4,
                'name' => 'users.edit',
                'group' => 'users',
            ],
            [
                'id' => 5,
                'name' => 'users.delete',
                'group' => 'users',
            ],
            [
                'id' => 6,
                'name' => 'users.toggle_status',
                'group' => 'users',
            ],
            [
                'id' => 7,
                'name' => 'users.change_password',
                'group' => 'users',
            ],
            [
                'id' => 8,
                'name' => 'roles.view',
                'group' => 'roles',
            ],
            [
                'id' => 9,
                'name' => 'roles.create',
                'group' => 'roles',
            ],
            [
                'id' => 10,
                'name' => 'roles.edit',
                'group' => 'roles',
            ],
            [
                'id' => 11,
                'name' => 'roles.delete',
                'group' => 'roles',
            ],
            [
                'id' => 12,
                'name' => 'roles.assign',
                'group' => 'roles',
            ],
            [
                'id' => 13,
                'name' => 'wards.view',
                'group' => 'wards',
            ],
            [
                'id' => 14,
                'name' => 'wards.create',
                'group' => 'wards',
            ],
            [
                'id' => 15,
                'name' => 'wards.edit',
                'group' => 'wards',
            ],
            [
                'id' => 16,
                'name' => 'wards.delete',
                'group' => 'wards',
            ],
            [
                'id' => 17,
                'name' => 'SchemeDetails.list',
                'group' => 'SchemeDetails',
            ],
            [
                'id' => 18,
                'name' => 'SchemeDetails.create',
                'group' => 'SchemeDetails',
            ],
            [
                'id' => 19,
                'name' => 'SchemeDetails.edit',
                'group' => 'SchemeDetails',
            ],
            [
                'id' => 20,
                'name' => 'SchemeDetails.view',
                'group' => 'SchemeDetails',
            ],
            [
                'id' => 21,
                'name' => 'SchemeDetails.delete',
                'group' => 'SchemeDetails',
            ],
            [
                'id' => 22,
                'name' => 'TenantsDetails.list',
                'group' => 'TenantsDetails',
            ],
            [
                'id' => 23,
                'name' => 'TenantsDetails.create',
                'group' => 'TenantsDetails',
            ],
            [
                'id' => 24,
                'name' => 'TenantsDetails.view',
                'group' => 'TenantsDetails',
            ],
            [
                'id' => 25,
                'name' => 'RentDetails.add',
                'group' => 'RentDetails',
            ],
            [
                'id' => 26,
                'name' => 'RentDetails.view',
                'group' => 'RentDetails',
            ],
            [
                'id' => 27,
                'name' => 'TenantsDetails.edit',
                'group' => 'TenantsDetails',
            ],
            [
                'id' => 28,
                'name' => 'TenantsDetails.delete',
                'group' => 'TenantsDetails',
            ],
            [
                'id' => 29,
                'name' => 'HOD.rentApporval',
                'group' => 'HOD',
            ],
            [
                'id' => 30,
                'name' => 'finance.approvalSection',
                'group' => 'Finance',
            ],

            [
                'id' => 31,
                'name' => 'finance.finalApprovalList',
                'group' => 'Finance',
            ],
        ];

        foreach ($permissions as $permission)
        {
            Permission::updateOrCreate([
                'id' => $permission['id']
            ], [
                'id' => $permission['id'],
                'name' => $permission['name'],
                'group' => $permission['group']
            ]);
        }
    }
}
