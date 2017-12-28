<?php
session_start();

require_once'../src/connection.php';
require_once'../src/User.php';

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $conn->prepare('SELECT * FROM Users WHERE email=:email');
        $result = $stmt->execute(['email' => $email]);
        if ($result === true && $stmt->rowCount() > 0) {
            echo "<p>Podany adres e-mail jest już zajęty</p>";
            exit;
        }
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->saveToDB($conn);
        $_SESSION['user'] = $user->getId();
        header("Location: ../index.php");
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Rejestracja</title>
    </head>
    <body>
    <form method="POST" action="">
        <p><label>Login: </label><input name="username" type="text"></label></p>
        <p><label>Email: <input name="email" type="email"></label></p>
        <p><label>Hasło: <input name="password" type="password"></label></p>
        <p><label>Register: <input type="submit" value="Register"></label></p>
    </form>
    </body>
    </html>

    <?php
}