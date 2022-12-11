<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserLocations;

class UserLocationSeeder extends Seeder
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
            UserLocations::create([
                'user_id' => mt_rand(1, 10),
                'latitude' => (mt_rand(50, 500)/10),
                'longitude' => (mt_rand(50, 500)/10)
            ]);
        }

    }
}