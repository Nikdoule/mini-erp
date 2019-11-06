<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'archived',
    ];
    
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}

