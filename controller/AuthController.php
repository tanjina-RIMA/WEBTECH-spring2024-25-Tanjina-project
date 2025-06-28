<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $default_pass_hash = password_hash("1234", PASSWORD_DEFAULT);
        $name = ucfirst($username);
        $insert_stmt = $conn->prepare("INSERT INTO users (username, password, name) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $username, $default_pass_hash, $name);
        $insert_stmt->execute();
        $insert_stmt->close();

        $stmt->execute();
        $result = $stmt->get_result();
    }

    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = ['username' => $user['username'], 'name' => $user['name']];
        
        // Add loyalty points or insert guest record
        $check = $conn->prepare("SELECT * FROM guests WHERE username = ?");
        $check->bind_param("s", $user['username']);
        $check->execute();
        $guest_result = $check->get_result();

        if ($guest_result->num_rows === 0) {
            $insert = $conn->prepare("INSERT INTO guests (username, loyalty_points) VALUES (?, 1)");
            $insert->bind_param("s", $user['username']);
            $insert->execute();
        } else {
            $update = $conn->prepare("UPDATE guests SET loyalty_points = loyalty_points + 1 WHERE username = ?");
            $update->bind_param("s", $user['username']);
            $update->execute();
        }
        
        header("Location: ../view/dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: ../view/login.php");
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: ../view/login.php");
    exit();
}



