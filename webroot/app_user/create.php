<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservation System | Create User</title>
        <?php require_once(__DIR__ . '/../templates/dependencies.php'); ?>
        <link rel="stylesheet" href="../resources/css/registration_validation.css" type="text/css">
    </head>
    <body>
        <?php require_once(__DIR__ . '/../templates/navigation.php'); ?>
        <div id="message"></div>
        <form action="create.php" method="post" id="register-form">
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
        <script src="../resources/js/registration_validation.js" type="application/javascript"></script>
    </body>
</html>
