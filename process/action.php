<?php
session_start();
require_once "randomString.php";
require_once "users.php";

define("REQUIRED", "This field is required");

switch (true) {
    case isset($_POST['register']):
        $first_name = valid_string($_POST['first_name']);
        $last_name = valid_string($_POST['last_name']);
        $email = valid_string($_POST['email']);
        $country = valid_string($_POST['country']);
        $password = valid_string($_POST['password']);
        $cp = valid_string($_POST['cp']);

        if (!$first_name) {
            $_SESSION['first_name'] = REQUIRED;
            header('Location: /users/register.php');
        }
        if (!$last_name) {
            $_SESSION['last_name'] = REQUIRED;
            header('Location: /users/register.php');
        }
        if (!$email) {
            $_SESSION['email'] = REQUIRED;
            header('Location: /users/register.php');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = "This is not the required email format";
            header('Location: /users/register.php');
        }
        if (!$country) {
            $_SESSION['country'] = "Please select a country from the dropdown list";
            header('Location: /users/register.php');
        }
        if (!$password) {
            $_SESSION['password'] = REQUIRED;
            header('Location: /users/register.php');
        } elseif (strlen($password) < 5) {
            $_SESSION['password'] = "Password length is too short";
            header('Location: /users/register.php');
        }

        if (!$cp) {
            $_SESSION['cp'] = REQUIRED;
            header('Location: /users/register.php');
        } elseif ($password !== $cp) {
            $_SESSION['cp'] = "Password do not match";
            header('Location: /users/register.php');
        }

        if (empty($_SESSION)) {
            register($first_name, $last_name, $email, $country, $password);
            $_SESSION['username'] = $first_name;
            $_SESSION['success'] = "Registration Completed";
            header('Location: /');
        }

        break;
    default:
        echo "Error: wrong road";
}