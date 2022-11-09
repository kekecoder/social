<?php
require_once 'process/dblib.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    exit;
}