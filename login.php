<?php
session_start();
$str = file_get_contents('users.json');
$users = json_decode($str, true);

if (
    isset($_POST['login'])
    && !empty($_POST['username'])
    && !empty($_POST['password'])
) {
    foreach ($users as $user => $psw) {
        print_r($user . '-->' . $psw);
        if (
            $_POST['username'] === $user
            && $_POST['password'] === $psw
        ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $user;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/css/main.min.css">

    <title>File browser</title>
</head>

<body>

    <div class="background-container">
        <div class="container">
            <img src="assets/img/moon.png" alt="">
            <div class="stars"></div>
            <div class="twinkling"></div>
            <div class="clouds"></div>
            <h1>Your file browser</h1>
            <h3 class="error" id="passwordMessage"></h3>

            <?php
            if (isset($_GET['action']) and $_GET['action'] == 'logout') {
                session_start();
                unset($_SESSION['username']);
                unset($_SESSION['password']);
                unset($_SESSION['logged_in']);
                echo '<h3 class="utility__message">You have logged out</h3>';
            }
            ?>


            <?php
            if ($_SESSION['logged_in'] === true) {

                echo '<div class="userUI">
                    <h4 class="userUI__name">Welcome, ' . $_SESSION['username'] . '!</h4>
                    <a class="userUI__link" href="login.php?action=logout">Logout</a>
                    </div>';
                echo '<div class="utility">
                <h3 class="utility__message">Welcome, <span class="utility__special">
                 ' . $_SESSION['username'] . '
                </span>
                you have successfully logged in</h3>
                </div>';
                echo '<form action="index.php" method="POST" class="start" id="start">
                <button type="submit" class="bouncy" name="">
                Start browsing</button>';
            } else {
                echo '  <h3 class="error" id="passwordMessage"></h3>
        <form action="login.php" method="POST" class="start" id="login">
            <button type="submit" class="bouncy" id="start" name="login">Login</button>

            <div class="input-container">
                <input type="text" id="username" name="username" autocomplete="off" required>
                <label for="username" class="label-name">
                    <span class="content-name">Enter username</span>
                </label>
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <label for="password" class="label-name">
                    <span class="content-name">Enter password</span>
                </label>
            </div>
        </form>';
            }

            ?>



        </div>
    </div>
    <script src="js/login.js"></script>

</body>

</html>