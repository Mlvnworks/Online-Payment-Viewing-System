<?php

class Student{
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    // Create Student Account
    function createAccount(
        $student_id,
        $firstname,
        $lastname,
        $middlename,
        $profile_pic,
        $address,
        $email,
        $year_section,
        $password
    ){
        // Hash password input 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new record
        $this->connection->query("
            INSERT INTO `ovp_db`.`student`(`student_id`,`firstname`,`lastname`,`middle`,`profile_pic`,`address`,`email`,`year_section`,`password`)
            VALUES('$student_id','$firstname','$lastname','$middlename','$profile_pic','$address','$email','$year_section','$hashed_password');  
        ");
    }

    // Process student login and return student ID
    function login($student_id, $password){
        $is_exist = $this->connection->query("
            SELECT password FROM student WHERE student_id = '$student_id' 
        ");
        // Check number of rows
        if($is_exist->num_rows > 0){
            $password_hashed = $is_exist->fetch_assoc()["password"];
            if(password_verify($password, $password_hashed)){
                return true;
            }else{
                throw new Exception("Account not found.");
            }
        }else{
            throw new Exception("Account not found.");
        }
    }

    // Get Student Lists
    function getStudents($offset, $limit){
        $students = [];
        $get_students = $this->connection->query("
            SELECT * FROM student 
            ORDER BY firstname ASC
            LIMIT $limit
            OFFSET $offset
        ");

        while($row = $get_students->fetch_assoc()){
            $students = [ $row, ...$students];
        }

        return $students;
    }

    function searchStudents($keyword){
        $students = [];
        $get_students = $this->connection->query("
            SELECT * FROM student 
            WHERE CONCAT(student_id, firstname, lastname, middle) LIKE '%$keyword%'
            ORDER BY firstname ASC
        ");

        while($row = $get_students->fetch_assoc()){
            $students = [ $row, ...$students];
        }

        return $students;
    }

    // Get student Data
    function getStudentData($sid){
        $payments = [];
        $get_payment = $this->connection->query("
            SELECT * FROM payments WHERE student_id = '$sid' ORDER BY payment_id;
        ");
        $total_paid = $this->connection->query("
            SELECT SUM(amount) as total_paid FROM payments WHERE student_id = '$sid';
        ")->fetch_assoc()["total_paid"];

        $charges = $this->connection->query("
            SELECT *, (registration_fee + tuition_fee + miscelleneous_fee + laboratory_fee + others_fee) as total FROM charges WHERE student_id = '$sid'
        ")->fetch_assoc();

        while($row = $get_payment->fetch_assoc()){
            $payments = [...$payments, $row];
        }

        return [
                "data" => $this->connection->query("
                    SELECT * FROM student 
                    WHERE student_id = '$sid'
                ")->fetch_assoc(),
                "charges" => $charges,
                "payments" => $payments,
                "total_paid" => (!$total_paid ? 0 : $total_paid * 1),
                "total_balance" => (!$charges ? 0 : $charges["total"] * 1 ) - (!$total_paid ? 0 : $total_paid * 1)
        ];
    }

    function updateChargesDetails(
        $student_id, 
        $registration_fee,
        $tuition_fee, 
        $laboratory_fee, 
        $miscelleneous_fee, 
        $others_fee, 
        $date
    ){
        // Check if charges details aleready exist
        if($this->connection->query("SELECT 1 FROM charges WHERE student_id = '$student_id'")->num_rows > 0){
            $this->connection->query("
                UPDATE charges SET registration_fee = $registration_fee,
                                    tuition_fee = $tuition_fee,
                                    laboratory_fee = $laboratory_fee,
                                    miscelleneous_fee = $miscelleneous_fee,
                                    others_fee = $others_fee,
                                    date = '$date'
            ");
        }else{
            $this->connection->query("
                INSERT INTO charges (student_id, registration_fee, tuition_fee, laboratory_fee, miscelleneous_fee, others_fee, date)
                VALUES('$student_id', $registration_fee,$tuition_fee,$laboratory_fee,$miscelleneous_fee,$others_fee, '$date');
            ");
        }
    } 

    function delete($sid){
        $this->connection->query("
            DELETE FROM payments WHERE student_id = '$sid';
        ");

        $this->connection->query("
            DELETE FROM charges WHERE student_id = '$sid';
        ");
        $this->connection->query("
            DELETE FROM student WHERE student_id = '$sid';
        ");
    }

    function update(
        $student_id,
        $firstname,
        $lastname,
        $middlename,
        $profile_pic,
        $address,
        $email,
        $year_section,
        $password
    ){
        if($password !== ""){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $this->connection->query("
                UPDATE student SET firstname = '$firstname',
                                    lastname = '$lastname',
                                    middle = '$middlename',
                                    profile_pic = '$profile_pic',
                                    address = '$address',
                                    email = '$email',
                                    year_section = '$year_section',
                                    password = '$hashed_password'
                WHERE student_id = '$student_id';
            ");
        }else{
            $this->connection->query("
                UPDATE student SET firstname = '$firstname',
                                    lastname = '$lastname',
                                    middle = '$middlename',
                                    profile_pic = '$profile_pic',
                                    address = '$address',
                                    email = '$email',
                                    year_section = '$year_section'
                WHERE student_id = '$student_id';
            ");
        }
    }

    function addPayment($sid, $amount, $or, $date){
        $this->connection->query("
            INSERT INTO payments(student_id, payment_or, date, amount)
            VALUES('$sid', '$or',  '$date', $amount);
        ");
        return $this->connection->query("
            SELECT SUM(amount) as total_paid FROM payments WHERE student_id = '$sid';
        ")->fetch_assoc()["total_paid"];
    }

    function deletePaymentRecord($target_or){
        $student_id = $this->connection->query("
            SELECT student_id FROM payments WHERE payment_or = '$target_or';
        ")->fetch_assoc()["student_id"];

        $this->connection->query("
            DELETE FROM payments WHERE payment_or = '$target_or';
        ");

        return $this->connection->query("
            SELECT SUM(amount) as total_paid FROM payments WHERE student_id = '$student_id';
        ")->fetch_assoc()["total_paid"];
    }
}