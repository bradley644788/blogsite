<?php
session_start();
require_once __DIR__ . '\MySQL.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
 
    if (empty($input) || empty($password)) {
        $_SESSION['error'] = "Please enter your email/username and password.";
        header("Location: ../login.php");
        exit;
    }
 
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    }
 
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "No account found with that username or email.";
        header("Location: ../login.php");
        exit;
    }
 
    $user = $result->fetch_assoc();
 
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Incorrect password.";
        header("Location: ../login.php");
        exit;
    }
 
    // success
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
 
    header("Location: ../index.php");
    exit;
}