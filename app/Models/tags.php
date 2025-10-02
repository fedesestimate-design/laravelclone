<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    use HasFactory;
    protected $table = 'tags';

    function posts(){
        return $this->morphedByMany(Post::class, 'taggable');
    }
    function tasks(){
        return $this->morphedByMany(Tasks::class, 'taggable');
    }
}
