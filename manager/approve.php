<?php

session_start();

if (!isset($_SESSION['hmanager'])) {
    die('404 unavailable');
}

require_once('../connection.php');

$applicant_id = $_GET['aid'];
$jobposting_id = $_GET['jid'];
$manager_id = $_SESSION['hmanager'];

// check if already approved
$sql = "SELECT id FROM Application WHERE owner = :aid AND job_posting = :jid AND status = 'APPROVED'";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo '<script>
        alert("Application has already been approved");
        window.location.href="hiring.php";
        </script>';
    die();
}

// check if audition for this job posting already created
$sql = "SELECT id FROM Audition WHERE job_posting = :jid";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

// add audition for job posting if does not exist yet
if ($stmt->rowCount() == 0) {
    $sql = "INSERT INTO Audition(date, time, building, manager, job_posting)
        VALUES(DATE_ADD(curdate(), INTERVAL 1 MONTH), TIME('13:00:00'), 'West Hall', :mid, :jid)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':mid', $manager_id);
    $stmt->bindValue(':jid', $jobposting_id);
    $stmt->execute();
}

// add audition candidate
$sql = "INSERT INTO AuditionCandidates(id, candidate)
    VALUES((SELECT id FROM Audition WHERE job_posting = :jid), :aid)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->bindValue(':aid', $applicant_id);
$stmt->execute();

// update application status
$sql = "UPDATE Application SET status = 'APPROVED' WHERE owner = :aid AND job_posting = :jid";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

// success message and redirect
echo '<script>
    alert("Application approved!");
    window.location.href="hiring.php";
    </script>';
die();

?>