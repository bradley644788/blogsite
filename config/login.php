<?php
// start the session to access session and include database connection file
session_start();
require_once __DIR__ . '\MySQL.php';
 
// check if the request is a POST request (login form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and trim the email/username and password inputs
    $input = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
 
    // ensure both fields are filled in
    if (empty($input) || empty($password)) {
        $_SESSION['error'] = "Please enter your email/username and password.";
        header("Location: ../login.php");
        exit;
    }
 
    // determine whether the input is an email or a username
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        // prepare query to find user by email
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    } else {
        // prepare query to find user by username
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    }
 
    // bind the input parameter to the prepared statement
    $stmt->bind_param("s", $input);

    // execute the query
    $stmt->execute();

    // retrieve the query result
    $result = $stmt->get_result();
 
    // handle case where no matching user is found
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "No account found with that username or email.";
        header("Location: ../login.php");
        exit;
    }
 
    // fetch the user's data from the database
    $user = $result->fetch_assoc();
 
    // verify the provided password against the stored hashed password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Incorrect password.";
        header("Location: ../login.php");
        exit;
    }
 
    // store user information in the session upon successful login
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
 
    // redirect the user to the homepage after successful login
    header("Location: ../index.php");
    exit;
}
