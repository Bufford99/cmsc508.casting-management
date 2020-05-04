<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>508 | Welcome</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/index.css" />

    <title>Casting Management</title>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Acano</span> Casting</h1>
            </div>
            <nav>
                <ul>
                    <li class="current"><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="postings.php">Postings</a></li>
                    <?php
                        if (isset($_SESSION['user'])) {
                            echo '<li><a href="logout.php"</a>Logout</li>';
                        } else {
                            echo '<li><a href="login.html">Login</a></li>';
                        }
                    ?>
                    <li><a href="profile.html">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="showcase">
        <div class="container">
            <form>
                <div class="box">
                    <button id="searchButton">Find my next role!</button>
                    <input type="text" placeholder="Location..." id="locationSearch">
                    <input type="text" placeholder="Role type..." id="rolesSearch">
                </div>
            </form>
        </div>
    </section>
    <footer>
        <p>Casting, Copyright &copy; 2020</p>
    </footer>
</body>

</html>