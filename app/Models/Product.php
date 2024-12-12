<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'density', 'location', 'id_student', 'id_task'];

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'id_task');
    }
}
