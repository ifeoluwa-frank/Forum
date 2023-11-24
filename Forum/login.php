<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <form>
            <h1>Log In</h1>
            <div class="login_container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="pword"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pword" required>

                <button type="submit" class="btn"><b>Login</b></button>

                <p>Don't have an account? <a href="signup.php">Signup</a>
            </div>
        </form> 
</body>
</html>