<?php

use Illuminate\Database\Seeder;

class IsolationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('isolations')->insert([
            [
                'user_id' => '1',
                'date' => '2020-04-17',
                'stay_at_home' => '1',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-16',
                'stay_at_home' => '1',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-15',
                'stay_at_home' => '1',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-14',
                'stay_at_home' => '0',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-13',
                'stay_at_home' => '1',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-12',
                'stay_at_home' => '1',
            ],
            [
                'user_id' => '1',
                'date' => '2020-04-11',
                'stay_at_home' => '0',
            ],

        ]);
    }
}
