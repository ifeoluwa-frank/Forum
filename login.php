<?php
    session_start();
    include_once "db.php";
    if(isset($_POST['btnSubmit'])){
        global $conn;
//        var_export($_POST);

        $username = htmlspecialchars($_POST['uname']);
        $password = htmlspecialchars($_POST['pword']);

        $query = mysqli_query($conn, "SELECT * FROM user_credentials WHERE username = '$username' AND password = '$password'");
        $data = mysqli_fetch_array($query);
        if($query){
//            echo "Connection successful";
//            print_r($data);
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_name'] = $data['username'];
            $_SESSION['full_name'] = $data['firstname'] . " " . $data['lastname'];
            header('Location: index.php');
        }else {
            echo "Invalid login credentials";
        }

    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <form method="post">
            <h1>Log In</h1>
            <div class="login_container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="pword"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pword" required>

                <button type="submit" class="btn" name="btnSubmit"><b>Login</b></button>

                <p>Don't have an account? <a href="signup.php">Signup</a>
            </div>
        </form> 
</body>
</html>