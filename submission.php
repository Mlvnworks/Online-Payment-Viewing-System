<?php
// Intialize session
session_start();

// Connection
require("./config.php");

// User class
require("./includes/Student.php");
require("./includes/System.php");

// Initilize Classes
$system = new System($connection);
$student = new Student($connection);

// Components
require("./components/navigation-student.php");

// ---------------- Logout Student Account ----------
if(isset($_GET["logout-student"])){
    $system->logoutStudent();
    header("Location:./login.php");
    exit();
    die();
}


// ---------------- Login to Student Account ----------
if(isset($_POST["student-login"])){
    $student_id = $_POST["student-id"];
    $password = $_POST["password"];
    try{
        $is_valid = $student -> login($student_id, $password);
        if($is_valid){
            // Store Student ID on cookie
            setcookie("sid", $student_id,time() +(60 * 60 * 24 * 7), "/");
            header("Location:./?c=dashboard");
        }
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> $err->getMessage()
        ];
        header("Location:".$_SERVER["HTTP_REFERER"]);
    }
    exit();
    die();
}

// ---------------- Create new Student Account ----------
if(isset($_POST["create-student-account"])){
    $student_id = $system->cleanInput($_POST["student-id"]);
    $firstname = $system->cleanInput($_POST["firstname"]);
    $lastname = $system->cleanInput($_POST["lastname"]);
    $middlename = $system->cleanInput($_POST["middlename"]);
    $profile_pic = $system->cleanInput($_POST["profile-pic"]);
    $year_section = $system->cleanInput($_POST["year-section"]);
    $email = $system->cleanInput($_POST["email"]);
    $address = $system->cleanInput($_POST["address"]);
    $password= $system->cleanInput($_POST["password"]);

    try{
        // Check duplicate student ID
        $duplicate = $connection->query("SELECT 1 FROM student WHERE student_id = '$student_id'")->num_rows;

        if($duplicate <= 0){
            // 
            $student->createAccount($student_id, $firstname, $lastname, $middlename, $profile_pic, $address, $email, $year_section, $password);

            $_SESSION["err"] = [
                "err"=> false,
                "msg"=> "Account successfuly created!"
            ];
            header("Location:./login.php");
            exit();
        }else{
            $_SESSION["err"] = [
                "err"=> true,
                "msg"=> "Student ID already exists!"
            ];
            header("Location:".$_SERVER["HTTP_REFERER"]);
            exit();
        }
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Failed to create an account."
        ];
        header("Location:". $_SERVER["HTTP_REFERER"]);
        exit();
    }
    die();
}

