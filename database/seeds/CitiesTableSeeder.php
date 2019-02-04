<?php

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
        \App\Models\Province::insert($data['province']);
        \App\Models\County::insert($data['county']);
        \App\Models\City::insert($data['city']);
    }
}
