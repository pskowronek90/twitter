<?php

class Tweet
{
    private $id; // int
    private $userId; // int
    private $text; // text
    private $creationDate; // date

    // Konstruktor

    public function __construct()
    {
        $this->id = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }

    // Getery i setery

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        if (mb_strlen($text) <= 160) {
            $this->text = $text;
        } else {
            echo "Twój wpis jest za długi! (max 160 znaków)";
        }

    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    // Metody

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) { /* Saving new user to DB */
            $stmt = $conn->prepare('INSERT INTO Tweets(user_id, text, creationDate)
                    VALUES (:user_id, :text, :creationDate)');
            $result = $stmt->execute([
                                        'user_id' => $this->userId,
                                        'text' => $this->text,
                                        'creationDate' => $this->creationDate]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
    }

    // Operacje na tweetach

    static public function loadTweetById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE id=:tweet_id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['tweet_id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];
            return $loadedTweet;
        }
        return null;
    }
    static public function loadAllTweetsByUserId(PDO $conn, $userId)
    {
        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE user_id=:user_id');
        $result = $stmt->execute(['user_id' => $userId]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['tweet_id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];
            return $loadedTweet;
        }
        return null;
    }
    static public function loadAllTweets(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Tweets ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['tweet_id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

}

# Test

$test = new Tweet();
$test->setUserId(2);
$test->setText('sample');
$test->setCreationDate("NOW()");
$test->saveToDB($conn);

