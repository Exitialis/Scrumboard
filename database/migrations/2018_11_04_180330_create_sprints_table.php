<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Sprint;

class CreateSprintsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sprints', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->unique();

      $table->date('date_start')->nullable();
      $table->date('date_finish')->nullable();
      $table->unsignedTinyInteger('status')->default(Sprint::CREATED);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('sprints');
  }
}
