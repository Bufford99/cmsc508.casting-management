<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/postings.css" />

    <script src="js/scripts.js"></script>

    <title>Casting Management</title>
</head>

<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Name</span> Casting</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li class="current"><a href="postings.html">Postings</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="profile.html">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="showcase">
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT id, first_name, last_name, email from Account";
            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["id"] . "</td><td>". $row["first_name"] . "</td><td>". $row["last_name"] . "</td><td>". $row["email"] . "</td></tr>"; 
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




















