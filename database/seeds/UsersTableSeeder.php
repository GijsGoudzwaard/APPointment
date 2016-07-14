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
                'firstname' => 'Gijs',
                'surname' => 'Goudzwaard',
                'email' => 'gijs.goudzwaard@gmail.com',
                'phonenumber' => '0642311100',
                'password' => bcrypt('changeme'),
                'role' => User::role('admin'),
                'active' => 1
            ]);
        }
    }
}
