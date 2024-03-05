<?php
session_start();
include ('db.php');

$authorId = $_SESSION['user_id'];

if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){ header('Location: login.php'); exit();}
$target_dir = "uploads/";

global $conn;
$categories = mysqli_query($conn, "SELECT * FROM post_category");
$postCategories = mysqli_fetch_all($categories, MYSQLI_ASSOC);


if(isset($_POST['btnSubmit'])){
//    var_dump($_POST);

    $title = htmlspecialchars($_POST['post-title']);
    $category = htmlspecialchars($_POST['categories']);
    $content = htmlspecialchars($_POST['post-content']);
    $postId = htmlspecialchars($_POST['post_id']);



    if(isset($_FILES['post-image']) && !empty($_FILES['post-image']['name'])) {
        $target_file = $target_dir . basename($_FILES['post-image']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($imageFileType, $allowTypes)) {
            $image = $_FILES['post-image']['tmp_name'];
            move_uploaded_file($image, $target_file);

            $imagePath = $target_file;

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
    <div class="post-container">
        <form method="post" action="post.php" class="post-form" enctype="multipart/form-data">
            <label><b>Post Title</b></label>
            <input type="text" name="post-title" class="post-title" />

            <label><b class="">Post Category</b></label><br>
            <select name="categories" class="select-category">
                <?php foreach ($categories as $category){ ?>
                    <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category'] ?></option>
                <?php } ?>
            </select>

            <label><b>Post Image</b></label><br>
            <input type="file" name="post-image" class="post-image" /><br>

            <label><b>Post Content</b></label><br>
            <textarea name="post-content" class="field content" rows="12" cols="90"></textarea>

            <input class="post_id" name="post_id" type="hidden" />

            <button class="btn btn-update" type="submit" name="btnSubmit">Post</button>
        </form>
        <div class="post-history">
            <h3 class="my-post-title">My post history</h3>
            <?php foreach ($results as $post): ?>
                <ul>
                    <li class="title-list">
                        <svg xmlns="http://www.w3.org/2000/svg"

                             fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="history-categories-icon">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <a onclick='handleEdit(<?php echo json_encode($post); ?>)'  href="#" class='post-update'>
                           <?php echo $post['post_title']; ?></a>
                    </li>
                </ul>
            <?php endforeach; ?>
            <button name="clearfield" onclick="clearField()" class="btn clear-field" hidden>Clear Input</button>

        </div>
    </div>
    <?php include('footer.php'); ?>
</div>
</body>
<script src="script.js"></script>
</html>
