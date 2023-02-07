<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Generator as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$vUIzDlvfpu2yOATsPYcPaOTY/zgbgwViLIWSfZxSlmRBFV.g/fmOW',
                'remember_token' => null,
            ],
        ];

        User::insert($users);

        foreach(range(1,10) as $id)
        {
            User::create([
                'name' => $faker->name,
                'email' => "user$id@user$id.com",
                'password' => bcrypt('password'),
            ]);
        }
    }
}
