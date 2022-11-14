<?php

function random_string(int $length)
{
    $characters = "abcdefghijklmnopqrstuvwxyABCDEFGIJKLMNOPQRSTUVWXYZ1234567890";
    $random_string = "";

    if ($length <= 5) {
        die("The length of string you enter is too short");
    }

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $random_string .= $characters[$index];
    }

    return $random_string;
}

function valid_string($string)
{
    $string = trim($string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = ucfirst($string);

    return $string;
}