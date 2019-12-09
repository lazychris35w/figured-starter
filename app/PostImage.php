<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
// use Jenssegers\Mongodb\Eloquent\HybridRelations;

// class PostImage extends Model
class PostImage extends Eloquent
{
    protected $connection = 'mongodb';

    // The editable fields of a post image
    protected $fillable = ['post_id', 'post_image_path', 'post_image_caption'];

    // Post and image relationship
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
