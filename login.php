<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap link style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/entry.css">
    <link rel="stylesheet" href="./style/err-alert.css">
    <title>Online Viewing Of Payment | Log in</title>
</head>
<body>
    <!-- Err modal -->
    <?php
        require("./components/err-alert.php");
        if(isset($_SESSION["err"])){
            echo showAlert($_SESSION["err"]);
            session_destroy();
        }
    ?>
    <main>
        <section>
            
            <div id="left">
                <h1>Online Viewing of Payment</h1>
                <p>Confidential statement of accounts of learners.</p>
            </div>
            <form action="./index.php" method="POST">
                <header class="mb-4">
                    <h4 class="h4">Student Log in</h4>
                </header>
                <div>
                    <label for="">Student No.</label>
                    <input type="text" name="student-id" id="" placeholder="Enter student ID" required>
                </div>
                <div>
                    <label for="">Password</label>
                    <input type="password" name="password" id="" placeholder="Enter password" required>
                </div>
                <input type="submit" value="Log in" name="student-login">
                <div class="d-flex divider">
                    <hr>
                    <p>Or</p>
                    <hr>
                </div>
                <div class="d-flex justify-content-center gap-5">
                    <a href="./register.php" class="text-light">Create Account</a>
                    <a href="./admin/" class="text-light">Admin  &rarr;</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>