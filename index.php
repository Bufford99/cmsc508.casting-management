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
                            echo '<li><a href="profile.php">Profile</a></li>';
                        } else {
                            echo '<li><a href="login.html">Login</a></li>';
                        }
                    ?>
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
                    <select class="state-list">
                        <option value="" disabled selected hidden>Select a state..</option>
                        <option value="1">AL</option>
                        <option value="2">AK</option>
                        <option value="3">AZ</option>
                        <option value="4">AR</option>
                        <option value="5">CA</option>
                        <option value="6">CO</option>
                        <option value="7">CT</option>
                        <option value="8">DE</option>
                        <option value="9">FL</option>
                        <option value="10">GA</option>
                        <option value="11">HI</option>
                        <option value="12">ID</option>
                        <option value="13">IL</option>
                        <option value="14">IN</option>
                        <option value="15">IA</option>
                        <option value="16">KS</option>
                        <option value="17">KY</option>
                        <option value="18">LA</option>
                        <option value="19">ME</option>
                        <option value="20">MD</option>
                        <option value="21">MA</option>
                        <option value="22">MI</option>
                        <option value="23">MN</option>
                        <option value="24">MS</option>
                        <option value="25">MO</option>
                        <option value="26">MT</option>
                        <option value="27">NE</option>
                        <option value="28">NV</option>
                        <option value="29">NH</option>
                        <option value="30">NJ</option>
                        <option value="31">NM</option>
                        <option value="32">NY</option>
                        <option value="33">NC</option>
                        <option value="34">ND</option>
                        <option value="35">OH</option>
                        <option value="36">OK</option>
                        <option value="37">OR</option>
                        <option value="38">PA</option>
                        <option value="39">RI</option>
                        <option value="40">SC</option>
                        <option value="41">SD</option>
                        <option value="42">TN</option>
                        <option value="43">TX</option>
                        <option value="44">UT</option>
                        <option value="45">VT</option>
                        <option value="46">VA</option>
                        <option value="47">WA</option>
                        <option value="48">WV</option>
                        <option value="49">WI</option>
                        <option value="50">WY</option>
                    </select>
                    <select class="role-list">
                        <option value="" disabled selected hidden>Select a role type..</option>
                        <option value="1">Main</option>
                        <option value="2">Supporting</option>
                        <option value="3">Extra</option>
                    </select>
                </div>
            </form>
        </div>
    </section>
    <footer>
        <p>Acano Casting, Copyright &copy; 2020</p>
    </footer>
</body>

</html>