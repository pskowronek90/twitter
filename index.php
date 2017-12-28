<?php

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: web/login.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user'];
    $text = $_POST['text'];
    $creationDate = date('Y-m-d H:i:s', time());
    $tweet = new Tweet();
    $tweet->setUserId($user_id);
    $tweet->setText($text);
    $tweet->setCreationDate($creationDate);
    $tweet->saveToDB($conn);
}
$allTweets = Tweet::loadAllTweets($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Strona główna</title>
</head>
<body>
<div class="container">
    <h><a href="index.php">Strona główna</a></h>
    <br>
    <br><a href='web/login.php?action=logout'>Wyloguj się</a><br>
    <br><a id="msg" href="web/messages.php">Wiadomości</a>

    <div class="content">
        <div class="tweet-form">
            <form action="" method="post" role="form">

                <textarea cols="40" rows="4" id="text" name="text" placeholder="What's happening?"></textarea>
                <br>

                <input type="submit" value="Tweet">
            </form>
        </div>
        <?php
        foreach ($allTweets as $t) {
            $userId = $t->getUserId();
            $user = User::loadUserById($conn, $userId);
            echo "<div class='tweet'>";
            echo $user->getUsername() . " - " . $t->getCreationDate() . "<br>";
            echo $t->getText() . "<br>";
            // miejsce na kometarz
            include 'web/comments.php';
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>
