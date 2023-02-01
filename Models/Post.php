<?php

namespace Models;

use Chrisvanlier2005\Elegant;
use Exception;
use HasMany;

class Post extends Elegant
{
    protected $fields = [
        'title', 'content'
    ];


    /**
     * @throws Exception
     */

    public function comments($magic = true): HasMany
    {
        if (!$magic){
            return $this->hasMany(Comment::class, 'post_id');
        }
        return $this->hasMany(Comment::class, 'post_id', null , $this->id);

    }
}
