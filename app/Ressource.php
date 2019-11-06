<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    protected $fillable = [
        'name',
        'email',
        'availability',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
