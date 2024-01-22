<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Facilities Management</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f6f6f6;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        width: 50%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    a {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #45a049;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: #fff;
    }

    .delete-btn {
        background-color: #f44336;
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
    }

    .delete-btn:hover {
        background-color: #d32f2f;
    }
    </style>
</head>

<body>

    <h2>Admin Facilities Management</h2>

    <form method="post">
        <label for="facilityID">FacilityID:</label>
        <input type="text" name="facilityID" required>

        <label for="facilityName">FacilityName:</label>
        <input type="text" name="facilityName" required>

        <label for="location">Location:</label>
        <input type="text" name="location" required>

        <label for="capacity">Capacity:</label>
        <input type="text" name="capacity" required>

        <label for="maintenanceSchedule">Maintenance Schedule:</label>
        <input type="text" name="maintenanceSchedule" required>

        <button type="submit" name="create">Create Facility</button>
        <a href="admin_page.php">Back</a>
    </form>

    <?php
   
     include("conn.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['create'])) {
            // Create new facility
            $facilityID = validateInput($_POST['facilityID']);
            $facilityName = validateInput($_POST['facilityName']);
            $location = validateInput($_POST['location']);
            $capacity = validateInput($_POST['capacity']);
            $maintenanceSchedule = validateInput($_POST['maintenanceSchedule']);

            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO Facilities (FacilityID, FacilityName, Location, Capacity, MaintenanceSchedule) 
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $facilityID, $facilityName, $location, $capacity, $maintenanceSchedule);

            if ($stmt->execute()) {
                echo "Facility created successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        if (isset($_POST['delete'])) {
            // Delete facility
            $facilityIDToDelete = validateInput($_POST['facilityIDToDelete']);

            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM Facilities WHERE FacilityID = ?");
            $stmt->bind_param("s", $facilityIDToDelete);

            if ($stmt->execute()) {
                echo "Facility deleted successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // SQL query to retrieve facilities data from Facilities table
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        // Output data in a table
        echo "<table>
                <tr>
                    <th>FacilityID</th>
                    <th>FacilityName</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Maintenance Schedule</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["FacilityID"] . "</td>
                    <td>" . $row["FacilityName"] . "</td>
                    <td>" . $row["Location"] . "</td>
                    <td>" . $row["Capacity"] . "</td>
                    <td>" . $row["MaintenanceSchedule"] . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='facilityIDToDelete' value='" . $row["FacilityID"] . "'>
                            <button type='submit' class='delete-btn' name='delete'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();

    function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

</body>

</html>