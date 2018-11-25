<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;
use App\Models\Task;
use App\Http\Requests\Task\UpdateRequest;

class TasksController extends Controller
{
    public function create(CreateRequest $request)
    {
        return response()->json(Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ? : null,
            'creator' => $request->user()->id
        ]));
    }

    public function update(Task $task, UpdateRequest $request)
    {
        $user = auth()->user();
        if ($user->isProductOwner()) {
            $task->name = $request->name ? : $task->name;
            $task->description = $request->description ? : $task->description;
            $task->status = $request->status ? : $task->status;
            $task->executor = $request->executor ? : $task->executor;
            $task->sprint = $request->sprint ? : $task->sprin;
            $task->save();

            return response()->json([
                'status' => 200,
                'data' => $task
            ]);
        }

        if ($user->isScrumMaster()) {
            $task->executor = $request->executor ? : $task->executor;
            $task->sprint = $request->sprint ? : $task->sprin;
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
