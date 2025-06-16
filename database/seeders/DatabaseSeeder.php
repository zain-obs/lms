<?php

namespace Database\Seeders;

use App\Models\TabUser;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teacher_permissions = ['view class', 'view teachers', 'view students', 'create class', 'create book', 'create message',
                                'delete class', 'edit class' ,'delete book', 'delete message', 'remove students'];

        $student_permissions = ['view class', 'view students' , 'view teachers'];

        $parent_permissions = ['view class', 'view teachers'];

        $all_permissions = ['view dashboard', 'view teachers', 'view students', 'view parents', 'view class', 'view users',
                            'create class', 'create book', 'create message',
                            'delete class', 'delete book', 'delete message','edit class',
                            'remove students'];

        foreach ($all_permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin_permissions = Permission::pluck('name')->toArray();

        $admin_role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin_role->syncPermissions($admin_permissions);

        $student_role = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $student_role->syncPermissions($student_permissions);

        $parent_role = Role::firstOrCreate(['name' => 'parent', 'guard_name' => 'web']);
        $parent_role->syncPermissions($parent_permissions);

        $teacher_role = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher_role->syncPermissions($teacher_permissions);

        $user = User::factory()->create([
            'name' => 'Zain',
            'email' => 'zainaliobs@gmail.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $user->assignRole($admin_role);

        $dummyUsers = User::factory(10)->create();

        DB::table('tabs')->insert([
            [
                'id' => 1,
                'name' => 'Dashboard',
            ],
            [
                'id' => 2,
                'name' => 'Teachers',
            ],
            [
                'id' => 3,
                'name' => 'Students',
            ],
            [
                'id' => 4,
                'name' => 'Parents',
            ],
            [
                'id' => 5,
                'name' => 'Classes',
            ],
            [
                'id' => 6,
                'name' => 'Users',
            ],
            [
                'id' => 7,
                'name' => 'Roles and Permissions',
            ],
        ]);

        $tabs = Tab::all();
        foreach ($tabs as $index => $tab) {
            $tab_user = new TabUser();
            $tab_user->user_id = $user->id;
            $tab_user->tab_id = $tab->id;
            $tab_user->priority = $index + 1;
            $tab_user->save();
        }
        foreach ($dummyUsers as $index => $dummyUser) {
            foreach ($tabs as $index => $tab) {
                $tab_user = new TabUser();
                $tab_user->user_id = $dummyUser->id;
                $tab_user->tab_id = $tab->id;
                $tab_user->priority = $index + 1;
                $tab_user->save();
            }
        }
    }
}
