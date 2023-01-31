<?php
require_once 'includes.php';

use Models\Post;

try {
    //$post = Post::with('comments')->find(1);
    $posts = Post::with('comments')
        ->orderBy('id')
        ->get();
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
