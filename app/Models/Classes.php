<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class, 'teacher_id');
    // }
    // public function teachers()
    // {
    //     return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id');
    // }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function subjects()
    {
        // Ambil mata pelajaran melalui tabel class_teacher
        return $this->belongsToMany(Subject::class, 'class_teacher', 'class_id', 'subject_id')
            ->withPivot('teacher_id')
            ->distinct(); // Hindari duplikasi mata pelajaran
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
            ->withPivot('subject_id');
    }
}