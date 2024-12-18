<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'task_id', 'file_path'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
