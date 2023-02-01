<?php
require_once 'includes.php';

use Models\Post;

try {
    $post = Post::retrieve()->find(1);
    $post = Post::hydrate($post);

}
catch(Exception $e){
    dd($e->getMessage());
};
?>

