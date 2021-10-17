<?php

class Dbh{

    protected function connect(){
        try {
            $username = "root";
            $password = "";
            $host = "localhost";
            $dbname = "register_login_form";
            $dbh = new PDO('mysql:host='.$host.';dbname='.$dbname.';', $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }
}