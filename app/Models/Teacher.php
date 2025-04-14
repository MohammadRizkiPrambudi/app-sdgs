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

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_teacher', 'teacher_id', 'subject_id')
            ->withPivot('class_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teacher', 'teacher_id', 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}