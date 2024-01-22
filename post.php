<?php
session_start();
include ('db.php');

$authorId = $_SESSION['user_id'];

if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){ header('Location: login.php'); exit();}
$target_dir = "uploads/";

//$uploadOK = 1;


if(isset($_POST['btnSubmit'])){
//    var_dump($_POST);

    $title = htmlspecialchars($_POST['post-title']);
    $category = htmlspecialchars($_POST['categories']);
    $content = htmlspecialchars($_POST['post-content']);
    $postId = htmlspecialchars($_POST['post_id']);


//    $check = getimagesize($_FILES['post-image']['tmp_name']);

    if(isset($_FILES['post-image']) && !empty($_FILES['post-image']['name'])) {
        $target_file = $target_dir . basename($_FILES['post-image']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($imageFileType, $allowTypes)) {
            $image = $_FILES['post-image']['tmp_name'];
//            $imgContent = addslashes(file_get_contents($image));
            move_uploaded_file($image, $target_file);

            $imagePath = $target_file;
//            echo $imagePath;

            if($postId != ""){
                $sql = $conn->prepare("UPDATE post_data SET post_title = ?, post_author_id = ?, post_category = ?, post_content = ?, post_image = ? WHERE post_id = ?");
                $sql->bind_param("sssssi", $title, $authorId, $category, $content, $imagePath, $postId);
                $sql->execute();
            } else {
                $sql = $conn->prepare("INSERT INTO post_data(post_title, post_author_id, post_category, post_content, post_image) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("sssss", $title, $authorId, $category, $content, $imagePath);
                $sql->execute();
            }

        } else {
            echo "Invalid file format";
        }
    } else {
//        $imgContent = null;


        if ($postId != "") {
            $sql = $conn->prepare("UPDATE post_data SET post_title = ?, post_author_id = ?, post_category = ?, post_content = ? WHERE post_id =  ?");
            $sql->bind_param("ssssi", $title, $authorId, $category, $content, $postId);
            $sql->execute();

//    echo "Post Successful";
        } else {
            $sql = $conn->prepare("INSERT INTO post_data(post_title,post_author_id,post_category,post_content) VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssss", $title, $authorId, $category, $content);
            $sql->execute();
        }
    }
}

    $posts = mysqli_query($conn, "SELECT * FROM post_data WHERE post_author_id = '$authorId'");
    $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);


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

        </div>
        <form method="post" action="post.php" enctype="multipart/form-data">
            <label><b>Post Title</b></label>
            <input type="text" name="post-title" class="post-title" />

            <label><b>Post Category</b></label><br>
            <select name="categories" class="select-category">
                <option value="sports">Sports</option>
                <option value="entertainment">Entertainment</option>
                <option value="music">Music</option>
                <option value="fashion">Fashion</option>
                <option value="politics">Politics</option>
            </select>

            <label><b>Post Image</b></label><br>
            <input type="file" name="post-image" class="post-image" /><br>

            <label><b>Post Content</b></label><br>
            <textarea name="post-content" class="field content" rows="12" cols="112"></textarea>

            <input class="post_id" name="post_id" type="hidden" />

            <button class="btn btn-update" type="submit" name="btnSubmit">Post</button>
        </form>

    </main>
</body>
<script src="script.js"></script>
</html>
