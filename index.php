<?php
require_once 'includes.php';

use Models\Post;
use Models\Comment;
try {
    // will return a post stdClass object
    $post = Post::retrieve()->find(1);
    // hydrate is required to make it interactive again.
    $post = Post::hydrate($post);
    $comments = $post->comments()->fetch();

}
catch(Exception $e){
    dd($e->getMessage());
};
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
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <h6><?= $comment->id ?></h6>
        <p><?= $comment->content ?></p>
    </div>
<?php endforeach; ?>
