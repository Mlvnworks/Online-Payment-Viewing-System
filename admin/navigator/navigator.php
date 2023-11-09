<?php
    if(!isset($_COOKIE["admin"])){
        header("Location:./?admin-logout=1");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap link style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Custom styling -->
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="./style/main.css">
    <link rel="stylesheet" href="./style/dashboard.css">
    <link rel="stylesheet" href="./style/payment-form.css">
    <link rel="stylesheet" href="./style/loadingbar.css">
    <link rel="stylesheet" href="../style/err-alert.css">
    <link rel="stylesheet" href="./style/update-student-modal.css">
    <link rel="stylesheet" href="./style/account.css">

    <title>Online Payment viewing | Admin</title>
</head>
<body>
    <!-- modals -->
    <!-- Err modal -->
    <?php
        require("../components/err-alert.php");
        if(isset($_SESSION["err"])){
            echo showAlert($_SESSION["err"]);
            session_destroy();
        }
    ?>
    <!-- Payment Update student modal -->
    <?php include "../components/student-update-modal.html" ?>
    <!-- Payment form modal -->
    <?php include "../components/payment-form.html" ?>
    <!-- Loading modal -->
    <?php include "../components/loading.html" ?>
    <??>
    <!-- Navigation -->
    <?php echo navigation($content, "Admin") ?>

    <!-- Content -->
    <main>
        <?php require("./pages/$content.php") ?>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>