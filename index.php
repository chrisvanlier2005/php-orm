<?php
require_once 'includes.php';
use Models\Post;
use Chrisvanlier2005\DatabaseQuery;

$post = Post::with('comments')->find(1);
var_dump($post);
