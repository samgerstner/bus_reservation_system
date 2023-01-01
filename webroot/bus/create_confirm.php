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

$sql = "";
if(!isset($_GET['make']) && !isset($_GET['model']) && !isset($_GET['odometer_reading']) && !isset($_GET['odometer_read_date']))
{
    //no optionals set
    $sql = printf("INSERT INTO Bus (vin, passenger_capacity) VALUES ('%s', %d)", $_GET['vin'], $_GET['passenger_capacity']);
}
else if(!isset($_GET['make']) && !isset($_GET['model']) && isset($_GET['odometer_reading']) && !isset($_GET['odometer_read_date']))
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
    $error_uri = $uri_base . 'error.php?message="' .
        htmlspecialchars("Invalid input. If you specify an odometer reading, you must specify an odometer reading date.") . '"';
    header("Location: " . $error_uri);
    exit();
}
else if(!isset($_GET['make']) && !isset($_GET['model']))
{
    //odometer info only
    $sql = printf("INSERT INTO Bus (vin, passenger_capacity, odometer_reading, odometer_read_date) VALUES ('%s', %d, %lf, '%s')",
        $_GET['vin'], $_GET['passenger_capacity'], $_GET['odometer_reading'], $_GET['odometer_read_date']);
}
else if((!isset($_GET['make']) && isset($_GET['model'])) || (isset($_GET['make'] )&& !isset($_GET['model'])))
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
    $error_uri = $uri_base . 'error.php?message="' .
        htmlspecialchars("Invalid input. If you specify a make or model, you must specify both.") . '"';
    header("Location: " . $error_uri);
    exit();
}
else if((isset($_GET['make']) && isset($_GET['model'])) && (!isset($_GET['odometer_reading']) && !isset($_GET['odometer_read_date'])))
{
    //make and model info only
    $sql = printf("INSERT INTO Bus (vin, make, model, passenger_capacity) VALUES ('%s', '%s', '%s', %d)",
        $_GET['vin'], $_GET['make'], $_GET['model'], $_GET['passenger_capacity']);
}
else
{
    //all optionals provided
    $sql = printf("INSERT INTO Bus VALUES ('%s', '%s', '%s', %d, %d, '%s')",
        $_GET['vin'], $_GET['make'], $_GET['model'], $_GET['passenger_capacity'], $_GET['odometer_reading'], $_GET['odometer_read_date']);
}

if($con->query($sql) === TRUE)
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/create"));
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
        htmlspecialchars("Encountered an error while inserting record to MySQL database. Please contact your administrator or check the error logs.") . '"';
    header("Location: " . $error_uri);
    exit();
}