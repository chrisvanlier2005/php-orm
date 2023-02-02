<?php
namespace Models;

use Chrisvanlier2005\Elegant;

class Comment extends Elegant {

    protected $fields = [
        "content"
    ];
    public function post(){
        return $this->belongsTo(Post::class, 'id', 'post_id', null, $this);
    }
}