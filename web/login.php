<?php
require_once '../src/connection.php';
require_once '../src/User.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = User::loadUserByUsername($conn, $username);
        if (!$user) {
            echo '<p>Zły login lub hasło</p>';
            exit;
        }
        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user->getId();
        } else {
            echo '<p>Zły login lub hasło</p>';
            exit;
        }
        if ($user == true) {
            echo '<p>Użytkownik zalogowany</p>';
        }
    }
} else {
    ?>

    <!DOCTYPE html>



    <html>
    <head>
        <meta charset="UTF-8">
        <title>Logowanie - Twitter</title>
    </head>
    <body>
    <form method="POST" action="">
        <p>
            <label>
                Login: <input name="username" type="text">
            </label>
        </p>
        <p>
            <label>
                Hasło: <input name="password" type="password">
            </label>
        </p>
        <p>
            <input type="submit" value="Zaloguj się">
        </p>
        <p>
            <a href="register.php">Zarejestruj się</a>
        </p>
    </form>
    </body>
    </html>

    <?php
}
