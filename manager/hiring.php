<?php

session_start();

if (!isset($_SESSION['hmanager'])) {
    die('404 unavailable');
}

require_once('../connection.php');

function getApplications() {
    global $conn;

    $sql = "SELECT concat(ac.first_name, ' ', ac.last_name) AS 'applicant_name', a.status AS 'status',
        ac.id AS 'applicant_id', j.id AS 'jobposting_id', mc.name AS 'movie_character', mv.title AS 'movie_title'
            FROM Application a 
            JOIN Account ac
            ON a.owner = ac.id
            JOIN JobPosting j
            ON a.job_posting = j.id
            JOIN MovieCharacter mc
            ON j.movie_character = mc.id
            JOIN Movie mv
            ON mc.movie = mv.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        die('failed to retrieve application data');
    }

    if ($stmt->rowCount() > 0) {
        echo '<div>';
        echo '<h2>Applications</h2>';
        echo '<table style="width: 50%";>';
        echo '<tr>';
        echo '<th align="left">Applicant</th>';
        echo '<th align="left">Title</th>';
        echo '<th align="left">Character</th>';
        echo '<th align="left">Status</th>';
        echo '<th align="right">Action</th>';

        while ($row) {
            echo '<tr>';
            echo '<td>'.$row['applicant_name'].'</td>';
            echo '<td>'.$row['movie_title'].'</td>';
            echo '<td>'.$row['movie_character'].'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '<td><a href="approve.php?aid='.$row['applicant_id'].'&jid='.$row['jobposting_id'].'"</a>Approve</td>';
            echo '<td><a href="reject.php?aid='.$row['applicant_id'].'&jid='.$row['jobposting_id'].'"</a>Reject</td>';
            echo '</tr>';

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        echo '</table>';
        echo '</div>';
    }
}

function getAuditions() {
    global $conn;

    $sql = "SELECT a.id AS 'id', a.date AS 'date', a.time AS 'time', a.building AS 'building', mc.name AS 'movie_character', mv.title AS 'movie_title' FROM Audition a
        JOIN JobPosting j
        ON a.job_posting = j.id
        JOIN MovieCharacter mc
        ON j.movie_character = mc.id
        JOIN Movie mv
        ON mc.movie = mv.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        die('failed to retrieve audition data');
    }

    if ($stmt->rowCount() > 0) {
        echo '<div>';
        echo '<h2>Auditions</h2>';
        echo '<table style="width: 50%";>';
        echo '<tr>';
        echo '<th align="left">Date</th>';
        echo '<th align="left">Time</th>';
        echo '<th align="left">Building</th>';
        echo '<th align="left">Character</th>';
        echo '<th align="left">Movie</th>';

        while ($row) {
            echo '<tr onclick="window.location=\'audition-detail.php?id='.$row['id'].'\'" style="cursor: pointer;">';
            echo '<td>'.$row['date'].'</td>';
            echo '<td>'.$row['time'].'</td>';
            echo '<td>'.$row['building'].'</td>';
            echo '<td>'.$row['movie_character'].'</td>';
            echo '<td>'.$row['movie_title'].'</td>';
            echo '</tr>';

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        echo '</table>';
        echo '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring Manager</title>

    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/login.css" />

    <style>
        table, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <a href="../logout.php" style="margin: 10px auto;">Logout</a>
    
    <div class="flex" style="display: flex;">
        <?php getApplications() ?>
        <?php getAuditions() ?>
    </div>
</body>
</html>