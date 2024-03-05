<?php session_start(); ?>
<?php
    include('db.php');
    include('functions.php');
    $authorID = @$_SESSION['user_id'];

    global $conn;
    $error = "";

    if(isset($_GET['category_id']) && $_GET['category_id'] != ""){
        // CATEGORY SORTING
        $getCategory = $_GET['category_id'];
        $posts = mysqli_query($conn, "SELECT * FROM post_data AS posts, user_credentials AS users WHERE posts.post_author_id = users.id AND posts.post_category = '$getCategory'");
        $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);
    } else {
        // POST DISPLAY QUERY BY LATEST POST
        $posts = mysqli_query($conn, "SELECT * FROM post_data AS posts, user_credentials AS users WHERE posts.post_author_id = users.id ORDER BY post_id DESC ");
        $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);
//        print_r($results);
    }
        $categories = mysqli_query($conn, "SELECT * FROM post_category");
        $postCategories = mysqli_fetch_all($categories, MYSQLI_ASSOC);

        $readCount = mysqli_query($conn, "SELECT * FROM post_data ORDER BY read_count DESC LIMIT 6");
        $count = mysqli_fetch_all($readCount, MYSQLI_ASSOC);

        $postIds = mysqli_query($conn, "SELECT post_id FROM post_data");
        $postId = mysqli_fetch_all($postIds, MYSQLI_ASSOC);


        $postComments = mysqli_query($conn, "SELECT * FROM post_comment AS posts, user_credentials AS users WHERE posts.comment_user_id = users.id");
        $postComment = mysqli_fetch_all($postComments, MYSQLI_ASSOC);
//        print_r($postComment);

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
                                <div class="each-post-post">
                                    <h3 class="aside"><?php echo $post['post_title'] ?></h3>
                                        <?php if($post['post_image'] != NULL){ ?>
                                                    <img src="<?php echo $post['post_image']; ?>" height="400" width="100%"/>
                                                <?php } else {?>
                                                    <img src="img/post-img.jpg" alt="post-image" height="150" width="600" />
                                                <?php } ?>
                                    <p><?php echo substr($post['post_content'], 0, 200); ?>...<a href="singlepost.php?post_id=<?php echo $post['post_id']; ?>">Read more</a></p>
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

                                    <p><i>Author: <?php echo $post['firstname']. " " . $post['lastname']; ?></i></p>
                                    <div>
                                        <button class="like-button">
                                            <div class="comment-div">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="#087f5b"
                                                        class="like-icon">
                                                    <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                                </svg>
                                                <b class="comment-num">120k</b>
                                            </div>
                                        </button>
<!--                                        onclick="toggleComment(this)"-->
                                        <button class="like-button comment-button"  id="comment_form_trigger" data-postId="<?php echo $post['post_id']; ?>" data-user="<?php echo @$_SESSION['user_id']; ?>">
                                            <div class="comment-div">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="#087f5b"
                                                        class="comment-icon">
                                                    <path
                                                            fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
                                                </svg>
                                                <b class="comment-num">35</b>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="user-comment">
                                <!--                                   Display Comments-->

                                    <?php foreach ($postComments as $comments){ ?>
                                        <?php if($post['post_id'] == $comments['post_id']) { ?>
                                            <div class="each-comment">
                                                <div class="comment-profile">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="comment-post-icon">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    <b class="comment-author"><?php echo $comments['firstname'] . " " . $comments['lastname']; ?></b>
                                                </div>
                                                <div class="comment-text">
                                                    <?php echo $comments['comment_content']; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                            </div>
                        <?php } ?>


                    </div>
            </main>

<!--        SIDEBAR-->
        <aside>
                <div class="sidebar">
                    <h3 class="aside">Popular Posts</h3>
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
