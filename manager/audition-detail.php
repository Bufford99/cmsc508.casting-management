<?php

session_start();

if (!isset($_SESSION['manager'])) {
    die('404 unavailable');
}

require_once('../connection.php');

$audition_id = $_GET['id'];

$sql = "SELECT concat(ac.first_name, ' ', ac.last_name) AS 'name'
    FROM AuditionCandidates ad JOIN Account ac
    ON ad.candidate = ac.id
    WHERE ad.id = :id;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $audition_id);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    echo 'No Candidates at this time';
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    while ($row) {
        echo $row['name'];
        echo '<br />';
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>