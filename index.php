<?php

session_start();

require_once('connection.php');

function getApplications() {
    global $conn;

    if(isset($_SESSION['user'])) {
        $application_id = $_SESSION['user'];

        $sql = "SELECT mc.name AS 'movie_character', mv.title AS 'movie_title', a.status AS 'status'
            FROM Application a JOIN JobPosting j ON a.job_posting = j.id
            JOIN MovieCharacter mc ON j.movie_character = mc.id
            JOIN Movie mv ON mc.movie = mv.id
            WHERE a.owner = :aid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':aid', $application_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            echo '<div>';
            echo '<table style="width: 40%">';
            echo '<tr>';
            echo '<th align="left">Character</th>';
            echo '<th align="left">Movie</th>';
            echo '<th align="left">Status</th>';

            while ($row) {
                echo '<tr>';
                echo '<td>'.$row['movie_character'].'</td>';
                echo '<td>'.$row['movie_title'].'</td>';
                echo '<td>'.$row['status'].'</td>';
                echo '</tr>';

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            echo '</table>';
            echo '</div>';
        }
    }
}

function getFavorites() {
    global $conn;

    if(isset($_SESSION['user'])) {
        $application_id = $_SESSION['user'];

        $sql = "SELECT mc.name AS 'movie_character', mv.title AS 'movie_title'
            FROM Favorite f JOIN JobPosting j ON f.job_posting = j.id
            JOIN MovieCharacter mc ON j.movie_character = mc.id
            JOIN Movie mv ON mc.movie = mv.id
            WHERE f.owner = :aid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':aid', $application_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            echo '<div>';
            echo '<table style="width: 40%; position: absolute; top: 200px;">';
            echo '<tr>';
            echo '<th align="left">Character</th>';
            echo '<th align="left">Movie</th>';

            while ($row) {
                echo '<tr>';
                echo '<td>'.$row['movie_character'].'</td>';
                echo '<td>'.$row['movie_title'].'</td>';
                echo '</tr>';

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            echo '</table>';
            echo '</div>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>508 | Welcome</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/index.css" />

    <style>
        table {
            position: absolute;
        }
        table, td {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: #fff;
        }
    </style>

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
            <?php getApplications() ?>
            <?php getFavorites() ?>
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