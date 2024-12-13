<?php

namespace App\Models;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function classes()
    {
        return $this->hasMany(Classes::class, 'subject_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'subject_id');
    }
}