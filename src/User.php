<?php

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

    public function setPassword($newPass)
    {
        $newHashedPass = password_hash($newPass, PASSWORD_BCRYPT);
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

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Users(username, email, hash_pass) VALUES(:username, :email, :pass)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'pass' => $this->hashPass
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare('UPDATE Users SET email=:email, username=:username, hash_pass=:hash_pass WHERE  id=:id ');
            $result = $stmt->execute([
                'email' => $this->email,
                'username' => $this->username,
                'hash_pass' => $this->hashPass,
                'id' => $this->id
            ]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    // Wczytanie obiektu do bazy

    static public function loadUserById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Users WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    // Wczytywanie wielu obiektów

    static public function loadAllUsers(PDO $conn)
    {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashPass = $row['hash_pass'];
                $loadedUser->email = $row['email'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    // Usuwanie usera

    public function delete(PDO $conn)
    {
        if ($this->id != -1) {
            $stmt = $conn->prepare('DELETE FROM Users WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

    // Logowanie

    static public function login(PDO $conn, $email, $passFromUser)
    {
        $user = User::loadUserByEmail($conn, $email);
        if ($user !== null && password_verify($passFromUser, $user->getPassword()) == $passFromUser) {
            return $user;
        } else {
            return false;
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

# Testy

////// Zapis usera - 1
////
////$user = new User();
////$user->setUsername('TestUser');
////$user->setEmail('testmail@o2.pl');
////$user->setPassword('Supertajnehaslo123');
////$user->info()."\n";
//////$user->saveToDB($conn); // jest w bazie - OK!
////
////// Zapis usera -2
////
//$user2 = new User();
//$user2->setUsername('NewUser222');
//$user2->setEmail('nsfsf22222sf@interia.pl');
//$user2->setPassword('Supertajnehaslo123');
//$user2->info()."\n";
//$user2->saveToDB($conn); // jest w bazie - OK!
////
////// Wczytanie usera z bazy
//
////print_r(User::loadUserById($conn, 1));
////
//////// Wczytanie wszystkich userów
////
////print_r(User::loadAllUsers($conn));
//
//
//// Update usera - str 41 w pdfie - poprawić później
//
//User::loadUserById($conn,2);
//$user2->setEmail("taki@wp.pl");
//$user2->setUsername('nowyUser333');
//$user2->setPassword('Nowehaslo');
//
//User::loadUserById($conn,2)












