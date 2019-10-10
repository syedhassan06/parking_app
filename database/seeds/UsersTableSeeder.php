<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Administrator',
                'email' => 'admin@mail.com',
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'phone' => '703-923-6658',
                'address' => '4157  Forest Drive',
                'role'=>'admin',
                'created_at'=>now()
            ],
            [
                'name' => 'Tariq Ali',
                'email' => 'tariq@mail.com',
                'username' => 'tariq.ali',
                'password' => bcrypt('123456'),
                'phone' => '712-203-7619',
                'address' => '2199  Nutters Barn Lane',
                'role'=>'customer',
                'created_at'=>now()
            ]
        ];
        \Illuminate\Support\Facades\DB::table('users')->insert($data);
    }
}
