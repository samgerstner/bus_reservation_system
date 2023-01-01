<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Create Bus</title>
        <?php require_once(__DIR__ . '/../templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/../templates/navigation.php'); ?>
        <h2>Create New Bus</h2>
        <form action="create_confirm.php" method="get">
            <div class="form-group">
                <label for="vin">VIN Number: </label>
                <input type="text" class="form-control" id="vin" placeholder="VIN Number" maxlength="17" required>
            </div>
            <div class="form-group">
                <label for="make">Vehicle Make: </label>
                <input type="text" class="form-control" id="make" placeholder="Vehicle Make" maxlength="20">
            </div>
            <div class="form-group">
                <label for="model">Vehicle Model: </label>
                <input type="text" class="form-control" id="model" placeholder="Vehicle Model" maxlength="20">
            </div>
            <div class="form-group">
                <label for="passenger_capacity">Passenger Capacity: </label>
                <input type="number" class="form-control" id="passenger_capacity" required>
            </div>
            <div class="form-group">
                <label for="odometer_reading">Odometer Reading: </label>
                <input type="number" class="form-control" id="odometer_reading">
            </div>
            <div class="form-group">
                <label for="odometer_read_date">Odometer Read Date: </label>
                <input type="date" class="form-control" id="odometer_read_date">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </body>
</html>