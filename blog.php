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
            <div class="wrapper">
                <h1> <a href="index.php">techblog</a> </h1>
            </div>
        </header>

        <main class="grid wrapper">
            <section class="grid layout-blog">
                <section class="grid">
                    <nav class="grid card">
                        <h2>Contents</h2>
                        <ol>
                            <li> <button class="a" onclick="onJumpToTitle('1')">Lorem, ipsum.</button></li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                            <li> <a href="#">Lorem, ipsum.</a> </li>
                        </ol>
                    </nav>
                </section>

                <article class="grid card">
                    <img src="<?php echo htmlspecialchars($post['image_url'])?> " alt="" class="aspect-ratio-21_9">
                    <h1><?php echo htmlspecialchars($post['title'])?></h1>
                    <p><?php echo htmlspecialchars($post['content'])?></p>
                    <h2 id="1">Lorem ipsum dolor sit.</h2>
                    <h2 id="2">Introduction</h2>
                    <h2 id="3">Details</h2>
                    <h2 id="4">Conclusion</h2>
                    <!-- 
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum officiis possimus sint quisquam fugiat impedit. Architecto odio provident et, fuga sapiente saepe natus dignissimos repudiandae, veritatis earum, sequi ea est!</p>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore odio commodi blanditiis earum dignissimos, velit cum veritatis enim sunt libero aut eligendi tempore soluta necessitatibus aliquam laboriosam nostrum inventore ipsum delectus iste quidem accusamus sed minus. Distinctio vel voluptas adipisci vitae numquam nemo nisi iste non neque, et, voluptates facere quod? Voluptatem nobis doloribus doloremque magnam ipsum aliquam, fugiat veritatis. Cumque quas saepe quo.</p>
                    <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore voluptate non cumque!</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio laudantium recusandae corporis accusantium praesentium inventore voluptatem, aliquid necessitatibus cupiditate quos sint laborum vel reiciendis quaerat repellat aut quibusdam voluptatibus culpa, illo vitae in. Laboriosam minima odio dolorum, illo commodi, ipsam, vero modi et ullam eos ut molestias quos doloremque laborum doloribus. Rerum sapiente natus itaque praesentium voluptatum quia tempore inventore sint accusamus cum, accusantium quidem dolor, deserunt similique aliquam, nostrum eos ut quam placeat consequatur nihil minima eveniet! Ex voluptatem quod veritatis tempora itaque cumque corrupti debitis! Exercitationem veniam a veritatis ullam ipsam cupiditate eius quo. Quae autem in maiores numquam veniam perspiciatis qui culpa voluptatem esse aliquam quaerat omnis, aliquid eos vitae voluptas architecto ipsa fuga perferendis ut corporis iusto sint. Perferendis ullam necessitatibus quis expedita ducimus.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, repudiandae ducimus commodi rem, temporibus quaerat eius doloribus aut inventore architecto sapiente, asperiores fugiat. Vel excepturi at similique tenetur voluptates, adipisci debitis sunt accusantium accusamus a ab repudiandae obcaecati modi minus corporis saepe possimus quo non rem iure aspernatur animi iste porro! Ut quos quaerat maxime quasi vel, tempore eaque harum velit fuga magnam aliquam.</p> -->
                </article>
            </section>

            <section class="grid card comments">
                <h2>Comments</h2>

                <section class="grid">
                    <section class="grid layout-comment">
                        <img src="https://picsum.photos/80/80" alt="">
                        <h3>Lorem, ipsum.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil ipsum voluptatem hic earum explicabo incidunt ut tempora voluptatibus, ratione repellendus ab iste, dolorum, voluptate placeat quas nemo illo neque dolores.</p>
                    </section>

                    <section class="grid layout-comment">
                        <img src="https://picsum.photos/81/81" alt="">
                        <h3>Lorem, ipsum.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil ipsum voluptatem hic earum explicabo incidunt ut tempora voluptatibus, ratione repellendus ab iste, dolorum, voluptate placeat quas nemo illo neque dolores.</p>
                    </section>

                    <section class="grid layout-comment">
                        <img src="https://picsum.photos/82/82" alt="">
                        <h3>Lorem, ipsum.</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil ipsum voluptatem hic earum explicabo incidunt ut tempora voluptatibus, ratione repellendus ab iste, dolorum, voluptate placeat quas nemo illo neque dolores.</p>
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
    </body>
</html>