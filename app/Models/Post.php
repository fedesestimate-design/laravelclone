<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    public function comments(){
        return $this->morphMany(Comments::class, 'commentable');
    }
    public function tags(){
        return $this->morphToMany(tags::class, 'taggable', 'taggables', 'taggable_id', 'tag_id');
    }
}
