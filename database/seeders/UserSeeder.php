<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo(Permission::all());

        // $role = Role::create(['name' => 'admin']);
        // $role->givePermissionTo([Permission::all()]);
 
        // $role = Role::create(['name' => 'moderator']);
        // $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(Permission::all());

     
        $user1 = new User;
        $user1->name = 'superadmin';
        $user1->email = 'superadmin@gmail.com';
        $user1->password = Hash::make('admin123');
        $user1->save();
        $user1->assignRole('superadmin');
        
        echo "superadmin created...\n";

        // $user2 = new User;
        // $user2->name = 'alyssa';
        // $user2->email = 'alyssa.richmond@harrisoncareers.com';
        // $user2->password = Hash::make('admin123');
        // $user2->save();
        // $user2->assignRole('admin');

        // echo "admin Alyssa created...\n";

        
        // $user3 = new User;
        // $user3->name = 'peter';
        // $user3->email = 'peter.harrison@harrisoncareers.com';
        // $user3->password = Hash::make('test1234');
        // $user3->save();
        // $user3->assignRole('moderator');

        // echo "moderator peter created...\n";

        $user4 = new User;
        $user4->name = 'user';
        $user4->email = 'user@gmail.com';
        $user4->password = Hash::make('test1234');
        $user4->save();
        $user4->assignRole('user');

       echo "user created\n";
    }
}
