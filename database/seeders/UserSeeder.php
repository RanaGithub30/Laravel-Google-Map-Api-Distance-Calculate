<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
        //

        for($i=0; $i<10; $i++){
            User::create([
                'name' => Str::random(20),
                'email' => Str::random(10)."@gmail.com",
                'password' => bcrypt("password")
            ]);
        }
    }
}