<?php
session_start();

include('db.php');
global $conn;

if(isset($_SESSION['user_id'])) {
    $commentContent = htmlspecialchars($_POST['comment']);
    $postId = htmlspecialchars($_POST['post_id']);
    $comment_by = htmlspecialchars($_POST['user_id']);

    $sql = $conn->prepare("INSERT INTO post_comment(comment_user_id, comment_content, post_id) VALUES (?, ?, ?)");
    $sql->bind_param("isi", $comment_by, $commentContent, $postId);
    $sql->execute();

    echo 200;
}