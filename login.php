<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Login</title>
    </head>

    <body class="grid">
        <header>
            <div class="wrapper">
                <h1>techblog</h1>
            </div>
        </header>

        <main class="wrapper grid">
            <section class="card grid">
                <h2>Login</h2>
                <hr>
                <p>Don't have an account? <a href="register.php">Register here</a> </p>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </p>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="config/login.php" class="flex" method="POST">
                    <div class="flex ai-c">
                        <label for="email">[@] Email</label>
                        <input type="text" id="email" name="email" placeholder="Email">
                    </div>

                    <div class="flex ai-c">
                        <label for="password">[*] Password</label>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>

                    <button type="submit">Login</button>
                </form> 
            </section>
        </main>
    </body>
</html>