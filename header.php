
    <header>
        <div class="toppage">
            <a href="index.php"><h1 class="home">Discuss...</h1></a>
        </div>
        <div class="toppage">
            <?php if(!isset($_SESSION['user_id'])){?>
                <a class="loginpage" href="login.php"> Log In/Register </a>
            <?php } else { ?>
                <p class="loginpage">Welcome <?php echo $_SESSION['user_name']; ?></p>
                <a class="loginpage" href="logout.php"> Log out </a>
            <?php } ?>
        </div>
    </header>