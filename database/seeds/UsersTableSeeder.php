<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Models\Group;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->seedUser([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => 'secret',
        ]);

        $user->groups()->sync(
            Group::all()->pluck('id')->toArray()
        );
    }

    private function seedUser(array $data)
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Crypt::encrypt($data['password']),
        ]);

        $user->save();

        return $user;
    }
}
