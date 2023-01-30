<?php
require_once 'includes.php';

use Models\Post;
use Chrisvanlier2005\DatabaseQuery;
use Models\Comment;

try {

    $posts = Post::with('comments')->get();
} catch (Exception $e){
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
