<?php
session_start();
require_once __DIR__ . '\MySQL.php'; // Make sure this creates $conn (mysqli object)

if (isset($_POST['submit_article'])) {
    // Collect and sanitize form data
    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $content = trim($_POST['content']);
    $image_url = trim($_POST['image_url']);
    
    // Example: assume author_id is stored in session
    $author_id = $_SESSION['user_id'] ?? 1; // default to 1 if session not set

    // Basic validation
    if (empty($title) || empty($content)) {
        echo "Title and content cannot be empty!";
    } else {
        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO posts (author_id, title, excerpt, content, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $author_id, $title, $excerpt, $content, $image_url);

        if ($stmt->execute()) {
            echo "Article submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
