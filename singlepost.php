<?php session_start(); ?>
<?php
include('db.php');
include('functions.php');
$authorID = @$_SESSION['user_id'];

global $conn;


if(isset($_GET['post_id']) && $_GET['post_id'] != ""){
    $getPostId = $_GET['post_id'];
    $posts = mysqli_query($conn, "SELECT * FROM post_data AS posts, user_credentials AS users WHERE posts.post_author_id = users.id AND posts.post_id = '$getPostId'");
    $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);

    $sql = mysqli_query($conn, "SELECT read_count FROM post_data WHERE post_data.post_id = '$getPostId'");
    $postCount = mysqli_fetch_array($sql);
    $currentCount = $postCount['read_count'] + 1;

    $queryUpdate = mysqli_query($conn, "UPDATE post_data SET post_data.read_count = '$currentCount' WHERE post_data.post_id = '$getPostId'");
}else {
    header("Location: index.php");
}
    $categories = mysqli_query($conn, "SELECT * FROM post_category");
    $postCategories = mysqli_fetch_all($categories, MYSQLI_ASSOC);

    $readCount = mysqli_query($conn, "SELECT * FROM post_data ORDER BY read_count DESC LIMIT 6");
    $count = mysqli_fetch_all($readCount, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forum to discuss trending matters">
    <meta name="keyword" content="Forum, discussion, politics, sports">
    <title>My Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="general_container">

    <!--        HEADER-->
    <?php include('header.php'); ?>

    <!--        CATEGORY LIST-->
    <div class="post-categories">
        <?php foreach ($categories as $category){ ?>
            <ul class="categories">
                <li><a href="index.php?category_id=<?php echo $category['category_id'] ?>"><button class="category-button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="post-categories-icon">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            <p class="cat"><?php echo $category['category'] ?></p></button></a></li>
            </ul>
        <?php } ?>
    </div>

    <!--        MAIN POST-->
    <main>

        <h2 class="recent-posts">Recent Posts</h2>

        <div class="main_container">

            <?php foreach ($posts as $post) { ?>
                <div class="each-post">
                    <h3 class="aside"><?php echo $post['post_title'] ?></h3>
                    <?php if($post['post_image'] != NULL){ ?>
                        <img src="<?php echo $post['post_image']; ?>" height="400" width="100%"/>
                    <?php } else {?>
                        <img src="img/post-img.jpg" alt="post-image" height="150" width="600" />
                    <?php } ?>
                    <p><?php echo ($post['post_content']); ?></p>
                    <?php if(isset($_SESSION['user_id'])) { ?>
                        <?php if($post['post_author_id'] == $_SESSION['user_id']) {?>
                            <div class="title-list">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="delete-post-icon">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                <a href="delete.php?post_id=<?php echo $post['post_id'] ?>" class="btnDelete">Delete Post</a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="author-home">
                        <p><i>Author: <?php echo $post['firstname']. " " . $post['lastname']; ?></i></p>
                        <div class="back">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="delete-post-icon">
                                <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                            </svg>
                            <a href="index.php" class="btnHome">Home</a>
                        </div>
                    </div>
                </div>
                <form method="post">
                    <div class="comment-form">
                        <textarea class="comment-field" rows="1" cols="50"></textarea>
                        <button class="comment-submit">Submit</button>
                    </div>
                </form>
            <?php } ?>


        </div>
    </main>

    <!--        SIDEBAR-->
    <aside>
        <div class="sidebar">
            <h3 class="aside">Topic Title</h3>
            <?php foreach ($readCount as $row) { ?>
                <ul>
                    <li>
                        <a href="singlepost.php?post_id=<?php echo $row['post_id']; ?>" class="popular-posts"><?php echo $row['post_title']; ?></a>
                    </li>

                </ul>
            <?php } ?>
        </div>
    </aside>

    <!--        SVG POST BUTTON-->
    <?php
    if(isset($_SESSION['user_id'])) {
        ?>
        <a href="post.php" class="btn-post">
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="button">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    <?php } ?>

    <!--        FOOTER-->
    <?php include('footer.php'); ?>
</div>
</body>
<script src="script.js"></script>
</html>