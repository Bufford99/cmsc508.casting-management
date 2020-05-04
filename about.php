<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/about.css" />

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
                    <li><a href="index.php">Home</a></li>
                    <li class="current"><a href="about.php">About</a></li>
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
        <div id="about-comp">
            <h3 id="about-heading">Who is NameCasting?</h3>
            <p>Company x seeks to provide aspiring actors and prospective employers a medium in which they can view and apply for various movie roles. It is our mission to help aspiring actors takes the first step in achieving their dreams. Start your carrer in Hollywood today!</p>
        </div>
    </section>
    <footer>
        <p>Casting, Copyright &copy; 2020</p>
    </footer>
</body>