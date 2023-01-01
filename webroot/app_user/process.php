<?php

require_once(__DIR__ . '/../config.php');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if(!$con)
{
    $uri_base = $_SERVER['REQUEST_URI'];
    $uri_base = substr($uri_base, 0, strpos($uri_base, "/app_user"));
    $error_uri = $uri_base . 'error.php?message="' .
        htmlspecialchars("There was an error connecting to the MySQL database. Please contact your system administrator or check the error logs.") . '"';
    header("Location: " . $error_uri);
    exit();
}

$username = htmlspecialchars(trim($_POST['username']));
$password = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);

if(empty($username) || empty($password))
{
    echo '<div class="alert alert-success">Please provide all required fields.</div>';
}
else
{
    $sql = "SELECT id FROM application_users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);

    if(!$result)
    {
        $uri_base = $_SERVER['REQUEST_URI'];
        $uri_base = substr($uri_base, 0, strpos($uri_base, "/app_user"));
        $error_uri = $uri_base . 'error.php?message="' .
            htmlspecialchars("An error occurred while selecting from the database. Please contact your administrator or check the error logs.") . '"';
        header("Location: " . $error_uri);
        exit();
    }
    else if($result->num_rows > 0)
    {
        $uri_base = $_SERVER['REQUEST_URI'];
        $uri_base = substr($uri_base, 0, strpos($uri_base, "/app_user"));
        $error_uri = $uri_base . 'error.php?message="' .
            htmlspecialchars("A user with the same username already exists.") . '"';
        header("Location: " . $error_uri);
        exit();
    }

    $sql = "INSERT INTO application_users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($con, $sql);

    if($result)
    {
        echo '<div class="alert alert-success">Successfully created new user.</div>';
    }
    else
    {
        echo '<div class="alert alert-warning">An error occurred while creating the user. Please contact your administrator.</div>';
    }

    $con->close();
}