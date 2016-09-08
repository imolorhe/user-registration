<?php

use App\User;
use Carbon\Carbon;
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
        $user = User::create([
          'name' => 'admin',
          'email' => 'samuelimolo4real@gmail.com',
          'password' => bcrypt('secret'),
          'first_name' => 'Samuel',
          'last_name' => 'Imolorhe',
          'phone_number' => '08038651505',
          'birthday' => Carbon::parse('18 September 1992'),
          'confirmation_code' => str_slug(str_random(20)),
          'confirmed' => false,
        ]);

        $user->admin = true;
        $user->confirmed = true;

        $user->save();
    }
}
