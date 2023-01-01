<?php
    require_once(__DIR__ . '/../config.php');

    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
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

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if(empty($username_err) && empty($password_err))
        {
            $sql = "SELECT id, username, password FROM application_users WHERE username = '$username'";
            $result = mysqli_query($sql);

            if(!$result)
            {
                $uri_base = $_SERVER['REQUEST_URI'];
                $uri_base = substr($uri_base, 0, strpos($uri_base, "/app_user"));
                $error_uri = $uri_base . 'error.php?message="' .
                    htmlspecialchars("An error occurred while selecting from the database. Please contact your administrator or check the error logs.") . '"';
                header("Location: " . $error_uri);
                exit();
            }

            if($result->num_rows == 0)
            {
                echo '<script>postUsernameError();</script>';
            }
            else
            {
                $row = $result->fetch_assoc();
                //Validate password
                if(password_verify($password, $row['password']))
                {
                    //Password is correct, start new session
                    session_start();

                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["username"] = $username;

                    $con->close();

                    // Redirect user to welcome page
                    header("location: welcome.php");
                    exit();
                }
                else
                {
                    echo '<script>postPasswordError();</script>';
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Login</title>
        <?php require_once(__DIR__ . '/templates/dependencies.php'); ?>
        <link rel="stylesheet" href="../resources/css/login_validation.css" type="text/css">
    </head>
    <body>
        <?php require_once(__DIR__ . '/templates/navigation.php'); ?>
        <div id="message"></div>
        <h2>Login</h2>
        <p>Please enter your username and password below.</p>
        <form action="login.php" method="post" id="login-form">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" id="username" placeholder="Username" required>
                <span class="error" id="username-error"></span>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="password" placeholder="Password" required>
                <span class="error" id="password-error"></span>
            </div>
            <button type="submit" class="btn btn-primary" id="submitbtn">Login</button>
        </form>
        <script src="../resources/js/login_validation.js" type="application/javascript"></script>
    </body>
</html>
