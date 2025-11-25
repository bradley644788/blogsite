<?php
session_start();
require_once __DIR__ . '\config\MySQL.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo "Invalid Post ID.";
}

$stmt = $conn->prepare("
    SELECT posts.*, users.username AS author_name
    FROM posts
    JOIN users ON posts.author_id = users.id
    WHERE posts.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Post not found.";
    exit;
}

$post = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Sans:wght@200..800&display=swap" rel="stylesheet">
        <title>techblog</title>
    </head>

    <body class="grid">
        <header>
            <div class="flex wrapper">
                <h1> <a href="index.php">techblog</a> </h1>
                <?php if (isset($_SESSION['username'])) {?>
                        <a href="./config/logout.php" class="button">Log out</a>
                        <?php
                    } else {
                        ?>
                        <a href="login.php">Login</a>
                        <?php
                    }
                ?>
            </div>
        </header>

        <main class="grid wrapper">
            <section class="grid">
                <article class="grid card">
                    <img src="<?php echo htmlspecialchars($post['image_url'])?> " alt="" class="full-width">
                    <h1><?php echo htmlspecialchars($post['title'])?></h1>
                    <p><?php echo htmlspecialchars($post['content'])?></p>
                </section>

                <section class="grid card comments">
                    <h2>Comments</h2>

                    <section class="grid">
                        <section class="flex">
                            <textarea type="text" id="comment-text" class="fg-1"></textarea>
                            <button onclick="submitComment()">Comment</button>
                        </section>

                        <section id="comments-container" class="grid">

                        </section>
                    </section>
                </section>
            </section>
        </main>
        
        <script>
            function onJumpToTitle(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            }
        </script>

        <script>
            function loadComments() {
            fetch("./config/comment.php?post_id=<?php echo $id; ?>")
                .then(res => res.json())
                .then(data => {
                let container = document.getElementById("comments-container");
                container.innerHTML = "";
        
                if (data.length === 0) {
                    container.innerHTML = "<p>No comments yet.</p>";
                    return;
                }
        
                data.forEach(comment => {
                    container.innerHTML += `
                    <section class="grid">
                        <section class="flex ai-b">
                            <h3>${comment.username}</h3>
                            <span>${new Date(comment.created_at).toLocaleString()}</span>
                        </section>
                        <p>${comment.comment_text}</p>
                    </section>
                    `;
                });
                });
            }
        
            function submitComment() {
            let text = document.getElementById("comment-text").value;
        
            if (text.trim() === "") {
                alert("Comment cannot be empty.");
                return;
            }
        
            fetch("./config/comment.php?post_id=<?php echo $id; ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "comment=" + encodeURIComponent(text)
            })
                .then(res => res.text())
                .then(data => {
                if (data === "success") {
                    document.getElementById("comment-text").value = "";
                    loadComments(); // refresh comment list
                } else {
                    alert(data);
                }
                });
            }
        
            loadComments();
        </script>
    </body>
</html>