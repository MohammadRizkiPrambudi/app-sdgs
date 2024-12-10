<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'class_id'];

    public function class ()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}