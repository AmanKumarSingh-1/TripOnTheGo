<?php
    // session = Super GLobal Variable(SGB) used to store information on a user
    //           to be used across multiple pages.
    //           A user is assigned a session-id
    //           ex. login credentials.

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        Username: <br> <input type="text" name="username" placeholder="Enter username"><br>
        Password: <br> <input type="password" name="password" placeholder="Enter password"><br>
        <input type="submit" name="login" value="login">
    </form>
</body>
</html>

<?php
    if (isset($_POST['login'])) {
        if(!empty($_POST['username']) && !empty($_POST['password'])) {
            echo "Login successful!<br>";
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];

            header("Location: home.php");
        } 
        else {
            echo "Please fill in all fields.<br>";
        }
        
    }
?>