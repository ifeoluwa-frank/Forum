<?php
session_start();
include ('db.php');

if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){ header('Location: login.php'); exit();}
if(isset($_POST['btnSubmit'])){
//    var_dump($_POST);
    $title = htmlspecialchars($_POST['post-title']);
    $category = htmlspecialchars($_POST['categories']);
    $content = htmlspecialchars($_POST['post-content']);
    $authorId = $_SESSION['user_id'];

    global $conn;
    $sql = $conn->prepare("INSERT INTO post_data(post_title,post_author_id,post_category,post_content) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $title,$authorId, $category, $content);
    $sql->execute();

//    echo "Post Successful";
}
//    echo $_SESSION['user_name'];
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
        <form method="post">
            <label><b>Post Title</b></label>
            <input type="text" name="post-title" class="post-title" />

            <label><b>Post Category</b></label><br>
            <select name="categories">
                <option value="sports">Sports</option>
                <option value="entertainment">Entertainment</option>
                <option value="music">Music</option>
                <option value="fashion">Fashion</option>
                <option value="politics">Politics</option>
            </select><br>

            <label><b>Post Content</b></label><br>
            <textarea name="post-content" class="field content" rows="12" cols="112"></textarea>

            <button class="btn" type="submit" name="btnSubmit">Post</button>
        </form>
    </main>
</body>
</html>
