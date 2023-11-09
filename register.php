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
    <title>Online Viewing Of Payment | Create Account</title>
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
    <!--  -->
    <main>
        <section class="p-3">
            <div id="left">
                <h1>Online Viewing of Payment</h1>
                <p>Confidential statement of accounts of learners.</p>
            </div>
            <form action="./index.php" method="POST" enctype="multipart/form-data">
                <header class="mb-4">
                    <h4 class="h4">Create Account</h4>
                </header>
                <div>
                    <label for="">Profile photo</label>
                    <input type="hidden" name="profile-pic" id="binary-url-input" required>
                    <input type="file" name="" id="file-input" placeholder="Enter lastname" accept=".png, .jpg, .jpeg, .svg, .gif " required>
                </div>
                <div>
                    <label for="">Student No.</label>
                    <input type="text" name="student-id" id="" placeholder="Enter student ID" required>
                </div>
                <div>
                    <label for="">Firstname</label>
                    <input type="text" name="firstname" id="" placeholder="Enter student Firstname" required>
                </div>
                <div>
                    <label for="">Lastname</label>
                    <input type="text" name="lastname" id="" placeholder="Enter lastname" required>
                </div>
                <div>
                    <label for="">Middlename</label>
                    <input type="text" name="middlename" id="" placeholder="Enter middlename" required>
                </div>
              
                <div>
                    <label for="">Year/Section</label>
                    <input type="text" name="year-section" id="" placeholder="Example: ACT-1" required>
                </div>
                <div>
                    <label for="">Address</label>
                    <input type="text" name="address" id="" placeholder="Student Address" required>
                </div>
                <div>
                    <label for="">Email</label>
                    <input type="text" name="email" id="" placeholder="Enter active email" required>
                </div>
                <div>
                    <label for="">Password</label>
                    <input type="password" name="password" id="" placeholder="Create password" required>
                </div>
                <input type="submit" value="Create Account" name="create-student-account">
                <div class="d-flex divider">
                    <hr>
                    <p>Or</p>
                    <hr>
                </div>
                <a href="./login.php">Log in</a>
            </form>
        </section>
    </main>
    <script src="./js/profile-pic-picking.js"></script>
</body>
</html>