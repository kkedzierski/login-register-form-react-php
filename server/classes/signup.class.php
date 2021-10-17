<?php

class SignUp extends Dbh{

    protected function setUser($username, $email, $password){
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?);';
        $statement = $this->connect()->prepare($sql);
        $hasedPwd = password_hash($password, PASSWORD_DEFAULT);
        if(!$statement->execute(array($username, $email, $hasedPwd))){
            $statement = null;
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=statmentFailed');
            exit();
        }
        $statement = null;
    }
    
    protected function checkUser($username, $email){
        $sql = 'SELECT username FROM users WHERE username = ? OR email = ?;';
        $statement = $this->connect()->prepare($sql);
        if(!$statement->execute(array($username, $email))){
            $statement = null;
            header('location: '. $_SERVER['HTTP_REFERER'] . '?error=statmentFailed');
            exit();
        }
        
        if($statement->rowCount() > 0){
            return true;
        }
        return false;
    }

}