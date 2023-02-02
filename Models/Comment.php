<?php
namespace Models;

use Chrisvanlier2005\Elegant;

class Comment extends Elegant {
    public function post(){
        return $this->belongsTo(Post::class, 'id', 'post_id', null, $this);
    }
}