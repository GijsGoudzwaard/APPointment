<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'gijs.goudzwaard@gmail.com')->get();

        if ($user->isEmpty()) {
            DB::table('users')->insert([
                'firstname' => 'GLaDOS',
                'surname' => '',
                'email' => 'glados@aperturelabaratories.com',
                'phonenumber' => '-',
                'password' => bcrypt('changeme'),
                'role' => User::role('admin'),
                'active' => 1,
                'company_id' => 1
            ]);
        }
    }
}
