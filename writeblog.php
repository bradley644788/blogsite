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
            <section class="grid card">
                <h2>Construct Article</h2>
                    <form action="./config/submitarticle.php" method="post" class="grid">
                    <h2>Title</h2>
                    <textarea name="title" id="title"></textarea>

                    <h2>Excerpt</h2>
                    <textarea name="excerpt" id="excerpt"></textarea>

                    <h2>Content</h2>
                    <textarea name="content" id="content" style="min-height: 8lh"></textarea>

                    <h2>Image URL</h2>
                    <input type="text" name="image_url" id="image_url">

                    <button type="submit" name="submit_article">Submit Article</button>
                </form>      
            </section>
        </main>
    </body>
</html>