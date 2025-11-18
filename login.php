<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Sans:wght@200..800&display=swap" rel="stylesheet">
        <title>login | techblog</title>
    </head>

    <body class="grid">
        <header>
            <div class="wrapper">
                <h1> <a href="index.php">techblog</a> </h1>
            </div>
        </header>

        <main class="grid wrapper">
            <article class="grid card">
                <h2>Login</h2>
                <p>Don't have an account? <a href="register.php">Register here!</a> </p>

                <form action="config/login.php" class="grid" method="POST">
                    <label for="email">[@] Email</label>
                    <input type="text" id="email" name="email" placeholder="Email">
                    <label for="password">[*] Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <button type="submit">Login</button>
                </form> 
            </article>
        </main>
    </body>
</html>