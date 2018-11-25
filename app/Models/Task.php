<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'creator', 'executor', 'sprint'];

    const CREATED = 0;
    const PERFORMED = 1;
    const TESTING = 2;
    const DONE = 3;

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'sprint');
    }

    public function isCreated()
    {
        return $this->status === self::CREATED;
    }

    public function isPerformed()
    {
        return $this->status === self::PERFORMED;
    }

    public function isTesting()
    {
        return $this->status === self::TESTING;
    }

    public function isDone()
    {
        return $this->status === self::DONE;
    }
}
