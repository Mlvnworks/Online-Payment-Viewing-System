<section id="update-admin-form">
    <form action="./index.php" method="POST">
        <header>
            <h2 class="h2">Update admin account</h2>
        </header>
        <div>
            <label for="">Username</label>
            <input type="text" placeholder="Enter new username" name="username" id="" value="<?= $system->getAdmin() ?>">
        </div>
        <div>
            <label for="">Password</label>
            <input type="password" placeholder="Enter new password" name="password" id="">
        </div>
        <input type="submit" value="Update" name="update-admin">
    </form>
</section>