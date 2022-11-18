<?php

require_once "dbconfig.php";

function register($first_name, $last_name, $email, $country, $password)
{
    $conn = db();
    $query = $conn->prepare("INSERT INTO users (first_name, last_name, email, country, password, created_at) VALUES(?, ?, ?, ?, ?, 'now()')");
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $query->bind_param('sssss', $first_name, $last_name, $email, $country, $hash_pass);
    $query->execute();
    return $query;
}

function email_exists(string $email)
{
    $conn = db();
    $query = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();

    $result = $query->get_result();
    if ($result->num_rows === 0) {
        return false;
    } else {
        return true;
    }
}

function login(string $email)
{
    $conn = db();
    $query  = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();

    return $query->get_result()->fetch_assoc();
}

function change_password(string $email, string $password)
{
    $conn = db();
    $query = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $query->bind_param("ss", $hash_pass, $email);
    $query->execute();
    if ($query->affected_rows === 1) {
        return true;
    } else {
        return false;
    }
    return $query;
}

function get_id(int $id)
{
    $conn = db();
    $query = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    return $query->get_result()->fetch_assoc();
}

function logout()
{
    $user = $_SESSION['id'] ?? false;
    if ($user) {
        unset($user);
        session_destroy();
    } else {
        return false;
    }

    return $user;
}

function change_email($email, $id)
{
    $conn = db();
    $query = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $query->bind_param("si", $email, $id);
    $query->execute();

    if ($query->affected_rows === 1) {
        return true;
    } else {
        return false;
    }

    return $query;
}