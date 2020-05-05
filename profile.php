<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        die('404 unavailable');
    } else {
        $applicantId = $_SESSION['user'];
    }

    require_once('connection.php');
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
                    <li><a href="logout.php">Logout</a></li>
                    <li class="current"><a href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="showcase">
    	<div class="flex-tables">
	       <table class="profile-data1">
	            <tr>
	                <th>Username</th>
	                <th>Name</th>
	                <th>Email Adress</th>
	            </tr>

	            <?php

                $sql = "SELECT DISTINCT username, CONCAT(Account.first_name, ' ', Account.last_name) AS FullName,
                    email FROM Account WHERE Account.id = :aid";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':aid', $applicantId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row) {
                        echo "<tr><td>". $row["username"] . "</td><td>". $row["FullName"] . "</td><td>". $row["email"] . "</td></tr>"; 

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    echo "</table>";
                }
                else{
                    echo "0 result";
                }

                ?>
	            
	        </table>
	        <table class="profile-data2">
	            <tr>
	                <th>Degree</th>
	                <th>Major</th>
	                <th>Institute</th>
	                <th>Date</th>
	            </tr>

	            <?php

                $sql = "SELECT DISTINCT CONCAT(gpa, ' GPA ', 'in ', major, ' @ ', institute) as Diploma
                    FROM Account join Degree on Account.id = Degree.owner
                    WHERE Account.id = :aid";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':aid', $applicantId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row) {
                        echo "<tr><td>". $row["Diploma"] . "</td></tr>";

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    echo "</table>";
                }
                else{
                    echo "0 result";
                }

                ?>
	            
	        </table>
	                <table class="profile-data3">
	            <tr>
	                <th>Position</th>
	                <th>Organization</th>
	            </tr>

	            <?php

                $sql = "SELECT DISTINCT CONCAT(description, ' @ ', organization) as PastJob
                    FROM Account join Degree on Account.id = Degree.owner
                    join JobExperience on Account.id = JobExperience.owner
                    WHERE Account.id = :aid";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':aid', $applicantId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row) {
                        echo "<tr><td>". $row["PastJob"] . "</td></tr>";

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    echo "</table>";
                }
                else{
                    echo "0 result";
                }

                ?>
	            
	        </table>
	                <table class="profile-data4">
	            <tr>
	                <th>Skills</th>
	                <th>Proficiency (1-3)</th>
	            </tr>

	            <?php

                $sql = "SELECT DISTINCT name, proficiency FROM Account join Degree on Account.id = Degree.owner
                    join JobExperience on Account.id = JobExperience.owner
                    join ApplicantSkills on Account.id = ApplicantSkills.applicant
                    join Skill on ApplicantSkills.skill = Skill.id
                    WHERE Account.id = :aid";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':aid', $applicantId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row) {
                        echo "<tr><td>". $row["name"] . "</td><td>". $row["proficiency"] . "</td></tr>";

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    echo "</table>";
                }
                else{
                    echo "0 result";
                }

                ?>
	            
	        </table>
	                <table class="profile-data5">
	            <tr>
	                <th>References</th>
	                <th>Phone Number</th>
	            </tr>

	            <?php

                $sql = "SELECT DISTINCT CONCAT(Skill, ' ', Reference.last_name, ', ', Reference.phone_number)
                    as entireRef FROM Account join Degree on Account.id = Degree.owner
                    join JobExperience on Account.id = JobExperience.owner
                    join ApplicantSkills on Account.id = ApplicantSkills.applicant
                    join Skill on ApplicantSkills.skill = Skill.id
                    join ApplicantReferences on Account.id = ApplicantReferences.applicant
                    join Reference on ApplicantReferences.reference = Reference.id
                    WHERE Account.id = :aid";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':aid', $applicantId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row) {
                        echo "<tr><td>". $row["entireRef"] . "</td></tr>"; 

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    echo "</table>";
                }
                else{
                    echo "0 result";
                }

                ?>
	            
	        </table>
	    </div>
    </section>
    <footer>
        <p>Acano Casting, Copyright &copy; 2020</p>
    </footer>
</body>













