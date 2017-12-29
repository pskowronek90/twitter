<?php

class Comment
{
    private $id; //int
    private $userId; // int
    private $postId; // int
    private $creation_date; // datetime
    private $comment; // string

    // Konstruktor

    public function __construct()
    {
        $this->id = -1;
        $this->userId = "";
        $this->postId = "";
        $this->creation_date = "";
        $this->comment = "";
    }

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

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        if (mb_strlen($comment) <= 160) {
            $this->comment = $comment;
        } else {
            echo "Twój komentarz jest za długi";
        }

        if (mb_strlen($comment) == 0) {
            echo "Komentarz nie może być pusty";
        }


    }

    // Wrzucenie do bazy

    public function saveComm(PDO $conn)
    {
        if ($this->id == -1) {
            $stmt = $conn->prepare('INSERT INTO Comments (user_id, post_id, text, creationDate) VALUES (:user_id, :post_id, :text, :creationDate)');
            $result = $stmt->execute([
                'user_id' => $this->userId,
                'post_id' => $this->postId,
                'text' => $this->comment,
                'creationDate' => $this->creation_date
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
    }

    // Operacje na komentarzach

    //TODO - Load comments for specific tweet

}
