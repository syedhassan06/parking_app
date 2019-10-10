<?php

use Illuminate\Database\Seeder;

class ParkingSlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['display_name'=>'Slot#1','slot_number'=>1,'created_at'=>now()],
            ['display_name'=>'Slot#2','slot_number'=>2,'created_at'=>now()],
            ['display_name'=>'Slot#3','slot_number'=>3,'created_at'=>now()],
            ['display_name'=>'Slot#4','slot_number'=>4,'created_at'=>now()],
            ['display_name'=>'Slot#5','slot_number'=>5,'created_at'=>now()],
            ['display_name'=>'Slot#6','slot_number'=>6,'created_at'=>now()],
            ['display_name'=>'Slot#7','slot_number'=>7,'created_at'=>now()],
            ['display_name'=>'Slot#8','slot_number'=>8,'created_at'=>now()],
            ['display_name'=>'Slot#9','slot_number'=>9,'created_at'=>now()],
            ['display_name'=>'Slot#10','slot_number'=>10,'created_at'=>now()],
            ['display_name'=>'Slot#11','slot_number'=>11,'created_at'=>now()],
            ['display_name'=>'Slot#12','slot_number'=>12,'created_at'=>now()]
        ];
        \Illuminate\Support\Facades\DB::table('parking_slots')->insert($data);
    }
}
