<?php

namespace Database\Seeders;

use App\Models\BloodType;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodTypeDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' =>"A+"],
            ['name' =>"A-"],
            ['name' =>"B+"],
            ['name' =>"B-"],
            ['name' =>"AB+"],
            ['name' =>"AB-"],
            ['name' =>"o-"],
            ['name' =>"o+"],

         ];
         BloodType::insert($data);
    }
}
