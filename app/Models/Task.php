<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'mail',
        'task',
        'done'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
