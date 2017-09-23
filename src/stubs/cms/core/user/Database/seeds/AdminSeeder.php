<?php
namespace cms\core\user\Database\seeds;
use Illuminate\Database\Seeder;
use DB;
use Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user groups
        DB::table('user_groups')->insert([
            [
                'name' => 'Super Admin',
                'status' => 1
            ],
            [
                'name' => 'Register',
                'status' => 1
            ]
        ]);

        //create admin user
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'status' => 1
            ]
        ]);
        //map admin user to group
        DB::table('user_group_map')->insert([
            [
                'user_id' => 1,
                'group_id' => 1,
            ]
        ]);
    }
}
