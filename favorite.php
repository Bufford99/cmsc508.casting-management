<?php

session_start();

if (!isset($_SESSION['user'])) {
    echo '<script>
        alert("You must login first");
        window.location.href="login.html";
        </script>';
    die();
}

require_once('connection.php');

$applicant_id = $_GET['aid'];
$jobposting_id = $_GET['jid'];

// check if already favorited
$sql = "SELECT owner FROM Favorite WHERE owner = :aid AND job_posting = :jid";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

if($stmt->rowCount() > 0) {
    echo '<script>
        alert("Already favorited job posting");
        window.location.href="postings.php";
        </script>';
    die();
}

$sql = "INSERT INTO Favorite(owner, job_posting)
    VALUES(:aid, :jid)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

// success message and redirect
echo '<script>
    alert("Successfully favorited this job posting!");
    window.location.href="postings.php";
    </script>';
die();

?>