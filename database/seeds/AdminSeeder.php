<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            [
                'id' => '1',
                'account' => 'teacher1',
                'password' => Hash::make('a12345'),
                'access' => '0',
            ],[
                'id' => '2',
                'account' => 'teacher2',
                'password' => Hash::make('a12345'),
                'access' => '0',
            ],[
                'id' => '3',
                'account' => 'teacher3',
                'password' => Hash::make('a12345'),
                'access' => '0',
            ],[
                'id' => '4',
                'account' => 'admin1',
                'password' => Hash::make('b67890'),
                'access' => '1',
            ],[
                'id' => '5',
                'account' => 'admin2',
                'password' => Hash::make('b67890'),
                'access' => '1',
            ],[
                'id' => '6',
                'account' => 'admin3',
                'password' => Hash::make('b67890'),
                'access' => '1',
            ]
        ]);
    }

}
