<?php
require_once 'includes.php';

use Models\Post;

try {
    $post = Post::create([
        "title" => "My first post",
        "content" => "This is my first post"
    ]);


    $posts = Post::with('comments')->get();
} catch (Exception $e) {
    dd($e->getMessage());
}

?>

<?php foreach ($posts as $post): ?>
    <h1><?php echo $post->title; ?></h1>
    <p><?php echo $post->content; ?></p>
    <h2>Comments</h2>
    <?php foreach ($post->comments as $comment): ?>
        <p><?php echo $comment->content; ?></p>
    <?php endforeach; ?>
<?php endforeach; ?>
