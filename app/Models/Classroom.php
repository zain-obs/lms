<?php

namespace App\Models;

use App\Models\User;
use App\Models\Chatroom;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classrooms';
    protected $fillable = ['course', 'section', 'code', 'instructor_id'];
    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_users', 'classroom_id', 'user_id');
    }
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function books(){
        return $this->hasMany(Book::class);
    }
}
