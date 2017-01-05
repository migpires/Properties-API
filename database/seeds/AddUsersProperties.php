<?php

use Illuminate\Database\Seeder;

class AddUsersProperties extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 2; $i++) {

            $user = App\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'api_token' => str_random(60),
            ]);

            for($j = 0; $j < 3; $j++)
                App\Property::create([
                    'address' => $faker->address,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'user_id' => $user->id,
                ]);
        }
    }
}
