<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CityDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' =>"كفر صقر",'governorate_id'=>5],
            ['name' =>"اولاد صقر",'governorate_id'=>5],
            ['name' =>"ابوكبير",'governorate_id'=>5],
            ['name' =>"الزقازيق",'governorate_id'=>5],
            ['name' =>"بلبيس",'governorate_id'=>5],
            ['name' =>"العاشر من رمضان",'governorate_id'=>5],
            ['name' =>"ههيا",'governorate_id'=>5],
         ];
         City::insert($data);
    }
}
