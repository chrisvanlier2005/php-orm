<?php

namespace Models;

use Chrisvanlier2005\Elegant;

class Post extends Elegant
{
    /**
     * @throws \Exception
     */
    public function comments(): \HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
