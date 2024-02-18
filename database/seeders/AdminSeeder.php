<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::first();

        if (!$admin) {
            $admin = new Admin();
            $admin->id = 1;
            $admin->name = 'Admin';
            $admin->username = 'admin';
            $admin->email = 'admin@mail.com';
            $admin->password = Hash::make('123456');
            $admin->save();

            $admin->roles()->detach();
            $admin->assignRole(['superadmin']);


            $vendor = new Admin();
            $admin->id = 2;
            $vendor->name = 'Vendor';
            $vendor->username = 'vendor';
            $vendor->commission = 28;
            $vendor->email = 'vendor@mail.com';
            $vendor->password = Hash::make('123456');
            $vendor->save();

            $vendor->roles()->detach();
            $vendor->assignRole(['vendor']);
        }
    }
}
