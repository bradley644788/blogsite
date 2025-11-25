<?php
session_start();
require_once __DIR__ . '\config\MySQL.php';
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
            <section class="grid layout-column-3">
                <?php
                $sql = "
                SELECT posts.*, users.username AS author_name
                FROM posts
                LEFT JOIN users ON posts.author_id = users.id
                ORDER BY date_posted DESC";
                
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        $url = "blog.php?id={$post['id']}";
                        $author = $post['author_name'];
                        ?>
                        <article class="grid card">
                            <img src="<?php echo htmlspecialchars($post['image_url'])?> " alt="" class="full-width">
                            <h2><?php echo htmlspecialchars($post['title'])?></h2>
                            <p><?php echo htmlspecialchars($post['excerpt'])?></p>
                            <a href="<?php echo $url; ?>">Read More</a>
                        </article> 
                        <?php
                    } 
                } else {
                    echo "<p>No posts found.</p>";
                }
                ?>
            </section>
        </main>
    </body>
</html>