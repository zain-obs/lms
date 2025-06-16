<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabUser extends Model
{
    protected $table = "tab_users";
    protected $fillable = ['user_id', 'tab_id', 'priority'];

    public function tabs(){
        return $this->belongsTo(Tab::class);
    }
}
