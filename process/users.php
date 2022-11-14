<?php

require_once "dbconfig.php";

function register($first_name, $last_name, $email, $country, $password)
{
    $conn = db();
    $query = $conn->prepare("INSERT INTO users (first_name, last_name, email, country, password, created_at) VALUES(?, ?, ?, ?, ?, 'NOW()')");
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $query->bind_param('sssss', $first_name, $last_name, $email, $country, $hash_pass);
    $query->execute();
    return $query;
}