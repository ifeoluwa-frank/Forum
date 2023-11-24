<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="toppage">
            <h1 class="home">Discuss...</h1>
        </div>
         <div class="toppage">
            <?php if(!isset($_SESSION['user_id'])){?>
             <a class="loginpage" href="login.php"> Log In/Register </a>
             <?php } else { ?>
             <a class="loginpage" href="logout.php"> Log out </a>
             <?php } ?>
        </div>
        <div>
            <ul class="categories">
                <li><a href="#" >Sports</a></li> 
                <li><a href="#" >Entertainment</a></li>
                <li><a href="#" >Music</a></li>
                <li><a href="#" >Sports</a></li>
                <li><a href="#" >Sports</a></li>
            </ul>
        </div>
    </header>
    <main>
        <p>
            <h2>Recent Posts</h2>

                <div class="main_container">
                    <h3>Topic Title</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>

                <div class="sidebar">
                    <h3>Topic Title</h3>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
 
        </p>
    </main>
    <footer>

    </footer>
</body>
</html>