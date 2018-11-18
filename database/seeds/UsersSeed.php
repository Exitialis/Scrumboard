<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->state('product_owner')->create();
        factory(User::class)->state('scrum_master')->create();
        factory(User::class, 5)->create();
    }
}
