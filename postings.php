<?php

session_start();

require_once('connection.php');

function getPostings() {
    global $conn;

    if(isset($_SESSION['user'])) {
        $applicantId = $_SESSION['user'];
    } else {
        $applicantId = null;
    }

    $sql = "SELECT JobPosting.id as 'id', title, name, role_type, state
        from Movie join MovieCharacter on Movie.id = MovieCharacter.movie
        join JobPosting on JobPosting.movie_character = MovieCharacter.id
        join Location on JobPosting.location = Location.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0){
        while($row) {
            echo "<tr><td>". $row["title"] . "</td><td>". $row["name"] . "</td><td>". $row["role_type"] . "</td><td>". $row["state"] . "</td>"; 
            echo "<td><a href='apply.php?aid=". $applicantId . "&jid=". $row["id"] . "'</a>Apply</td>";
            echo "<td><a href='favorite.php?aid=". $applicantId . "&jid=". $row["id"] . "'</a>Favorite</td></tr>";

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        echo "</table>";
    } else{
        echo "0 result";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />

    <script src="js/scripts.js"></script>

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
                    <li><a href="about.php">About</a></li>
                    <li class="current"><a href="postings.php">Postings</a></li>
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
        <table class="postings-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="45%">
            <tr>
                <th>Movie Title</th>
                <th>Character</th>
                <th>Role Type</th>
                <th>Location</th>
                <th>Action</th>
            </tr>

            <?php getPostings() ?>
            
        </table>
    </section>
    <footer>
        <p>Casting, Copyright &copy; 2020</p>
    </footer>
</body>

</html>




















