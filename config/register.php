<?php
// Include the database connection
require_once __DIR__ . '\MySQL.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely receive data
    $username = trim($_POST['username'] ?? '');
    echo $username;
    $email = trim($_POST['email'] ?? '');
    echo $email;
    $password = trim($_POST['password'] ?? '');
    echo $password;

    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
 
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        echo "Username must be 3–20 characters long and contain only letters, numbers, or underscores.";
        exit;
    }

    // check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows > 0) {
        echo "Username already taken!";
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
 
    // check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows > 0) {
        echo "Email already registered!";
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
 
    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
 
    if ($stmt->execute()) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        header("Location: ../login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
 
    $stmt->close();
    $conn->close();
}
?>