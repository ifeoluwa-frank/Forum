<?php

    include('db.php');
    if(isset($_POST['btnSubmit'])){
        global $conn;

        $newCategory = htmlspecialchars($_POST['new-category']);

        if(!empty($newCategory) && $newCategory != ""){
            $sql = $conn->prepare("INSERT INTO post_category(category) VALUES (?)");
            $sql->bind_param("s",$newCategory);
            $sql->execute();
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Category</title>
</head>
<body>
    <div class="toppage">
        <h2>Add Category</h2>
        <h3>Note: This functionality is only available to Super Admin</h3>
    </div>
    <main>
        <form class="addNewCat" method="post">
            <label>Add New Category</label>
            <input type="text" name="new-category" class="new_category">
            <button type="submit" class="btn" name="btnSubmit">Submit</button>
        </form>
    </main>
</body>
</html>
