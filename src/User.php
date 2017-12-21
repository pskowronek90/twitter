<?php

class User
{
    private $id;
    private $username;
    private $hashPass;
    private $email;

    public function __construct()
    {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashPass = "";
    }
}