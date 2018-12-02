<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sprint\CreateRequest;
use App\Models\Sprint;
use App\Http\Requests\Sprint\UpdateRequest;
use App\Exceptions\BaseException;

class SprintsController extends Controller
{
  public function lists(Request $request)
  {
    if ($request->has('status')) {
      if ($request->status === Sprint::STARTED) {
        return Sprint::where('status', Sprint::STARTED)->first();
      }

      return Sprint::where('status', $request->status)->get();
    }

    return Sprint::paginate(10);
  }

  public function create(CreateRequest $request)
  {
    $sprint = new Sprint();
    $sprint->name = $request->name;
    $sprint->date_start = $request->date_start ? : null;
    $sprint->date_finish = $request->date_start ? : null;
    $sprint->status = Sprint::CREATED;
    $sprint->save();

    return response()->json([
      'status' => 200,
      'data' => $sprint
    ]);
  }

  public function update(Sprint $sprint, UpdateRequest $request)
  {
    if ($request->status === Sprint::STARTED) {
      if (!$sprint->date_start && !$request->date_start) {
        $sprint->date_start = now();
      } else {
        $sprint->date_start = $request->date_start;
      }
      $sprint->status = Sprint::STARTED;
      $sprint->date_finish = $request->date_finish;
      $sprint->save();

      return response()->json([
        'status' => 200,
        'data' => $sprint
      ]);
    }

    if ($request->status === Sprint::FINISHED) {
      if ($sprint->date_start) {
        $sprint->status === Sprint::FINISHED;
        $sprint->save();

        return response()->json([
          'status' => 200,
          'data' => $sprint
        ]);
      }

      throw new BaseException('Не удалось закончить не начатый спринт', 422, 'SprintDateStartNotDefined');
    }

    throw new BaseException('Не удалось изменить данные спринта', 422, 'SprintUpdateFailed');
  }
}
