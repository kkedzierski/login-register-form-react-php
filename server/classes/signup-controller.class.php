<?php

class SignUpController extends SignUp{
    
    

    private $username;
    private $email;
    private $password;
    private $password2;

    public function __construct($username, $email, $password, $password2){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;
    }

    public function signUpUser(){

        if($this->emptyInput()){
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=emptyInput');
            exit();
        }
        if(!$this->invalidUsername()){
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=invalidUsername');
            exit();
        }
        if(!$this->invalidEmail()){
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=invalidemail');
            exit();
        }
        if(!$this->passwordMatch()){
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=passwordsNotMatch');
            exit();
        }
        if($this->userExists()){
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=userExists');
            exit();
        }

        $this->setUser($this->username, $this->email, $this->password);

    }

    private function emptyInput(){
        if(empty($this->username) || empty($this->email) || empty($this->password) || empty($this->password2)){
            return true;
        }
        return false;
    }

    private function invalidUsername(){
        if(!preg_match("/([a-zA-Z0-9])/", $this->username)){
            return false;
        }
        return true;
    }

    private function invalidEmail(){
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }

    public function passwordMatch(){
        if($this->password !== $this->password2){
            return false;
        }
        return true;
    }

    private function userExists(){
        if($this->checkUser($this->username, $this->email)){
            return true;
        }
        return false;
    }

}