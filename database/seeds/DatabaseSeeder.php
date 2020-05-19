<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;
use App\Log;
use App\Isolation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //$this->call(ProfilesTableSeeder::class);
        //$this->call(LogsTableSeeder::class);
        //$this->call(IsolationsTableSeeder::class);

        factory(User::class, 100)->create();
        factory(Profile::class, 100)->create();
        factory(Log::class, 70)->create();
        factory(Isolation::class, 17)->create();
    }
}
