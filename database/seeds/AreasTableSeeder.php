<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          ['area_name'=>'Area 1','created_at'=>now()],
          ['area_name'=>'Area 2','created_at'=>now()],
          ['area_name'=>'Area 3','created_at'=>now()],
        ];
        \Illuminate\Support\Facades\DB::table('areas')->insert($data);
    }
}
