<?php

session_start();

if (!isset($_SESSION['manager'])) {
    die('404 unavailable');
}

require_once('../connection.php');

$applicant_id = $_GET['aid'];
$jobposting_id = $_GET['jid'];
$manager_id = $_SESSION['manager'];

// check if already approved
$sql = "SELECT id FROM Application WHERE owner = :aid AND job_posting = :jid AND status = 'REJECTED'";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo '<script>
        alert("Application has already been rejected");
        window.location.href="hiring.php";
        </script>';
    die();
}

// delete audition candidate
$sql = "DELETE FROM AuditionCandidates
    WHERE id = (SELECT id FROM Audition WHERE job_posting = :jid) AND candidate = :aid";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->bindValue(':aid', $applicant_id);
$stmt->execute();

// update application status
$sql = "UPDATE Application SET status = 'REJECTED' WHERE owner = :aid AND job_posting = :jid";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':aid', $applicant_id);
$stmt->bindValue(':jid', $jobposting_id);
$stmt->execute();

// success message and redirect
echo '<script>
    alert("Application rejected");
    window.location.href="hiring.php";
    </script>';
die();

?>