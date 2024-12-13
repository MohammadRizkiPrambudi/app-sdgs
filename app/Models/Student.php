<?php

namespace App\Models;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'class_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class ()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

}