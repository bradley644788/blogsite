<?php
// start the session to access session and include database connection file
session_start();
require_once __DIR__ . '\MySQL.php';

// get post ID from the URL, null if not provided
$post_id = $_GET['post_id'] ?? null;
 
// validate that a valid numeric post ID was provided
if (!$post_id || !is_numeric($post_id)) {
    die("Invalid post ID.");
}
 
/* comment submission */

// check if the request is a POST request (comment submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    // ensure the user is logged in before allowing comments
    if (!isset($_SESSION['username'])) {
        echo "You must be signed into an account before submitting a comment.";
        exit;
    }
 
    // trim whitespace from the submitted comment
    $comment = trim($_POST['comment']);

    // ensure comment is not empty
    if (empty($comment)) {
        die("Comment must contain text.");
    }
 
    // prepare sql statement to insert the comment
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");

    // bind everything securely
    $stmt->bind_param("iis", $post_id, $_SESSION['user_id'], $comment);

    // execute the insert query
    $stmt->execute();

    // close statement
    $stmt->close();
 
    echo "success";
    exit;
}
 
/* grab comments */

// prepare sql query to fetch comments and usernames
$stmt = $conn->prepare("
    SELECT comments.*, users.username
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE post_id = ?
    ORDER BY created_at DESC
");

// bind the post ID parameter
$stmt->bind_param("i", $post_id);

// execute the query
$stmt->execute();

// get the result set
$result = $stmt->get_result();
 
// initialise an array to store comments
$comments = [];
 
// fetch each comment row as an associated array
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
 
// output comments as JSON
echo json_encode($comments);

// close the prepared statement
$stmt->close();
?>
