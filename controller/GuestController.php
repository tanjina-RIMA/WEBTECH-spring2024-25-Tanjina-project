<?php
session_start();
require_once('../model/GuestModel.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $username = $_SESSION['user']['username'];
    $floor = trim($_POST['preference_floor']);
    $view = trim($_POST['preference_view']);
    $requests = trim($_POST['special_requests']);

    if (empty($floor) || empty($view) || empty($requests)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../view/guest.php");
        exit();
    }

    updateGuestPreferences($username, $floor, $view, $requests);
    header("Location: ../view/guest.php?updated=1");
    exit();
   $_SESSION['updated'] = true;
header("Location: ../view/guest_profile.php");
exit();
 
}
?>




