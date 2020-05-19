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
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'user01',
                'email' => 'user01@example.com',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => '2',
                'name' => 'user02',
                'email' => 'user02@example.com',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => '3',
                'name' => 'user03',
                'email' => 'user03@example.com',
                'password' => bcrypt('123456'),
            ],
        ]);
    }
}
