<?php

require_once(__DIR__ . '/../mysql_helper.php');

$con = createConnection();

if($con == null)
{
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
    $error_uri = $uri_base . 'error.php?message="' .
        htmlspecialchars("There was an error connecting to the MySQL database. Please contact your system administrator or check the error logs.") . '"';
    header("Location: " . $error_uri);
    exit();
}

$sql = printf("DELETE FROM Bus WHERE vin = '%s'", $_GET['vin']);

if($con->query($sql) === TRUE)
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/delete"));
    $redirect_uri = $uri_base . '/view.php';
    header("Location: " . $redirect_uri);
    exit();
}
else
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
    $error_uri = $uri_base . 'error.php?message="' .
        htmlspecialchars("Encountered an error while deleting record from MySQL database. Please contact your administrator or check the error logs.") . '"';
    header("Location: " . $error_uri);
    exit();
}