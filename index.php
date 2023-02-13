<?php
require_once 'includes.php';

use Models\Post;
use Models\Comment;
$id = $_GET['id'] ?? 1;



try {
    $post = Post::retrieve()
        ->orderBy('id', 'DESC')
        ->first();

    $post = Post::hydrate($post);
    dd(
        $post->load('comments')
    );
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

<h1><?= $post->title ?></h1>
<?php foreach ($post->comments as $comment): ?>
    <div class="comment">
        <div class="comment__body">
            <p><?= $comment->content ?></p>
        </div>

    </div>
<?php endforeach; ?>
