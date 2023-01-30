<?php
require_once 'includes.php';

use Models\Post;
use Chrisvanlier2005\DatabaseQuery;
use Models\Comment;

//$posts = Post::with('comments')->get();

//$comments = Comment::with('post')->get();
$comments = Comment::with('post')->find(1);
dd($comments);