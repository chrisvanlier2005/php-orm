<?php
require_once 'includes.php';

use Models\Post;
use Models\Comment;

try {
    $post = Post::search(1);
    Post::hydrate($post);

    $post->comments()->attach([
            "title" => "This is a comment",
    ]);
} catch (Exception $e) {
    dd($e->getMessage());
}

?>

<style>
    .comment {
        border: 1px solid black;
        padding: 10px;
        margin: 10px;
        display: flex;
        justify-items: center;
        align-items: center;
        gap: 1rem;
    }
</style>

<pre>
    <?php var_dump($post) ?>
</pre>
