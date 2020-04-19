<?php

session_start();

require('connection.php');

if(isset($_POST['adminLogin'])) {
    $login_error_msg = 'Login failed';

    // get req params from POST request
    $uname = !empty($_POST['uname']) ? trim($_POST['uname']) : null;
    $psw = !empty($_POST['psw']) ? trim($_POST['psw']) : null;

    // construct SQL statement and prepare it
    $sql = "SELECT username, pass FROM Internal WHERE username = :username;";
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
            $_SESSION['admin'] = true;
            header('Location: admin.html');
            exit;
        } else {
            die($login_error_msg);
        }
    }
} else if (isset($_POST['createManager'])) {
       // global constants
        $username_exists_msg = 'Username already taken';
        $email_exists_msg = 'Email already in use';
        $signup_error_msg = 'There was an error in creating the account. Try again later.';

        // get req params from POST request
        $managerType = !empty($_POST['managertype']) ? trim($_POST['managertype']) : null;
        $firstName = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $lastName = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $psw = !empty($_POST['psw']) ? trim($_POST['psw']) : null;
        $uname = !empty($_POST['uname']) ? trim($_POST['uname']) : null;

        // check if managertype is "null"
        if ($managerType != 'audition' && $managerType != 'hiring' && $managerType != 'posting') {
            die("no manager option selected");
        }

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

        // prepare and execute INSERT statement to Account
        $sql = "INSERT INTO Account (first_name, last_name, email, username, pass) VALUES (:firstname, :lastname, :email, :username, :pass)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':firstname', $firstName);
        $stmt->bindValue(':lastname', $lastName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':username', $uname);
        $stmt->bindValue(':pass', $passwordHash);

        $res = $stmt->execute();

        // prepare and execute INSERT statement to a Manager table
        $sql = "SELECT id from Account WHERE username=:username";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':username', $uname);

        $res = $stmt->execute();

        if ($res) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            die($signup_error_msg);
        }

        if ($row) {
            $id = $row['id'];
        } else {
            die($signup_error_msg);
        }

        switch ($managerType) {
            case 'audition':
                $sql = "INSERT INTO AuditionManager (id) VALUES (:id)";
                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':id', $id);

                $res = $stmt->execute();
                break;
            case 'hiring':
                $sql = "INSERT INTO HiringManager (id) VALUES (:id)";
                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':id', $id);

                $res = $stmt->execute();
                break;
            case 'posting':
                $sql = "INSERT INTO PostingManager (id) VALUES (:id)";
                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':id', $id);

                $res = $stmt->execute();
                break;
            default:
                die('Something went wrong');
                break;
        }

        // check if successful
        if ($res) {
            echo $managerType . " manager creation successful";
            exit;
        } else {
            die($signup_error_msg);
        }
} else {
    echo "404 Unavailable";
}

?>