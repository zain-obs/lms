<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomUser extends Model
{
    protected $table = "classroom_users";
    protected $fillable = [
        'classroom_id', 'user_id'
    ];
}
