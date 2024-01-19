<?php
session_start();
include ('db.php');

$authorId = $_SESSION['user_id'];

if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){ header('Location: login.php'); exit();}
if(isset($_POST['btnSubmit'])){
//    var_dump($_POST);
    $title = htmlspecialchars($_POST['post-title']);
    $category = htmlspecialchars($_POST['categories']);
    $content = htmlspecialchars($_POST['post-content']);
    $postId = htmlspecialchars($_POST['post_id']);

    if($postId != "") {
        $sql = $conn->prepare("UPDATE post_data SET post_title = ?, post_author_id = ?, post_category = ?, post_content = ? WHERE post_id =  ?");
        $sql->bind_param("ssssi", $title, $authorId, $category, $content, $postId);
        $sql->execute();

//    echo "Post Successful";
    }else {
        $sql = $conn->prepare("INSERT INTO post_data(post_title,post_author_id,post_category,post_content) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $title, $authorId, $category, $content);
        $sql->execute();
    }
}
    $posts = mysqli_query($conn, "SELECT * FROM post_data WHERE post_author_id = '$authorId'");
//    print_r($posts);
//    echo $_SESSION['user_name'];
    $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);

//    if(isset($_POST['btnDelete'])){
//        $postId = htmlspecialchars($_POST['post_id']);
//        $sql = $conn->prepare("DELETE FROM post_data WHERE post_id = ?");
//        $sql->bind_param("i", $postId);
//        $sql->execute();
//    }


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post Content</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="post_general_container">
    <?php include('header.php'); ?>
    <main class="post-container">
        <div>
            <h3>My post history</h3>
            <?php foreach ($results as $post): ?>
                <ul>
                    <li><a onclick='handleEdit(<?php echo json_encode($post); ?>)' href='#' class='post-update'><?php echo $post['post_title']; ?></a></li>
                </ul>
            <?php endforeach; ?>
            <button name="clearfield" onclick="clearField()" class="btn clear-field" hidden>Clear Input</button>
            <button name="btnDelete"  onclick="btnDelete(<?php echo json_encode($sql); ?>)" class="btnDelete" hidden>Delete Post</button>
        </div>
        <form method="post" action="post.php">
            <label><b>Post Title</b></label>
            <input type="text" name="post-title" class="post-title" />

            <label><b>Post Category</b></label><br>
            <select name="categories" class="select-category">
                <option value="sports">Sports</option>
                <option value="entertainment">Entertainment</option>
                <option value="music">Music</option>
                <option value="fashion">Fashion</option>
                <option value="politics">Politics</option>
            </select><br>

            <label><b>Post Content</b></label><br>
            <textarea name="post-content" class="field content" rows="12" cols="112"></textarea>

            <input class="post_id" name="post_id" type="hidden" />

            <button class="btn btn-update" type="submit" name="btnSubmit">Post</button>
        </form>

    </main>
</body>
<script src="script.js"></script>
</html>
