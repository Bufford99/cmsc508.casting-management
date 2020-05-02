<?php

session_start();

require_once('connection.php');

// global constants
$login_error_msg = 'Invalid username and/or password';

// get req params from POST request
$uname = !empty($_POST['uname']) ? trim($_POST['uname']) : null;
$psw = !empty($_POST['psw']) ? trim($_POST['psw']) : null;

// construct SQL statement and prepare it
$sql = "SELECT id, username, pass FROM Account WHERE username = :username;";
$stmt = $conn->prepare($sql);

// bind value for prepare statement
$stmt->bindValue(':username', $uname);

// execute statement
$stmt->execute();

// fetch row
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    die($login_error_msg);
} else {
    $validPassword = password_verify($psw, $row['pass']);

    if ($validPassword) {
        if (isApplicant($row['id'])) {
            $_SESSION['user'] = $row['id'];
            header('Location: index.html'); // redirect to homepage
        } else if (isAuditionManager($row['id'])) {
            $_SESSION['manager'] = $row['id'];
            header('Location: ./manager/audition.html');
        } else if (isHiringManager($row['id'])) {
            $_SESSION['manager'] = $row['id'];
            header('Location: ./manager/hiring.html');
        } else if (isPostingManager($row['id'])) {
            $_SESSION['manager'] = $row['id'];
            header('Location: ./manager/posting.php');
        } else {
            die('Something went wrong.');
        }

        exit;
    } else {
        die($login_error_msg);
    }
}

function isApplicant($id) {
    global $conn;

    $sql = "SELECT id FROM Applicant WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        return false;
    } else {
        return true;
    }
}

function isAuditionManager($id) {
    global $conn;
    
    $sql = "SELECT id FROM AuditionManager WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        return false;
    } else {
        return true;
    }
}

function isHiringManager($id) {
    global $conn;
    
    $sql = "SELECT id FROM HiringManager WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        return false;
    } else {
        return true;
    }
}

function isPostingManager($id) {
    global $conn;
    
    $sql = "SELECT id FROM PostingManager WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        return false;
    } else {
        return true;
    }
}

?>