<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>


    <header>
        <div class="toppage">
            <h1 class="home">Discuss...</h1>
        </div>
        <div class="toppage">
            <?php if(!isset($_SESSION['user_id'])){?>
                <a class="loginpage" href="login.php"> Log In/Register </a>
            <?php } else { ?>
                <p class="loginpage">Welcome <?php echo $_SESSION['user_name']; ?></p>
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