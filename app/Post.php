<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

// class Post extends Model
class Post extends Eloquent
{
    use HybridRelations;

    protected $connection = 'mongodb';

    // The editable fields of a post
    protected $fillable = ['title', 'body', 'user_id'];

    // Post and author relationship
    public function author() {
        return $this->belongsTo('App\User');
    }

    // Post and image relationship
    public function post_images() {
        return $this->hasMany('App\PostImage');
    }
}
