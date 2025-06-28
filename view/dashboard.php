<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
?>
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


<div style="background-color: white; padding: 20px; border-radius: 10px; width: fit-content; margin: 20px auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; margin: 0;">Dashboard</h2>
    <p style="text-align:center; margin: 10px 0 0;">Welcome, <?= htmlspecialchars($_SESSION['user']['name']); ?>!</p>
</div>


<div style="display: flex; justify-content: center; gap: 20px; margin-top: 30px;">
    <a href="rooms.php">
        <button style="padding: 10px 20px; font-size: 16px;">Room Gallery</button>
    </a>
    <a href="amenities.php">
        <button style="padding: 10px 20px; font-size: 16px;">Amenities List</button>
    </a>
    <a href="guest.php">
        <button style="padding: 10px 20px; font-size: 16px;">Guest List</button>
    </a>
</div>

<?php include('../includes/footer.php'); ?>
