<?php

namespace App\Models;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    public function classes()
    {
        return $this->hasMany(Classes::class, 'teacher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}