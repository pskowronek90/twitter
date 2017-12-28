<?php
require_once '../src/connection.php';
require_once '../src/User.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $email = $_POST['username'];
        $password = $_POST['password'];
        $user = User::loadUserByEmail($conn, $email);
        if (!$email) {
            echo '<p>Zły login lub hasło</p>';
            exit;
        }
        if (password_verify($password, $user->getPassword())) {
            $_SESSION['username'] = $user->getId();
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
                E-mail: <input name="username" type="email">
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
