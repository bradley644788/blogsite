<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Register</title>
    </head>

    <body class="grid">
        <header>
            <div class="wrapper">
                <h1>techblog</h1>
            </div>
        </header>

        <main class="wrapper grid">
            <section class="card grid">
                <h2>Register</h2>
                <hr>
                <p>Already have an account? <a href="login.php">Log in</a> </p>

                <form action="config/register.php" class="flex" method="POST">
                    <div class="flex ai-c">
                        <label for="email">[@] Email</label>
                        <input type="text" id="email" name="email" placeholder="Email">
                    </div>

                    <div class="flex ai-c">
                        <label for="email">[#] Username</label>
                        <input type="text" id="username" name="username" placeholder="Username">
                    </div>

                    <div class="flex ai-c">
                        <label for="password">[*] Password</label>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>

                    <button type="submit">Register</button>
                </form> 
            </section>
        </main>
    </body>
</html>