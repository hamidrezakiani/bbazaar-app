<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $existingSuperAdmin = Role::where('name', 'superadmin')->first();

        if($existingSuperAdmin){
            return;
        }


        //Create roles
        $roleSuperAdmin = Role::create(['guard_name' => 'admin', 'name' => 'superadmin']);
        $roleVendor = Role::create(['guard_name' => 'admin', 'name' => 'vendor']);

        // Permissions list
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions'=> [
                    'dashboard.view',
                ]
            ],
            [
                'group_name' => 'category',
                'permissions'=> [
                    'category.view',
                    'category.create',
                    'category.edit',
                    'category.delete',

                ]
            ],
            [
                'group_name' => 'subcategory',
                'permissions'=> [
                    'subcategory.view',
                    'subcategory.create',
                    'subcategory.edit',
                    'subcategory.delete'
                ]
            ],
            [
                'group_name' => 'brand',
                'permissions'=> [
                    'brand.view',
                    'brand.create',
                    'brand.edit',
                    'brand.delete'
                ]
            ],
            [
                'group_name' => 'attribute',
                'permissions'=> [
                    'attribute.view',
                    'attribute.create',
                    'attribute.edit',
                    'attribute.delete'
                ]
            ],




            [
                'group_name' => 'tax_rule',
                'permissions'=> [
                    'tax_rule.view',
                    'tax_rule.create',
                    'tax_rule.edit',
                    'tax_rule.delete'
                ]
            ],
            [
                'group_name' => 'shipping_rule',
                'permissions'=> [
                    'shipping_rule.view',
                    'shipping_rule.create',
                    'shipping_rule.edit',
                    'shipping_rule.delete'
                ]
            ],
            [
                'group_name' => 'product_collection',
                'permissions'=> [
                    'product_collection.view',
                    'product_collection.create',
                    'product_collection.edit',
                    'product_collection.delete'
                ]
            ],
            [
                'group_name' => 'bundle_deal',
                'permissions'=> [
                    'bundle_deal.view',
                    'bundle_deal.create',
                    'bundle_deal.edit',
                    'bundle_deal.delete'
                ]
            ],
            [
                'group_name' => 'voucher',
                'permissions'=> [
                    'voucher.view',
                    'voucher.create',
                    'voucher.edit',
                    'voucher.delete'
                ]
            ],
            [
                'group_name' => 'product',
                'permissions'=> [
                    'product.view',
                    'product.create',
                    'product.edit',
                    'product.delete'
                ]
            ],
            [
                'group_name' => 'flash_sale',
                'permissions'=> [
                    'flash_sale.view',
                    'flash_sale.create',
                    'flash_sale.edit',
                    'flash_sale.delete'
                ]
            ],
            [
                'group_name' => 'order',
                'permissions'=> [
                    'order.view',
                    'order.delete',
                    'order.edit'
                ]
            ],
            [
                'group_name' => 'rating_review',
                'permissions'=> [
                    'rating_review.view',
                    'rating_review.delete'
                ]
            ],
            [
                'group_name' => 'user',
                'permissions'=> [
                    'user.view',
                    'user.create',
                    'user.edit',
                    'user.delete'
                ]
            ],
            [
                'group_name' => 'subscriber',
                'permissions'=> [
                    'subscriber.view',
                    'subscriber.delete'
                ]
            ],
            [
                'group_name' => 'subscription_email_format',
                'permissions'=> [
                    'subscription_email_format.view',
                    'subscription_email_format.create',
                    'subscription_email_format.edit',
                    'subscription_email_format.delete'
                ]
            ],
            [
                'group_name' => 'role',
                'permissions'=> [
                    'role.view',
                    'role.create',
                    'role.edit',
                    'role.delete'
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions'=> [
                    'admin.view',
                    'admin.create',
                    'admin.edit',
                    'admin.delete',

                ]
            ],
            [
                'group_name' => 'page',
                'permissions'=> [
                    'page.view',
                    'page.create',
                    'page.edit',
                    'page.delete'
                ]
            ],
            [
                'group_name' => 'home_slider',
                'permissions'=> [
                    'home_slider.view',
                    'home_slider.create',
                    'home_slider.edit',
                    'home_slider.delete'
                ]
            ],
            [
                'group_name' => 'banner',
                'permissions'=> [
                    'banner.view',
                    'banner.create',
                    'banner.edit',
                    'banner.delete'
                ]
            ],
            [
                'group_name' => 'site_setting',
                'permissions'=> [
                    'site_setting.view',
                    'site_setting.edit',
                ]
            ],
            [
                'group_name' => 'footer_link',
                'permissions'=> [
                    'footer_link.view',
                    'footer_link.create',
                    'footer_link.edit',
                    'footer_link.delete'
                ]
            ],
            [
                'group_name' => 'setting',
                'permissions'=> [
                    'setting.view',
                    'setting.edit'
                ]
            ],[
                'group_name' => 'profile',
                'permissions'=> [
                    'profile.view',
                    'profile.edit'
                ]
            ],
            [
                'group_name' => 'message',
                'permissions'=> [
                    'message.view',
                    'message.delete',
                ]
            ],
            [
                'group_name' => 'withdrawal_account',
                'permissions'=> [
                    'withdrawal_account.view',
                    'withdrawal_account.create',
                    'withdrawal_account.edit',
                    'withdrawal_account.delete'
                ]
            ],
            [
                'group_name' => 'store',
                'permissions'=> [
                    'store.view',
                    'store.create',
                    'store.edit',
                    'store.delete'
                ]
            ],
            [
                'group_name' => 'withdrawal_request',
                'permissions'=> [
                    'withdrawal_request.view',
                    'withdrawal_request.create',
                    'withdrawal_request.approve',
                    'withdrawal_request.cancel',
                    'withdrawal_request.delete'
                ]
            ]
        ];

        // Assign permissions
        for($i = 0; $i < count($permissions); $i++){
            $groupName = $permissions[$i]['group_name'];
            for($j = 0; $j < count($permissions[$i]['permissions']); $j++){
                $permission = Permission::create([
                    'group_name' => $groupName,
                    'guard_name' => 'admin',
                    'name' => $permissions[$i]['permissions'][$j]
                ]);

                // Super admin has all permission except create withdrawal request
                if($permissions[$i]['permissions'][$j] !== 'withdrawal_request.create')
                {
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }

                // Vendor has all permissions except these permissions
                if(
                    $groupName != 'role' &&
                    $groupName != 'admin' &&
                    $groupName != 'setting' &&
                    $groupName != 'footer_link' &&
                    $groupName != 'home_slider' &&
                    $groupName != 'site_setting' &&
                    $groupName != 'page' &&
                    $groupName != 'banner' &&
                    $groupName != 'user' &&
                    $groupName != 'subscription_email_format' &&
                    $groupName != 'subscriber' &&
                    $groupName != 'flash_sale' &&
                    $groupName != 'product_collection' &&
                    $groupName != 'shipping_rule' &&
                    $groupName != 'message' &&
                    $groupName != 'tax_rule' &&
                    $groupName != 'voucher' &&

                    $permissions[$i]['permissions'][$j] !== 'store.delete' &&
                    $permissions[$i]['permissions'][$j] !== 'store.create' &&

                    $permissions[$i]['permissions'][$j] !== 'withdrawal_request.delete' &&
                    $permissions[$i]['permissions'][$j] !== 'withdrawal_request.approve'
                ){
                    $roleVendor->givePermissionTo($permission);
                    $permission->assignRole($roleVendor);
                }
            }
        }

    }
}
