<?php

require_once(__DIR__ . '/config.php');

function createConnection()
{
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

    if($con->connect_error)
    {
        error_log("Failed to connect to MySQL database: " . $con->connect_error);
        return null;
    }

    return $con;
}