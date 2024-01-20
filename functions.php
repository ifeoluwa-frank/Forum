<?php

function deletePost($postId) {
    global $conn;
            $sql = $conn->prepare("DELETE FROM post_data WHERE post_id = ?");
            $sql->bind_param("i", $postId);
            $sql->execute();

            if ($sql->affected_rows > 0) {
                echo "Post deleted successfully";
            } else {
                echo "Error deleting post: " . $conn->error;
            }
}

?>