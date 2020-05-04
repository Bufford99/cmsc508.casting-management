<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/profile.css" />

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
                    <li><a href="postings.php">Postings</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li class="current"><a href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="showcase">
       <table class="profile-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="25%">
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email Adress</th>
            </tr>

            <?php

            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT DISTINCT username, CONCAT(Account.first_name, ' ', Account.last_name) AS FullName, email FROM Account WHERE Account.id = '".$_SESSION['user']. "'";

            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["username"] . "</td><td>". $row["FullName"] . "</td><td>". $row["email"] . "</td></tr>"; 
                }
                echo "</table>";
            }
            else{
                echo "0 result";
            }

            $conn-> close();
            ?>
            
        </table>
        <table class="profile-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="25%">
            <tr>
                <th>Degree</th>
            </tr>

            <?php

            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT DISTINCT CONCAT(gpa, ' GPA ', 'in ', major, ' @ ', institute) as Diploma FROM Account join Degree on Account.id = Degree.owner WHERE Account.id = '".$_SESSION['user']. "'";

            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["Diploma"] . "</td></tr>"; 
                }
                echo "</table>";
            }
            else{
                echo "0 result";
            }

            $conn-> close();
            ?>
            
        </table>
                <table class="profile-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="25%">
            <tr>
                <th>Experience</th>
            </tr>

            <?php

            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT DISTINCT CONCAT(description, ' @ ', organization) as PastJob FROM Account join Degree on Account.id = Degree.owner join JobExperience on Account.id = JobExperience.owner WHERE Account.id = '".$_SESSION['user']. "'";

            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["PastJob"] . "</td></tr>"; 
                }
                echo "</table>";
            }
            else{
                echo "0 result";
            }

            $conn-> close();
            ?>
            
        </table>
                <table class="profile-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="25%">
            <tr>
                <th>Skills</th>
                <th>Proficiency (1-3)</th>
            </tr>

            <?php

            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT DISTINCT name, proficiency FROM Account join Degree on Account.id = Degree.owner join JobExperience on Account.id = JobExperience.owner join ApplicantSkills on Account.id = ApplicantSkills.applicant join Skill on ApplicantSkills.skill = Skill.id WHERE Account.id = '".$_SESSION['user']. "'";

            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["name"] . "</td><td>". $row["proficiency"] . "</td></tr>"; 
                }
                echo "</table>";
            }
            else{
                echo "0 result";
            }

            $conn-> close();
            ?>
            
        </table>
                <table class="profile-data" style="background-color: #708090; border: solid; border-color: #000000; margin-top: 5%; margin-right: 2%; float: right; text-align: left;" width="25%">
            <tr>
                <th>References</th>
            </tr>

            <?php

            $conn = mysqli_connect("3.234.246.29", "project_6", "V00864959", "project_6");
            if ($conn-> connect_error) {
                die("Connection failed:". $conn-> connect_error);
            }

            $sql = "SELECT DISTINCT CONCAT(Skill, ' ', Reference.last_name, ', ', Reference.phone_number) as entireRef FROM Account join Degree on Account.id = Degree.owner join JobExperience on Account.id = JobExperience.owner join ApplicantSkills on Account.id = ApplicantSkills.applicant join Skill on ApplicantSkills.skill = Skill.id join ApplicantReferences on Account.id = ApplicantReferences.applicant join Reference on ApplicantReferences.reference = Reference.id WHERE Account.id = '".$_SESSION['user']. "'";

            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["entireRef"] . "</td></tr>"; 
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













