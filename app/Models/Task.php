<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','description', 'priority', 'progress', 'date', 'pdf', 'student_pdf'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_task', 'task_id', 'student_id');
    }
}

