<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','description', 'priority', 'date', 'pdf', 'student_pdf'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_task', 'task_id', 'student_id');
    }
public function tools()
{
    return $this->belongsToMany(Tool::class);
}

public function machines()
{
    return $this->belongsToMany(Machine::class);
}

public function products()
{
    return $this->belongsToMany(Product::class);
}
}

