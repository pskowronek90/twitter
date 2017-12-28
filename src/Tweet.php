<?php

require_once('../src/connection.php');

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

    // Getery o setery

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
        $this->text = $text;
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

}

# Test

$test = new Tweet();
$test->setUserId(2);
$test->setText('sample');
$test->setCreationDate("NOW()");
$test->saveToDB($conn);

