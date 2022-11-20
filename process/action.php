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
        } elseif (email_exists($email)) {
            $_SESSION['email'] = "This email is already taken";
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
            $result = get_user($email);
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['username'] = $result['first_name'];
            $_SESSION['success'] = "Registration Completed";
            header('Location: /');
        }
        break;

    case isset($_POST['login']):
        $email = valid_string($_POST['email']);
        $password = valid_string($_POST['password']);

        if (!$email) {
            $_SESSION['email'] = REQUIRED;
            header("Location: /users/login.php");
        } elseif (!email_exists($email)) {
            $_SESSION['email'] = "This email does not exist in our records";
            header("Location: /users/login.php");
        }

        if (!$password) {
            $_SESSION['password'] = REQUIRED;
            header("Location: /users/login.php");
        } elseif (strlen($password) < 5) {
            $_SESSION['password'] = "Password length is too short";
            header('Location: /users/login.php');
        }

        if (empty($_SESSION)) {
            if ($result = login($email)) {
                $id = $result['id'];
                $username = $result['first_name'];
                $hashed_pass = $result['password'];

                if (password_verify($password, $hashed_pass)) {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "Login Successful";
                    header("Location: /");
                } else {
                    $_SESSION['error'] = "Email/Password does not match our records";
                    header("Location: /users/login.php");
                }
            } else {
                $_SESSION['error'] = "Something went wrong, please try again later";
                header("Location: /users/login.php");
            }
        }
        break;

    case isset($_POST['change_password']):
        $email = valid_string($_POST['email']);
        $password = valid_string($_POST['password']);
        $cp = valid_string($_POST['cp']);

        if (!$email) {
            $_SESSION['email'] = REQUIRED;
            header('Location: /users/change-pass.php');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = "This is not the required email format";
            header('Location: /users/change-pass.php');
        } elseif (!email_exists($email)) {
            $_SESSION['email'] = "This email does not exists in our records";
            header('Location: /users/change-pass.php');
        }

        if (!$password) {
            if (!$password) {
                $_SESSION['password'] = REQUIRED;
                header('Location: /users/change-pass.php');
            } elseif (strlen($password) < 5) {
                $_SESSION['password'] = "Password length is too short";
                header('Location: /users/change-pass.php');
            }
        }

        if (!$cp) {
            $_SESSION['cp'] = REQUIRED;
            header('Location: /users/change-pass.php');
        } elseif ($password !== $cp) {
            $_SESSION['cp'] = "Password do not match";
            header('Location: /users/change-pass.php');
        }

        if (empty($_SESSION)) {
            change_password($email, $password);
            $result = get_user($email);
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['username'] = $result['first_name'];
            $_SESSION['success'] = "Password Changed successfully";
            header('Location: /');
        }
        break;

    case isset($_POST['update_email']):
        $email = valid_string($_POST['email']);
        if (!$email) {
            $_SESSION['email'] = REQUIRED;
            header('Location: /users/change-email.php');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = "This is not the required email format";
            header('Location: /users/change-email.php');
        } elseif (email_exists($email)) {
            $_SESSION['email'] = "This email already exist";
            header('Location: /users/change-email.php');
        }

        if (empty($_SESSION)) {
            change_email($email, $_POST['id']);
            if ($result = get_user($email)) {
                $_SESSION['id'] = $result['id'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['username'] = $result['first_name'];
                $_SESSION['success'] = "Email Updated";
                header('Location: /');
            }
        }
        break;

    case isset($_POST['id']):
        logout();
        header("Location: /users/login.php");
        break;
    default:
        http_response_code(404);
        echo "Error: wrong road";
}