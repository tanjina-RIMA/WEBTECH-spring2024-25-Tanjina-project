<?php
include('../includes/db.php');

function getAllAmenities() {
    global $conn;
    $sql = "SELECT * FROM amenities_list";
    $result = $conn->query($sql);
    $amenities = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $amenities[] = $row;
        }
    }

    return $amenities;
}
?>
