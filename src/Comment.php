<?php

class Comment
{
    private $id; //int
    private $userId; // int
    private $postId; // int
    private $creation_date; // datetime
    private $text; // string

    // Konstruktor

    public function __construct()
    {
        $this->id = -1;
        $this->userId = "";
        $this->postId = "";
        $this->creation_date = "";
        $this->text = "";
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

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
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
            echo "Twój komentarz jest za długi! (max 160 znaków)";
        }

        if (mb_strlen($text) == 0) {
            echo "Twój komentarz jest pusty";
        }

    }

    // Wrzucenie do bazy

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $stmt = $conn->prepare('INSERT INTO Comments (user_id, post_id, text, creationDate) VALUES (:user_id, :post_id, :text, :creationDate)');
            $result = $stmt->execute([
                'user_id' => $this->userId,
                'post_id' => $this->postId,
                'text' => $this->text,
                'creationDate' => $this->creation_date
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
    }

    // Operacje na komentarzach

    static public function loadAllTweets(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Comments ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedComment = new Tweet();
                $loadedComment->id = $row['comm_id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->postId = $row['user_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creationDate'];
                $ret[] = $loadedComment;
            }
        }
        return $ret;
    }

}