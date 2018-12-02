<?php

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeed extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(Task::class, 10)->state('done')->create(['creator' => 1]);
    factory(Task::class, 10)->create(['creator' => 1]);
  }
}
