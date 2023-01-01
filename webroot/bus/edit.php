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

    $sql = printf("SELECT * FROM Bus WHERE vin = '%s'", $_GET['vin']);
    $result = $con->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $vin = $row['vin'];
        $make = $row['make'];
        $model = $row['model'];
        $passenger_capacity = $row['passenger_capacity'];
        $odometer_reading = $row['odometer_reading'];
        $odometer_read_date = $row['odometer_read_date'];
    }
    else
    {
        $uri_base = $_SERVER['REQUEST_URI'];
        $uri_base = substr($uri_base, 0, strpos($uri_base, "/bus"));
        $error_uri = $uri_base . 'error.php?message="' .
            htmlspecialchars("Could not find a bus with the VIN number " . $_GET['vin'] . '.') . '"';
        header("Location: " . $error_uri);
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | Create Bus</title>
        <?php require_once(__DIR__ . '/../templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/../templates/navigation.php'); ?>
        <h2>Edit Bus</h2>
        <form action="edit_confirm.php" method="get">
            <div class="form-group">
                <label for="vin">VIN Number: </label>
                <input type="text" class="form-control" id="vin" placeholder="VIN Number" maxlength="17" value="<?php echo $vin; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="make">Vehicle Make: </label>
                <input type="text" class="form-control" id="make" placeholder="Vehicle Make" maxlength="20"
                    <?php if(isset($make)){echo 'value="' . $make . '"';} ?>>
            </div>
            <div class="form-group">
                <label for="model">Vehicle Model: </label>
                <input type="text" class="form-control" id="model" placeholder="Vehicle Model" maxlength="20"
                    <?php if(isset($model)){echo 'value="' . $model . '"';} ?>>
            </div>
            <div class="form-group">
                <label for="passenger_capacity">Passenger Capacity: </label>
                <input type="number" class="form-control" id="passenger_capacity" value="<?php echo $passenger_capacity; ?>" required>
            </div>
            <div class="form-group">
                <label for="odometer_reading">Odometer Reading: </label>
                <input type="number" class="form-control" id="odometer_reading"
                    <?php if(isset($odometer_reading)){echo 'value="' . $odometer_reading . '"';} ?>>
            </div>
            <div class="form-group">
                <label for="odometer_read_date">Odometer Read Date: </label>
                <input type="date" class="form-control" id="odometer_read_date"
                    <?php if(isset($odometer_read_date)){echo 'value="' . $odometer_read_date . '"';} ?>>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </body>
</html>