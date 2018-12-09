<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;
use App\Models\Task;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Requests\Tasks\ListsTasksRequest;
use App\Models\Sprint;

class TasksController extends Controller
{
    public function lists(ListsTasksRequest $request)
    {
        $task = Task::with('executor');
        $sprint = Sprint::current()->first();
        if ($request->has('sprint')) {
            $task = $task->where('sprint', $request->sprint);
        } else {
            $task = $task->where('status', '!=', Task::DONE);
            if ($sprint) {
                $task->orWhere('sprint', $sprint->id);
            }
        }

        return response()->json([
            'status' => 200,
            'data' => $task->get()
        ]);
    }

  // public function get(Task $task)
  // {


  //   return response()->json([
  //     'status' => 200,
  //     'data' => $task
  //   ])
  // }

    public function create(CreateRequest $request)
    {
        $task = Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ? : null,
            'executor' => $request->input('executor') ? : null,
            'creator' => $request->user()->id
        ]);

        $task->load('executor');
        return response()->json([
            'status' => 201,
            'data' => $task
        ]);
    }

    public function update(Task $task, UpdateRequest $request)
    {
        $user = auth()->user();

        if ($user->isProductOwner()) {
            $task->name = $request->name ? : $task->name;
            $task->description = $request->description ? : $task->description;
            $task->status = $request->has('status') ? $request->status : $task->status;
            $task->executor = $request->executor ? : $task->executor;
            $task->sprint = $request->has('sprint') ? $request->sprint : $task->sprint;
            $task->save();

            return response()->json([
                'status' => 200,
                'data' => $task
            ]);
        }

        if ($user->isScrumMaster()) {
            $task->executor = $request->executor ? : $task->executor;
            $task->sprint = $request->sprint ? : $task->sprint;
            $task->status = $request->status;
            $task->save();

            return response()->json([
                'status' => 200,
                'data' => $task
            ]);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'status' => 200,
            'data' => $task
        ]);
    }
}
