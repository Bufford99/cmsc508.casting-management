<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $servername = "3.234.246.29";
    $username = "project_6";
    $password = "V00864959";
    $database = "project_6";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

?>