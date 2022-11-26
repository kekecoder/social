<?php
function db()
{
    $host = "containers-us-west-108.railway.app";
    $user = "root";
    $dbname = "Social";
    $password = 'bzwLhKfpAMFH0jesd276';
    $port = 6801;
    try {
        $conn = new mysqli($host, $user, $password, $dbname, $port);
        $conn->set_charset("utf8mb4");
    } catch (Exception $e) {
        throw new ('Something went wrong, try again later ' . $e->getMessage());
    }

    return $conn;
}