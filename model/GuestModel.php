<?php
function connectDB() {
    return new mysqli("localhost", "root", "", "hotel");
}

function getGuestData($username) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM guests WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateGuestPreferences($username, $floor, $view, $requests) {
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE guests SET preference_floor=?, preference_view=?, special_requests=? WHERE username=?");
    $stmt->bind_param("ssss", $floor, $view, $requests, $username);
    $stmt->execute();
}

