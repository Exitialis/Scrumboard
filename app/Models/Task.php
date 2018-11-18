<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'creator'];

    const CREATED = 0;
    const PERFORMED = 1;
    const TESTING = 2;
    const DONE = 3;
}
