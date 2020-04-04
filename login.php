<?php

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
        $_SESSION['account_id'] = $row['id'];
        $_SESSION['logged_in'] = time();

        // redirect to homepage
        header('Location: home.html');
        exit;
    } else {
        die($login_error_msg);
    }
}

?>