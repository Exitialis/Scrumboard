<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
  const CREATED = 0;
  const STARTED = 1;
  const FINISHED = 2;

  protected $fillable = ['name', 'date_start', 'date_finish'];

  protected $visible = ['id', 'name', 'date_start', 'date_finish', 'status'];

  public function isCreated()
  {
    return $this->status === self::CREATED;
  }

  public function isStarted()
  {
    return $this->status === self::STARTED;
  }

  public function isFinished()
  {
    return $this->status === self::FINISHED;
  }
}
