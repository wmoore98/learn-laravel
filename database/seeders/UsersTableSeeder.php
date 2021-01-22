<?php

namespace Database\Seeders;

use App\Models\User;
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
        $count = (int) $this->command->ask('How many users would you like?', 20);
        $this->command->info("Making $count users...");
        User::factory()->myUser()->create();
        User::factory($count)->create();
    }
}
