<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Home</title>
        <?php require_once(__DIR__ . '/templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/templates/navigation.php'); ?>
        <h2>Error</h2>
        <p><?php echo $_GET['message']; ?></p>
    </body>
</html>