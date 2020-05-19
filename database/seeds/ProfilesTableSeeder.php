<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'id' => '1',
                'user_id' => '1',
                'country_id' => '392',
                'prefecture' => 'Okayama',
                'postal_code' => '7150021',
                'origin_lat' => '34.593738',
                'origin_lng' => '133.465151',
                'cohabitant' => '2',
                'contact_weekday' => '40',
                'contact_weekend' => '15',
            ],
            [
                'id' => '2',
                'user_id' => '2',
                'country_id' => '392',
                'prefecture' => 'Okayama',
                'postal_code' => '1',
                'origin_lat' => '34.492076',
                'origin_lng' => '133.361350',
                'cohabitant' => '2',
                'contact_weekday' => '10',
                'contact_weekend' => '20',
            ],
            [
                'id' => '3',
                'user_id' => '3',
                'country_id' => '392',
                'prefecture' => 'Okayama',
                'postal_code' => '1',
                'origin_lat' => '34.595329',
                'origin_lng' => '133.463293',
                'cohabitant' => '2',
                'contact_weekday' => '15',
                'contact_weekend' => '30',
            ],

        ]);
    }
}
