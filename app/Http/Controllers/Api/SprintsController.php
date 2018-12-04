<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sprint\CreateRequest;
use App\Models\Sprint;
use App\Http\Requests\Sprint\UpdateRequest;
use App\Exceptions\BaseException;
use App\Exceptions\ValidationException;
use Carbon\Carbon;

class SprintsController extends Controller
{
  public function lists(Request $request)
  {
    return response()->json([
      'status' => 200,
      'data' => Sprint::where('status', '!=', Sprint::FINISHED)->first() ? : null
    ]);
  }

  public function create(CreateRequest $request)
  {
    if (Sprint::where('status', Sprint::CREATED)->orWhere('status', Sprint::STARTED)->first()) {
      throw new ValidationException(['name' => ['Может существовать только один спринт помимо завершенных']]);
    }

    if ($request->has('date_start') && $request->has('date_finish')) {
      $dateStart = Carbon::createFromTimestamp(strtotime($request->date_start));
      $dateFinish = Carbon::createFromTimestamp(strtotime($request->date_finish));

      if ($dateFinish < $dateStart) {
        throw new ValidationException([
          'date_start' => ['Дата начала не может быть позже даты окончания'],
          'date_finish' => ['Дата окончания не может быть раньше даты начала']
        ]);
      }
    }

    $sprint = new Sprint();
    $sprint->name = $request->name;
    $sprint->date_start = $request->date_start ? $dateStart->format('Y-m-d') : null;
    $sprint->date_finish = $request->date_finish ? $dateFinish->format('Y-m-d') : null;
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
        $sprint->date_start = Carbon::createFromTimestamp(strtotime($request->date_start))->format('Y-m-d');
      }
      $sprint->status = Sprint::STARTED;
      $sprint->date_finish = Carbon::createFromTimestamp(strtotime($request->date_finish))->format('Y-m-d');
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
