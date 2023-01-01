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
    $sql = printf("UPDATE Bus SET passenger_capacity = %d WHERE vin = '%s'", $_GET['passenger_capacity'], $_GET['vin']);
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
    $sql = printf("UPDATE Bus SET passenger_capacity = %d, odometer_reading = %d, odometer_read_date = '%s' WHERE vin = '%s'",
        $_GET['passenger_capacity'], $_GET['odometer_reading'], $_GET['odometer_read_date'], $_GET['vin']);
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
    $sql = printf("UPDATE Bus SET passenger_capacity = %d, make = '%s', model = '%s' WHERE vin = '%s'",
        $_GET['passenger_capacity'], $_GET['make'], $_GET['model'], $_GET['vin']);
}
else
{
    //all optionals provided
    $sql = printf("UPDATE Bus SET passenger_capacity = %d, make = '%s', model = '%s', odometer_reading = %d, odometer_read_date = '%s' WHERE vin = '%s'",
        $_GET['passenger_capacity'], $_GET['make'], $_GET['model'], $_GET['odometer_reading'], $_GET['odometer_read_date'], $_GET['vin']);
}

if($con->query($sql) === TRUE)
{
    $con->close();
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/edit"));
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
        htmlspecialchars("Encountered an error while updating record in MySQL database. Please contact your administrator or check the error logs.") . '"';
    header("Location: " . $error_uri);
    exit();
}