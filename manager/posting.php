<?php

session_start();

if (!isset($_SESSION['pmanager'])) {
    die('404 unavailable');
}

require_once('../connection.php');

if (isset($_GET['action']) == 'create-posting') {
    $movieCharacter = !empty($_POST['movieCharacter']) ? trim($_POST['movieCharacter']) : null;
    $location = !empty($_POST['location']) ? trim($_POST['location']) : null;

    global $conn;

    // check if posting for character already exists
    $sql = "SELECT count(*) as num FROM JobPosting WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $movieCharacter);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row == false || $row['num'] == 1) {
        die('Posting for that character already exists');
    }

    $sql = "INSERT INTO JobPosting(id, manager, location, movie_character) VALUES(:id, :manager, :loc, :mc)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $movieCharacter);
    $stmt->bindValue(':manager', $_SESSION['manager']);
    $stmt->bindValue(':loc', $location);
    $stmt->bindValue(':mc', $movieCharacter);
    $stmt->execute();
}

function retrieveCharacters() {
    global $conn;

    $sql = "SELECT id, name FROM MovieCharacter WHERE 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        die('failed to retrieve character data');
    }

    while ($row) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function retrieveLocations() {
    global $conn;

    $sql = "SELECT id, concat(street_number, ' ', street_name, ' ', city) as loc FROM Location;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        die('failed to retrieve location data');
    }

    while ($row) {
        echo '<option value="' . $row['id'] . '">' . $row['loc'] . '</option>';
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Manager</title>

    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/login.css" />

    <style>
        form { position: static; }
    </style>
</head>
<body>
    <a href="../logout.php" style="margin: 10px auto;">Logout</a>
    
    <div class="flex" id="create-posting" style="display: flex;">
        <form action="?action=create-posting" method="POST">
            <h2>Create Job Posting</h2>

            <label for="select-character">Select character:</label>
            <select id="select-character" name="movieCharacter" required>
                <option value="---">---</option>
                <?php echo retrieveCharacters() ?>
            </select>

            <br />
            <br />

            <label for="select-location">Select location:</label>
            <select id="select-location" name="location" required>
                <option value="---">---</option>
                <?php echo retrieveLocations() ?>
            </select>

            <br />
            <br />
            <button class="submitFormButton" type="submit" name="createPosting" value="createPosting">Create posting</button>
        </form>
    </div>
</body>
</html>