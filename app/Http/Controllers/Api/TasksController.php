<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;

class TasksController extends Controller
{   
    public function create(CreateRequest $request) {
        return response()->json(Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ?: null,
            'creator' => $request->user()->id
        ]));
    }
}
