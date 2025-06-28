<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

include('../includes/header.php');
require_once('../model/GuestModel.php');
require_once('../model/amenitiesModel.php');

$username = $_SESSION['user']['username'] ?? '';
$guest = getGuestData($username);

$show_table = false;
$guest_table_data = [];

if (isset($_GET['updated']) && $guest) {
    $show_table = true;
    $guest_table_data = $guest;
}

// Reset input fields to blank for form (do not pre-fill)
$preference_floor = '';
$preference_view = '';
$special_requests = '';

$amenities = getAllAmenities();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guest Profile</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-container {
            width: 60%;
            margin: 0 auto;
            background: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-button {
            text-align: center;
        }
        .amenity-card {
            display: inline-block;
            width: 280px;
            height: 200px;
            margin: 15px;
            padding: 15px;
            color: white;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            vertical-align: top;
            position: relative;
            overflow: hidden;
        }
        .amenity-card > * {
            position: relative;
            z-index: 2;
        }
        .amenity-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            border-radius: 8px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" style="
      position: fixed;
      top: 15px;
      right: 20px;
      background: #dc3545;
      color: white;
      padding: 8px 14px;
      text-decoration: none;
      border-radius: 6px;
      z-index: 1000;
      font-weight: bold;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  ">Close</a>

<h2 style="text-align:center;">Guest Profile</h2>

<div class="form-container guest-box">
    <form method="POST" action="../controller/GuestController.php" class="guest-form">
        <div class="form-group">
            <label>Preferred Floor:</label>
            <input type="text" name="preference_floor" value="<?= htmlspecialchars($preference_floor) ?>" />
        </div>

        <div class="form-group">
            <label>Preferred View:</label>
            <input type="text" name="preference_view" value="<?= htmlspecialchars($preference_view) ?>" />
        </div>

        <div class="form-group">
            <label>Special Requests:</label>
            <textarea name="special_requests" rows="4"><?= htmlspecialchars($special_requests) ?></textarea>
        </div>

        <div class="form-button">
            <button type="submit" name="update">Save Preferences</button>
        </div>
    </form>
</div>

<?php if ($show_table && $guest_table_data): ?>
    <h3 style="text-align:center; margin-top:30px;">Saved Guest Information</h3>
    <table border="1" width="90%" style="margin: 20px auto; border-collapse: collapse; text-align:left;">
        <tr><th>Username</th><td><?= htmlspecialchars($guest_table_data['username']) ?></td></tr>
        <tr><th>Preferred Floor</th><td><?= htmlspecialchars($guest_table_data['preference_floor']) ?></td></tr>
        <tr><th>Preferred View</th><td><?= htmlspecialchars($guest_table_data['preference_view']) ?></td></tr>
        <tr><th>Special Requests</th><td><?= nl2br(htmlspecialchars($guest_table_data['special_requests'])) ?></td></tr>
        <tr><th>Loyalty Points</th><td><?= htmlspecialchars($guest_table_data['loyalty_points']) ?></td></tr>
    </table>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>
</body>
</html>
