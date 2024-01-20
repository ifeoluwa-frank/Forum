<?php session_start(); ?>
<?php
    include('db.php');
    include('functions.php');
    $authorID = @$_SESSION['user_id'];

    $posts = mysqli_query($conn, "SELECT * FROM post_data AS posts, user_credentials AS users WHERE posts.post_author_id = users.id");

    $results = mysqli_fetch_all($posts, MYSQLI_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="general_container">
    <?php include('header.php'); ?>
    <main>

            <h2>Recent Posts</h2>

                <div class="main_container">

                    <?php foreach ($posts as $post) { ?>
                    <h3><?php echo $post['post_title'] ?></h3>
                    <img src="img/post-img.jpg" alt="post-image" height="150" width="600" />
                    <p><?php echo $post['post_content']; ?></p>
                        <?php if($post['post_author_id'] == $_SESSION['user_id']) {?>
                              <a href="delete.php?post_id=<?php echo $post['post_id'] ?>" class="btnDelete">Delete<?php echo $post['post_id']; ?></a>
                        <?php } ?>

                        <p><i><?php echo $post['firstname']. " " . $post['lastname']; ?></i></p>
                    <?php } ?>

                </div>
    </main>
    <aside>
                <div class="sidebar">
                    <h3>Topic Title</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
    </aside>
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
    <footer>
        <P> Copyright &copy; 2023 Ifeoluwa Frank. </P>
    </footer>
</div>

</body>
<script src="script.js"></script>
</html>