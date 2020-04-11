<?php

session_start();

require_once('connection.php');

// global constants
$username_exists_msg = 'Username already taken';
$email_exists_msg = 'Email already in use';
$signup_error_msg = 'There was an error in creating the account. Try again later.';

// get req params from POST request
$firstName = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
$lastName = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
$psw = !empty($_POST['psw']) ? trim($_POST['psw']) : null;
$uname = !empty($_POST['uname']) ? trim($_POST['uname']) : null;

// check if email already in use
$sql = "SELECT COUNT(email) as 'num' FROM Account WHERE email = :email;";
$stmt = $conn->prepare($sql);

$stmt->bindValue(':email', $email);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['num'] > 0) {
    die($email_exists_msg);
}

// check if username already exists
$sql = "SELECT COUNT(username) as 'num' FROM Account WHERE username = :username;";
$stmt = $conn->prepare($sql);

$stmt->bindValue(':username', $uname);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['num'] > 0) {
    die($username_exists_msg);
}

// prepare inserting into table
$passwordHash = password_hash($psw, PASSWORD_DEFAULT);

// prepare and execute INSERT statement
$sql = "INSERT INTO Account (first_name, last_name, email, username, pass) VALUES (:firstname, :lastname, :email, :username, :pass)";
$stmt = $conn->prepare($sql);

$stmt->bindValue(':firstname', $firstName);
$stmt->bindValue(':lastname', $lastName);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':username', $uname);
$stmt->bindValue(':pass', $passwordHash);

$res = $stmt->execute();

// check if successful
if ($res) {
    header('Location: login.html');
    echo '<script>alert("Account creation successful!")</script>'; 
    exit;
} else {
    die($signup_error_msg);
}

?>