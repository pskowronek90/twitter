<?php

include ('connection.php');

class User
{

    // Własności

    private $id;
    private $username;
    private $hashPass;
    private $email;

    // Konstruktor

    public function __construct()
    {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashPass = "";
    }

    // Getery i setery

    public function setPassword($newPass) {
        $newHashedPass = password_hash(
            $newPass, PASSWORD_BCRYPT);
        $this->hashPass = $newHashedPass;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getHashPass()
    {
        return $this->hashPass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    // Zapisanie nowego obiektu do bazy

    public function saveToDB (PDO $conn)
    {
        if ($this->id == -1) {
            $stmt = $conn->prepare('INSERT INTO Users (email, username, hash_pass) VALUES (:email, :username, :hash_pass)');
            $result = $stmt->execute(['email' => $this->email, 'username' => $this->username, 'hash_pass' => $this->hashPass]);

            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
    }

    // Funkcja pomocnicza: wyświetl dane

    public function info()
    {
        echo $this->getId() . "\n";
        echo $this->getUsername() . "\n";
        echo $this->getEmail() . "\n";
        echo $this->getHashPass() . "\n";
    }
}


// Testy

$user = new User();
$user->setUsername('TestUser');
$user->setEmail('testmail@o2.pl');
$user->setPassword('Supertajnehaslo123');
$user->info();
$user->saveToDB($conn); // jest w bazie - OK!

