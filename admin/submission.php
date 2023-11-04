<?php
// Intialize session
session_start();

// Connection
require("../config.php");

// User class
require("../includes/Student.php");
require("../includes/System.php");

// Initilize Classes
$system = new System($connection);
$student = new Student($connection);

// Components
require("../components/navigation.php");


// --------------  Get Student List -------
if(isset($_GET["get-student-list"])){
    $page = $_GET["page"];
    $max= 5;
    $offset = ($page * $max) - $max;

    try{
        $students = $student->getStudents($offset, $max);
        echo json_encode([
            "err" => false,
            "data" => $students
        ]);
    }catch(Exception $err){
        echo json_encode([
            "err" => true,
            "data" => null
        ]);
    }
    die();
}

// --------------  Search Students -------
if(isset($_GET["search-student"])){
    try{
        $students = $student->searchStudents($_GET["search-student"]);
        echo json_encode([
            "err" => false,
            "data" => $students
        ]);
    }catch(Exception $err){
        echo json_encode([
            "err" => true,
            "data" => null
        ]);
    }
    die();
}

// --------- Get Student Data --------
if(isset($_GET["get-student-data"])){
    try{
        echo json_encode([
            "err" => false,
            "data" => $student->getStudentData($_GET["get-student-data"])
        ]); 
    }catch(Exception $err){
        echo json_encode([
            "err" => true,
            "data" => null,
        ]); 
    }
    die();
}

// --------- Add / update charges details --------
if(isset($_POST["update-charges-detail"])){
    $charges_registration_fee = $system->cleanInput($_POST["charges-registration-fee"]);
    $charges_tuition_fee = $system->cleanInput($_POST["charges-tuition-fee"]);
    $charges_laboratory_fee = $system->cleanInput($_POST["charges-laboratory-fee"]);
    $charges_miscelleneous_fee = $system->cleanInput($_POST["charges-miscelleneous-fee"]);
    $charges_others_fee = $system->cleanInput($_POST["charges-others-fee"]);
    $payment_date_input = $system->cleanInput($_POST["payment-date-input"]);
    $student_id  = $system->cleanInput($_POST["student-number"]);

    try{
        $student->updateChargesDetails($student_id, $charges_registration_fee, $charges_tuition_fee, $charges_laboratory_fee, $charges_miscelleneous_fee, $charges_others_fee, $payment_date_input);
        $_SESSION["err"] = [
            "err"=> false,
            "msg"=> "Changes successfuly updated!"
        ];
        
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Someting went wrong!"
        ];
    }
    header("Location:".$_SERVER["HTTP_REFERER"]);
    exit();
    die();
}

// --------- Delete student account --------
if(isset($_GET["delete_student"])){
    $student_id = $_GET["delete_student"];
    
    try{
        $student->delete($student_id);
        $_SESSION["err"] = [
            "err"=> false,
            "msg"=> $student_id." successfuly deleted!"
        ];

    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Something went wrong!"
        ];
    }
    header("Location:".$_SERVER["HTTP_REFERER"]);
    exit();
    die();
}

// --------- Update student account --------
if(isset($_POST["update-student-account"])){
    $student_id = $system->cleanInput($_POST["student-id"]);
    $firstname = $system->cleanInput($_POST["firstname"]);
    $lastname = $system->cleanInput($_POST["lastname"]);
    $middlename = $system->cleanInput($_POST["middlename"]);
    $profile_pic = $system->cleanInput($_POST["profile-pic"]);
    $year_section = $system->cleanInput($_POST["year-section"]);
    $email = $system->cleanInput($_POST["email"]);
    $address = $system->cleanInput($_POST["address"]);
    $password= $system->cleanInput($_POST["password"]);

    echo $student_id;
    try{
        $student->update($student_id, $firstname, $lastname, $middlename, $profile_pic, $address, $email, $year_section, $password);
        $_SESSION["err"] = [
            "err"=> false,
            "msg"=> $student_id." successfuly updated"
        ];
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Something went wrong!"
        ];
    }
    header("Location:".$_SERVER["HTTP_REFERER"]);
    exit();
    die();
}

// ---------  Add payment--------
if(isset($_GET["add-payment"])){
    $student_id = $_GET["add-payment"];
    $or = $_GET["or"];
    $amount = $_GET["amount"];
    $date = $_GET["date"];

    try{
        $total_paid = $student->addPayment($student_id, $amount, $or, $date);

        echo json_encode([
            "err" => false,
            "total_paid" => $total_paid
        ]);
    }catch(Exception $err){
        echo json_encode([
            "err" => true,
            "total_paid" => null
        ]);
    }
    die();
}

// ---------  Remove payment--------
if(isset($_GET["remove-payment"])){
    $target_or = $_GET["remove-payment"]; 

    try{
        $total_paid = $student->deletePaymentRecord($target_or);

        echo json_encode([
            "err" => false,
            "total_paid" => $total_paid
        ]);
    }catch(Exception $err){
        echo json_encode([
            "err" => true,
            "total_paid" => null
        ]);
    }
    die();
}


// ---------  Remove payment--------
if(isset($_POST["update-admin"])){
    $username = $system->cleanInput($_POST["username"]);
    $password = $system->cleanInput($_POST["password"]);

    try{
        $system->updateAdmin($username, $password);
        $_SESSION["err"] = [
            "err"=> false,
            "msg"=> "Admin account updated!"
        ];
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Something went wrong!"
        ];
    }
    header("Location:".$_SERVER["HTTP_REFERER"]);
    die();
}


// ---------  Remove payment--------
if(isset($_POST["admin-login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    try{
        $system->adminLogin($username, $password);
        header("Location:./?c=dashboard");
        exit();
    }catch(Exception $err){
        $_SESSION["err"] = [
            "err"=> true,
            "msg"=> "Incorrect username or password!"
        ];
        header("Location:".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

// ---------  Remove payment--------
if(isset($_GET["admin-logout"])){
    setcookie("admin", 1, time() - 100, "/");
    header("Location:./login.php");
    die();
}