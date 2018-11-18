<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Task;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('creator')->references('id')->on('users');
            $table->foreign('executor')->references('id')->on('users');
            $table->foreign('sprint')->references('id')->on('sprints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_creator_foreign');
            $table->dropForeign('tasks_executor_foreign');
            $table->dropForeign('tasks_sprint_foreign');
        });
    }
}
