<?php

use App\Models\City;
use App\Models\County;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(database_path('seeds/cities.json')), true);
        Province::insert($data['province']);
        $counties = array_chunk($data['county'], 400);
        foreach ($counties as $county) {
            County::insert($county);
        }
        $cities = array_chunk($data['city'], 400);
        foreach ($cities as $city) {
            City::insert($city);
        }
    }
}
