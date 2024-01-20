<?php
    session_start();
    include('functions.php');
    include ('db.php');
    global $conn;

    if(isset($_SESSION['user_id']) && isset($_GET['post_id'])){
        $postId = $_GET['post_id'];
        $postAuthorId = $_SESSION['user_id'];

        $checkUserData = $conn->prepare("SELECT * FROM post_data WHERE post_id = ? AND post_author_id = ?");
        $checkUserData->bind_param('ii', $postId, $postAuthorId);
        $checkUserData->execute();

        $result = $checkUserData->get_result();

        if($result->num_rows>0){
            deletePost($postId);
        }else {
            echo "You do not have permission to delete this post.";
        }
        header("Location:index.php");
    }


//
?>