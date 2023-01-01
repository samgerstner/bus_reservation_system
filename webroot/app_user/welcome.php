<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
    {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Welcome</title>
        <?php require_once(__DIR__ . '/../templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/../templates/navigation.php'); ?>
        <h2>Welcome</h2>
        <p>Thanks for logging in, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. You can now proceed to the other pages.</p>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
    </body>
</html>
