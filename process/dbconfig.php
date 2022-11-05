<?php

$host = "localhost";
$user = "root";
$dbname = "Social";
$password = 'jerusalem1991';

try {
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    throw new ('Something went wrong, try again later ' . $e->getMessage());
}