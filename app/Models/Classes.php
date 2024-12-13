<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'teacher_id', 'subject_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // public function assignments()
    // {
    //     return $this->hasMany(Assignment::class);
    // }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }
}