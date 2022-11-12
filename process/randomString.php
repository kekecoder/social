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

// echo random_string(7);