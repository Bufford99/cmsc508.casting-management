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
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li class="current"><a href="postings.php">Postings</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="showcase">
        <table class="postings-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="35%">
            <tr>
                <th>Movie Title</th>
                <th>Character</th>
                <th>Role Type</th>
                <th>Location</th>
            </tr>

            <?php
            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT title, name, role_type, state from Movie join MovieCharacter on Movie.id = MovieCharacter.movie join JobPosting on JobPosting.movie_character = MovieCharacter.id join Location on JobPosting.location = Location.id";
            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["title"] . "</td><td>". $row["name"] . "</td><td>". $row["role_type"] . "</td><td>". $row["state"] . "</td></tr>"; 
                }
                echo "</table>";
            }
            else{
                echo "0 result";
            }

            $conn-> close();
            ?>
            
        </table>
    </section>
    <footer>
        <p>Casting, Copyright &copy; 2020</p>
    </footer>
</body>

</html>




















