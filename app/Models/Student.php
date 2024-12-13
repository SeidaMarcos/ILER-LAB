<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'ciclo', 'curso'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'student_task', 'student_id', 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function students()
{
    return $this->belongsToMany(Student::class, 'student_task', 'task_id', 'student_id')
                ->withTimestamps();
}

}

