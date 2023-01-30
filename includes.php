<?php
// THIS IS A TEMPORARY INCLUDES FILE
require_once 'Lib/Elegant.php';
require_once 'Lib/Relations/BaseRelation.php';
require_once "Lib/Relations/HasMany.php";
require_once "Lib/DatabaseQuery.php";
require_once 'Models/Post.php';
require_once 'Models/Comment.php';


function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}