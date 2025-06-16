<?php

namespace App\Models;

use App\Models\Message;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tabs(){
        return $this->belongsToMany(Tab::class, 'tab_users')->withPivot('priority');
    }

    public function classrooms(){
        return $this->belongsToMany(Classroom::class, 'classroom_users');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
