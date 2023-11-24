<?php
    include_once "db.php";

    if(isset($_POST['btnRegister'])){
        $firstName = htmlspecialchars($_POST['fname']);
        $lastName = htmlspecialchars($_POST['lname']);
        $email = htmlspecialchars($_POST['uname']);
        $username = htmlspecialchars($_POST['uname']);
        $password = htmlspecialchars($_POST['pword']);
        $confirmPassword = htmlspecialchars($_POST['cPword']);

        // var_dump($_POST);
        if($password === $confirmPassword){
           $stmt = $conn->prepare("INSERT INTO user_credentials (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
           $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $password);
           $stmt->execute();
           echo "Registration Successful";
        } else echo "Password must be the same as confirm password";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <form method="post">
            <h1>Sign Up</h1>
            <div class="login_container">
                <label for="firstName"><b>First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="fname" required>    

                <label for="LastName"><b>Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="lname" required>

                <label for="email"><b>Email Address</b></label>
                <input type="email" placeholder="johndoe@qq.com" name="email" required>

                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="pword"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pword" required>

                <label for="confirmpword"><b>Confirm Password</b></label>
                <input type="password" placeholder="Confirm Password" name="cPword" required>

                <input type="submit" name="btnRegister" value="Register" class="btn">

                <p>Already have an account? <a href="login.php">Login</a>
            </div>
        </form> 
</body>
</html>