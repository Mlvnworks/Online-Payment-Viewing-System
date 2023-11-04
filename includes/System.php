<?php

class System {
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    // Clean and return input
    function cleanInput($input){
        // Clean the input to prevent SQL injection
        $cleanInput = mysqli_real_escape_string($this->connection, $input);
        
        // Return the cleaned input
        return $cleanInput;
    }

    function studenIsLogin($sid){
        // Check if theres stored in cookie
        if(!isset($_COOKIE["sid"])) return false;
        // if current id is exists in database
        $is_exist = $this->connection->query("SELECT 1 FROM student WHERE student_id = '$sid'")->num_rows;
        if($is_exist <= 0) return false;
        
        // return true if nothing was wrong
        return true;
    }

    function logoutStudent(){
        setcookie("sid", 0, time() -100, "/");
    }

    function updateAdmin($username, $password){
        if($password === ""){
            $this->connection->query("
                UPDATE admin SET username = '$username'
                WHERE admin_id = 1;
            ");
        }else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $this->connection->query("
                UPDATE admin SET username = '$username',
                                password = '$hashed_password'
                WHERE admin_id = 1;
            ");
        }
    }

    function getAdmin(){
        return $this->connection->query("
            SELECT username FROM admin WHERE admin_id = 1
        ")->fetch_assoc()["username"];
    }

    function adminLogin($username, $password){
        $admin = $this->connection->query("
                SELECT * FROM admin WHERE username = '$username'
        ");

        if($admin->num_rows > 0){
            if(password_verify($password, $admin->fetch_assoc()["password"])){
                setcookie("admin", true, time() + (60 * 60 * 24 * 7), "/");
            }else{
                throw new Exception("");
            }
        }else{
            throw new Exception("");
        };
    }
}
