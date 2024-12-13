<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'location', 'name'];
    public function tasks()
{
    return $this->belongsToMany(Task::class);
}

}
