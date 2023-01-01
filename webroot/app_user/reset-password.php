<?php
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit();
    }

    require_once(__DIR__ . '/../mysql_helper.php');

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
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

        $password = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);
        $id = (int) $_SESSION['id'];
        $sql = "UPDATE application_users SET password = '$password' WHERE id = $id";

        if($con->query($sql))
        {
            $con->close();
            header("Location: logout.php");
            exit();
        }
        else
        {
            $con->close();
            $uri_base = $_SERVER['REQUEST_URI'];
            $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
            $error_uri = $uri_base . 'error.php?message="' .
                htmlspecialchars("There was an error updating the record in the MySQL database. Please contact your system administrator or check the error logs.") . '"';
            header("Location: " . $error_uri);
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Reset Password</title>
        <?php require_once(__DIR__ . '/templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/templates/navigation.php'); ?>
        <h2>Reset Password</h2>
        <form action="reset-password.php" method="post" id="reset-form">
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="password" placeholder="Password" required>
                <span class="error" id="password-error"></span>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm Password: </label>
                <input type="password" class="form-control" id="password_confirm" placeholder="Confirm Password" required>
                <span class="error" id="confirm-password-error"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submitbtn">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </body>
</html>
