<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'name', 'stock', 'material'];

    public function tasks()
{
    return $this->belongsToMany(Task::class);
}

}
