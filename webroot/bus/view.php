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
    if(isset($_GET['search_value']))
    {
        $sql = printf("SELECT DISTINCT * FROM Bus WHERE vin LIKE '\%%s\%' OR make LIKE '\%%s\%' OR model LIKE '\%%s\%'");
    }
    else
    {
        $sql = "SELECT DISTINCT * FROM Bus";
    }

    $result = $con->query($sql);
    $rows = array();

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $bus = new Bus($row['vin'], $row['make'], $row['model'], $row['passenger_capacity'], $row['odometer_reading'], $row['odometer_read_date']);
            array_push($rows, $bus);
        }
    }

    $con->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bus Reservations | View Buses</title>
        <?php require_once(__DIR__ . '/templates/dependencies.php'); ?>
    </head>
    <body>
        <?php require_once(__DIR__ . '/templates/navigation.php'); ?>
        <h2>View/Search Buses</h2>
        <form action="view.php" method="get">
            <div class="input-group">
                <div class="form-outline">
                    <input type="search" id="search_value" class="form-control" />
                    <label class="form-label" for="search_value">Search</label>
                </div>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">VIN</th>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                    <th scope="col">Passenger Capacity</th>
                    <th scope="col">Odometer Reading</th>
                    <th scope="col">Odometer Read Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($rows as $bus)
                    {
                        $table_row = <<<END
                        <tr>
                            <th scope="row">%s</th>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><a href="edit.php?vin=%s"><button type="button" class="btn btn-primary">Edit</button></a></td>
                                            <td><a href="delete_confirm.php?vin=%s"><button type="button" class="btn btn-danger">Delete</button></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        END;
                        $table_row = printf($table_row, $bus->get_vin(), $bus->get_make(), $bus->get_model(), $bus->get_passenger_capacity(),
                            $bus->get_odometer_reading(), $bus->get_odometer_read_date(), $bus->get_vin(), $bus->get_vin());
                        echo $table_row;
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>
