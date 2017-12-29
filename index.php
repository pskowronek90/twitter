<?php

session_start();

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';
require_once 'src/Comment.php';

if (!isset($_SESSION['user'])) {
    header("Location: web/login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user'];
    // zgarnięcie id tweeta
    $postId = $_SESSION['Tweet'];
    // komentarz
    $userId = $_SESSION['user'];
    $creation_date = date('Y-m-d H:i:s', time());
    $text = $_POST['text'];
    $creationDate = date('Y-m-d H:i:s', time());
    $tweet = new Tweet();
    $tweet->setUserId($user_id);
    $tweet->setText($text);
    $tweet->setCreationDate($creationDate);
    $tweet->saveToDB($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
}

if ($comment) {
    $comm = new Comment();
    $comm->setUserId($userId);
    $comm->setPostId($postId);
    $comm->setCreationDate($creation_date);
    $comm->setComment($comment);
    $comm->saveComm($conn);
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
            echo "<form method='post' action=''>
                <textarea cols='40' rows='4' name='comment' placeholder='Your comment'></textarea><br>
                <input type='submit' value='Comment'>
            </form>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>

<?php var_dump($t); ?>
<?php var_dump($_SESSION); ?>
