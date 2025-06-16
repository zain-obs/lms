<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $fillable = ['message','sender', 'classroom_id', 'channel'];
    public function books(){
        return $this->hasOne(Book::class);
    }
}
