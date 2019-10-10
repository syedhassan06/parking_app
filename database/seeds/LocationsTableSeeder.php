<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['location_name'=>'Dolmen Mall','created_at'=>now()],
            ['location_name'=>'Emerald Mall','created_at'=>now()],
            ['location_name'=>'Ocean Mall','created_at'=>now()],
            ['location_name'=>'Atrium Mall','created_at'=>now()],
            ['location_name'=>'Park Towers','created_at'=>now()]
        ];
        \Illuminate\Support\Facades\DB::table('locations')->insert($data);
    }
}
