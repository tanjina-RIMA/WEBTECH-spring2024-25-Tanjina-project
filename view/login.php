<?php include('../includes/header.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
   
</head>
<body>
<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-image: url("../images/HOTEL.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    min-height: 100vh;
}
</style>



<div class="login-wrapper">
    <div class="login-box">
        <h2>Login</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form method="POST" action="../controller/AuthController.php">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
